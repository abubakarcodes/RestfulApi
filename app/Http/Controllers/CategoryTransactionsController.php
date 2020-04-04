<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryTransactionsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $transactions = $category->products()
                        ->whereHas('transactions')
                        ->with('transactions')
                        ->get()
                        ->pluck('transactions')
                        ->collapse();
        return $this->showAll($transactions);
    }


}
