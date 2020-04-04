<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryBuyersController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $buyers = $category->products()
                ->whereHas('transactions')
                ->with('transactions.buyer')
                ->get()
                ->pluck('transactions')
                ->collapse()
                ->pluck('buyer')
                ->unique('id')
                ->values();
        return $this->showAll($buyers);
    }


}
