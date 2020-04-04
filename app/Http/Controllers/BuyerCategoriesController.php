<?php

namespace App\Http\Controllers;

use App\Buyer;

class BuyerCategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()->with('product.categories')
                ->get()
                ->pluck('product.categories')
                ->collapse()
                ->unique('id')
                ->values();
       return $this->showAll($categories);
    }


}
