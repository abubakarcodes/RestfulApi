<?php

namespace App\Http\Controllers;
use App\Buyer;
class BuyerProductsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
       $products = $buyer->transactions()->with('product')->get()->pluck('product');
       return $this->showAll($products);
    }


}
