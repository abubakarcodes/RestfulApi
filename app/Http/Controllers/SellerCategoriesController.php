<?php

namespace App\Http\Controllers;

use App\Seller;
use Illuminate\Http\Request;

class SellerCategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $categories = $seller->products()
                        ->whereHas('categories')
                        ->with('categories')
                        ->get()
                        ->pluck('categories')
                        ->collapse()
                        ->unique('id')
                        ->values();
        return $this->showAll($categories);
    }


}
