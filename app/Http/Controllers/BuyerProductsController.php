<?php

namespace App\Http\Controllers;
use App\Buyer;
class BuyerProductsController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,buyer')->only('index');
    }
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
