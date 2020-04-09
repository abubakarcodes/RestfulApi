<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Product;

class ProductTransformer extends TransformerAbstract
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
    public function transform(Product $product)
    {
        return [
            'identifier' => (int) $product->id,
            'title' => (string) $product->name,
            'detail' => (string) $product->description,
            'stock' => (int) $product->quantity,
            'situation' => (string) $product->status,
            'picture' => url("images/{$product->image}"),
            'seller' => (int) $product->seller_id,
            'creationDate' => (string)  $product->created_at,
            'changedDate' => (string) $product->updated_at,
            'deleteDate' => isset($product->deleted_at) ? (string) $product->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('product.show', $product->id),
                ],
                [
                    'rel' => 'product.products',
                    'href' => route('product.categories.index', $product->id),
                ],
                [
                    'rel' => 'product.buyers',
                    'href' => route('product.buyers.index', $product->id),
                ],
                [
                    'rel' => 'product.transactions',
                    'href' => route('product.transactions.index', $product->id),
                ],
            ]

        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identifier' =>  'id',
            'title' => 'name',
            'detail' => 'description',
            'stock' =>  'quantity',
            'situation' => 'status',
            'picture' => 'image',
            'seller' => 'seller_id',
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
            'name' =>        'title',
            'description' =>       'detail',
            'quantity' =>        'stock',
            'status' =>    'situation',
            'image' =>      'picture',
            'seller_id' =>       'seller',
            'created_at' => 'creationDate',
            'updated_at' =>  'changedDate',
            'deleted_at' =>   'deleteDate'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
