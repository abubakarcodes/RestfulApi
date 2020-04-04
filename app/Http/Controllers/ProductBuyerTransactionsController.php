<?php

namespace App\Http\Controllers;

use App\Product;
use App\Transaction;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionsController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $validation = validator($request->all(), [
            'quantity' => 'required|min:1'
        ]);
        if($validation->fails()){
            return response()->json(['errors' => $validation->errors()] , 400);
        }

        if($buyer->id == $product->seller_id){
            return $this->errorResponse('buyer must be different from seller' , 409);
        }
        if(!($product->isAvailable())){
            return $this->errorResponse('This product is not available' , 409);
        }

        if(!($product->seller->isVerified())){
            return $this->errorResponse('A seller must be a verified User', 409);
        }
        if($product->quantity < $request->quantity){
            return $this->errorResponse('The product doesnot have enough unit for transaction' , 409);
        }


   return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();
            $transaction =  Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,

            ]);
            return $this->showOne($transaction , 201);
        });


    }


}
