<?php

namespace App\Http\Controllers;
use App\Product;
class ProductsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index' , 'show']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return $this->showAll($products);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }

}
