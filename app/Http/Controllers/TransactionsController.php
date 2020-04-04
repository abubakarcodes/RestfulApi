<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Transaction;

class TransactionsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }

}
