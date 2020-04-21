<?php

namespace App\Http\Controllers;

use App\Product;
class ProductTransactionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $transactions = $product->transactions;
        return $this->showAll($transactions);
    }


}
