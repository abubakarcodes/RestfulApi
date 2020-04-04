<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryProductsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $products = $category->products;
        return $this->showAll($products);
    }


}
