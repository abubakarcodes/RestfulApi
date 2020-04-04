<?php

namespace App\Http\Controllers;
use App\Category;

class CategorySellersController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $sellers = $category->products()->with('seller')
                    ->get()
                    ->pluck('seller')
                    ->unique()
                    ->values();
        return $this->showAll($sellers);
    }


}
