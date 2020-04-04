<?php

namespace App\Http\Controllers;

use App\Product;
class ProductTransactionsController extends ApiController
{
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
