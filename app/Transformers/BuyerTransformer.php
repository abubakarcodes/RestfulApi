<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int) $buyer->id,
            'name' => (string) $buyer->name,
            'email' => (string) $buyer->email,
            'isVerified' => (int) $buyer->verified,
            'creationDate' => (string) $buyer->created_at,
            'changedDate' => (string) $buyer->updated_at,
            'deleteDate' => isset($buyer->deleted_at) ? (string) $buyer->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyer.show', $buyer->id),
                ],
                [
                    'rel' => 'buyer.products',
                    'href' => route('buyer.products.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.buyers',
                    'href' => route('buyer.categories.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href' => route('buyer.sellers.index', $buyer->id),
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyer.transactions.index', $buyer->id),
                ],
            ]
        ];
    }


    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier' =>  'id',
            'name' =>  'name',
            'email' =>  'email',
            'isVerified' => 'verified',
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
            'name' =>         'name',
            'email' =>        'email',
            'verified' =>   'isVerified',
            'created_at' => 'creationDate',
            'updated_at' =>  'changedDate',
            'deleted_at' =>   'deleteDate'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
