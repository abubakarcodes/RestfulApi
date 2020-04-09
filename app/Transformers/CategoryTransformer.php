<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'identifier' => (int) $category->id,
            'title' => (string) $category->name,
            'detail' => (string) $category->description,
            'creationDate' => (string) $category->created_at,
            'changedDate' => (string) $category->updated_at,
            'deleteDate' => isset($category->deleted_at) ? (string) $category->deleted_at : null,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('category.show', $category->id),
                ],
                [
                    'rel' => 'category.products',
                    'href' => route('category.products.index', $category->id),
                ],
                [
                    'rel' => 'category.buyers',
                    'href' => route('category.buyers.index', $category->id),
                ],
                [
                    'rel' => 'category.sellers',
                    'href' => route('category.sellers.index', $category->id),
                ],
                [
                    'rel' => 'category.transactions',
                    'href' => route('category.transactions.index', $category->id),
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
            'created_at' => 'creationDate',
            'updated_at' =>  'changedDate',
            'deleted_at' =>   'deleteDate'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
