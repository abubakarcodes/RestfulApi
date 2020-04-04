<?php

namespace App\Http\Controllers;

use App\Seller;

class SellerTransactionsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
                        ->whereHas('transactions')
                        ->with('transactions')
                        ->get()
                        ->pluck('transactions')
                        ->collapse();
        return $this->showAll($transactions);
    }


}
