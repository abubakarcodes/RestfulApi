<?php

namespace App\Providers;

use App\Buyer;
use App\Policies\BuyerPolicy;
use App\Policies\SellerPolicy;
use App\Policies\UserPolicy;
use App\Seller;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Illuminate\Support\Carbon;
use App\User;
use App\Transaction;
Use App\Policies\TransactionPolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       Buyer::class => BuyerPolicy::class,
       Seller::class => SellerPolicy::class,
       User::class => UserPolicy::class,
       Transaction::class => TransactionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addMinutes(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::enableImplicitGrant();
        Passport::tokensCan([
            'purchase-product' => 'create transactions for the products',
            'manage-products' => 'create, update and delete the products (CRUD)',
            'manage-account'  => 'read your id, name, email if verfied, if admin cann read the password
                        modify the account data, cannot delete account.',
            'read-general' => 'read general information like purchasing categories, purchase products, your transactions like sale, purchasing etc.',
        ]);
    }
}
