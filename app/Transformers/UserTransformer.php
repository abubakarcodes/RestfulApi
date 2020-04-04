<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;
class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identifier' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'isAdmin' => ($user->admin === 'true'),
            'isVerified' => (int) $user->verified,
            'creationDate' => (string) $user->created_at,
            'changedDate' =>  (string) $user->updated_at,
            'deleteDate' => isset($user->deleted_at) ? (string) $user->deleted_at : null
        ];
    }



    public static function originalAttribute($index){
        $attributes =  [
            'identifier' =>  'id',
            'name' =>  'name',
            'email' =>  'email',
            'isAdmin' => 'admin',
            'isVerified' => 'verified',
            'creationDate' => 'created_at',
            'changedDate' => 'updated_at',
            'deleteDate' => 'deleted_at'
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
