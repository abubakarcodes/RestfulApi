<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int) $transaction->id,
            'quantity' => (int) $transaction->quantity,
            'buyer' => (int) $transaction->buyer_id,
            'product' => (int) $transaction->product_id,
            'creationDate' => $transaction->created_at,
            'changedDate' => $transaction->updated_at,
            'deleteDate' => isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transaction.show', $transaction->id),
                ],
                [
                    'rel' => 'transaction.categories',
                    'href' => route('transaction.categories.index', $transaction->id),
                ],
                [
                    'rel' => 'transaction.sellers',
                    'href' => route('transaction.seller.index', $transaction->id),
                ],
            ]
        ];
    }


    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier' =>  'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
            'creationDate' => 'created_at',
            'changedDate' => 'updated_at',
            'deleteDate' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes =  [
            'id' =>   'identifier',
            'quantity' =>     'quantity',
            'buyer_id' =>        'buyer',
            'product_id' =>      'product',
            'created_at' => 'creationDate',
            'updated_at' =>  'changedDate',
            'deleted_at' =>   'deleteDate'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
