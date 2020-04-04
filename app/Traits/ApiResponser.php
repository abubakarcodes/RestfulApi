<?php
namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponser
{

private function successResponse($data , $code){
        return response()->json($data , $code);
 }

protected function errorResponse($message , $code){
    return response()->json(['error' => $message, 'code' => $code] , $code);
 }


  protected function showAll(Collection $collection , $code = 200){
      if($collection->isEmpty()){
          return $this->successResponse(['data' => $collection], $code);
      }
      $transformer = $collection->first()->transformer;
      $collection = $this->filterData($collection , $transformer);
      $collection = $this->sortData($collection , $transformer);
      $collection = $this->paginate($collection);
      $collection = $this->transformer($collection , $transformer);
      $collection = $this->cacheResponse($collection);
    return $this->successResponse($collection , $code);
  }


  protected function showOne(Model $model , $code = 200){
      $transformer = $model->transformer;
      $model = $this->transformer($model , $transformer);
    return $this->successResponse($model , $code);
  }

  protected function showMessage($message , $code = 200){
      return $this->successResponse($message , $code);
  }

  protected function transformer($data , $transformer){
      $transformation = fractal($data , new $transformer);

      return $transformation->toArray();
  }

  protected function sortData(Collection $collection , $transformer){
      if(request()->has('sort_by')){
          $attributes = $transformer::originalAttribute(request()->sort_by);
          $collection = $collection->sortBy->{$attributes};
      }

      return $collection;
  }



  protected function filterData(Collection $collection, $tranformer){
    foreach(request()->query() as $query => $value){
        $attributes = $tranformer::originalAttribute($query);
        if(isset($attributes , $value)){
            $collection = $collection->where($attributes , $value);
        }
    }

    return $collection;
  }


  protected function paginate(Collection $collection){
      $rules = [
          'per_page' => 'integer|min:2|max:50'
      ];

      Validator::make(request()->all(), $rules);
      if(request()->has('per_page')){
          $perPage = request()->per_page;
      }
      $page = PaginationLengthAwarePaginator::resolveCurrentPage();
      $perPage = 15;
      if(request()->has('per_page')){
        $perPage = (int) request()->per_page;
      }
      $result = $collection->slice(($page - 1) * $perPage , $perPage)->values();
      $paginated = new PaginationLengthAwarePaginator($result , $collection->count() , $perPage , $page , [
          'path' => PaginationLengthAwarePaginator::resolveCurrentPath(),
      ]);

      $paginated->appends(request()->all());

      return $paginated;
  }



  protected function cacheResponse($data){
      $url = request()->url();
      $queryParams = request()->query();
      ksort($queryParams);
      $queryString = http_build_query($queryParams);
      $fullUrl = '{$url}?{$queryParams}';
      return Cache::remember($fullUrl, 30/60 , function () use($data){
            return $data;
      });
  }





}
