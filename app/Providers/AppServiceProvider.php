<?php

namespace App\Providers;

use App\Mail\UserChanged;
use App\Mail\UserCreated;
use App\Product;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\User;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //user created
        Schema::defaultStringLength(191);
        User::created(function($user){
           retry(5 , function() use($user){
            Mail::to($user)->send(new UserCreated($user));
           }, 100);
        });
        User::updated(function($user){
            if($user->isDirty('email')){
                retry(5, function() use($user){
                    Mail::to($user)->send(new UserChanged($user));
                }, 100);
            }
        });
        //product updated
        Product::updated(function($product){
            if($product->quantity == 0 && $product->isAvailable()){
                $product->status = Product::PRODUCT_UNAVAILABLE;
                $product->save();
            }
        });
    }
}
