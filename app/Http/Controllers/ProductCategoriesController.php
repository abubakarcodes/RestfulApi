<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ProductCategoriesController extends ApiController
{
    public function __construct()
    {   $this->middleware('auth:api')->except(['index']);
        $this->middleware('client.credentials')->only(['index']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        //attach(can add dublicate enteries),
        //sync(can add one and remove others),
        //syncWithoutDetaching(can add one without dublicate)
        $product->categories()->syncWithoutDetaching([$category->id]);
        return $this->showAll($product->categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        if(!($product->categories()->find($category->id))){
            // return response()->json(['data' => 'the specified category doesnot belong to specific product'] , 404);
            return $this->errorResponse('the specified category doesnot belongs to specific product' , 409);
        }

        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }
}
