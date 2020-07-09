<?php

namespace App\Http\Controllers;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
class CategoriesController extends ApiController
{
    public $categoryRespository;


    public function __construct(CategoryRepository $categoryRespository)
    {
        $this->categoryRespository = $categoryRespository;
        $this->middleware('auth:api')->except(['index' , 'show']);
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('transform.input:' . CategoryTransformer::class)->only(['store' , 'update']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRespository->all();
        return $this->showAll($categories);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',

        ];
        $this->validate($request , $rules);
        // $validation = validator($request->all() , $rules);
        // if($validation->fails()){
        //     return $this->errorResponse($validation->errors() , 400);
        // }

       $category = $this->categoryRespository->create($request->all());

        return $this->showOne($category , 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $category = $this->categoryRespository->show($category);
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category)
    {
        $category = $this->categoryRespository->show($category);
        $category->fill($request->only([
            'name',
            'description'
        ]));

        if($category->isClean()){
            return $this->errorResponse('you must change or specify the category' , 422);

        }

        $category->save();

        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        $category = $this->categoryRespository->delete($category);
        return $this->showOne($category);
    }
}
