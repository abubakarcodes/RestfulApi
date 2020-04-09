<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifier' => (int) $seller->id,
            'name' => (string) $seller->name,
            'email' => (string) $seller->email,
            'isVerified' => (int) $seller->verified,
            'creationDate' =>  (string) $seller->created_at,
            'changedDate' => (string) $seller->updated_at,
            'deleteDate' => isset($seller->deleted_at) ? (string) $seller->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('seller.show', $seller->id),
                ],
                [
                    'rel' => 'seller.products',
                    'href' => route('seller.products.index', $seller->id),
                ],
                [
                    'rel' => 'seller.sellers',
                    'href' => route('seller.categories.index', $seller->id),
                ],
                [
                    'rel' => 'seller.sellers',
                    'href' => route('seller.buyers.index', $seller->id),
                ],
                [
                    'rel' => 'seller.transactions',
                    'href' => route('seller.transactions.index', $seller->id),
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
