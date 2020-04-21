<?php

namespace App\Http\Controllers;

use App\Buyer;

class BuyerSellersController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {

        $sellers = $buyer->transactions()->with('product.seller')
                    ->get()
                    ->pluck('product.seller')
                    ->unique('id')
                    ->values();
        // return response()->json(['data'=> $sellers] , 200);
        return $this->showAll($sellers);
    }


}
