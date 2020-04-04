<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buyer;
class BuyersController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyers = Buyer::has('transactions')->get();
        return $this->showAll($buyers);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        //we need to add scopes for the model binding in laravel for extended models
        //so first we make a folder scopes and with in the scopes folder create a BuyerScope
        //with the namespace of App\Scopes and then we will create a class with name of BuyerScope
        //in the class the we will implements class with the scope interface and then we will use
        // a method apply(Builder $builder , Model $model)
        //then in the Buyer.php will use boot Method go and see.
        return $this->showOne($buyer);
    }


}
