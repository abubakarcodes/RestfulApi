<?php

namespace App\Http\Controllers;
use App\Category;

class CategorySellersController extends ApiController
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
