<?php

namespace App\Http\Controllers;

use App\Seller;
use App\User;
use Illuminate\Http\Request;
use App\Product;
use App\Transformers\SellerTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductsController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . SellerTransformer::class)->only(['store' , 'update']);
        $this->middleware('scope:manage-products')->except('index');
        $this->middleware('can:view,seller')->only('index');
        $this->middleware('can:sale,seller')->only('store');
        //in the seller policy we use the function editProduct as edit-product
        $this->middleware('can:edit-product,seller')->only('update');
        $this->middleware('can:delete-product,seller')->only('destroy');



    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {   if(request()->user()->tokenCan('read-general') || request()->user()->tokenCan('manage-products')){

        $products = $seller->products;
        return $this->showAll($products);
        }


       throw new AuthorizationException('invalid scope(s)');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $seller)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image',
            'quantity' => 'required|integer|min:1',
        ];

        // $validation = validator($request->all() , $rules);
        // if($validation->fails()){
        //     return $this->errorResponse($validation->errors() , 400);
        // }

        $this->validate($request , $rules);
        $fileName = $this->uploadImage($request);
        $data = $request->all();
        $data['image'] = $fileName;
        $data['seller_id'] = $seller->id;
        $data['status'] = Product::PRODUCT_UNAVAILABLE;
        $product = Product::create($data);
        return $this->showOne($product , 201);


    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */

    protected function sellerCheck(Seller $seller , Product $product){
        if($seller->id != $product->seller_id){
            throw new HttpException(422 , 'the specified seller is not the actual seller of the product');
        }
    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $rules = [
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::PRODUCT_UNAVAILABLE . ',' . Product::PRODUCT_AVAILABLE,
        ];

        // $validation = validator($request->all(), $rules);
        // if($validation->fails()){
        //     return $this->errorResponse($validation->errors() , 400);
        // }
        $this->validate($request , $rules);
        $this->sellerCheck($seller , $product);
        $product->fill($request->only([
            'name',
            'description',
            'quantity',
        ]));
        if($request->has('status')){
            $product->status = $request->status;
            if($product->isAvailable() && $product->categories->count() == 0){
                return $this->errorResponse('an active product must have atleast one category' , 409);
            }
        }

        if($product->isClean()){
            return $this->errorResponse('you need to specify different value to update' , 422);
        }

            if($request->hasFile('image')){
                Storage::delete($product->image);
            }

            $fileName = $this->uploadImage($request);
            $product->image = $fileName;

           $product->save();

        return $this->showOne($product);


    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller , Product $product)
    {
        $this->sellerCheck($seller , $product);
        $product->delete();
        Storage::delete($product->image);
        return $this->showOne($product);
    }


    protected function uploadImage($request){
        if($request->hasFile('image')){
            $fileNameWithExtension = $request->file('image')->getClientOriginalName();
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileNamewithOutExtension = pathinfo($fileNameWithExtension , PATHINFO_FILENAME);
            $fileNameToStore = $fileNamewithOutExtension . time() . '.' . $fileExtension;
            $request->file('image')->storeAs('' , $fileNameToStore);
            return $fileNameToStore;
        }
    }


}
