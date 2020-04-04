<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Category;
use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Transaction;
use App\Seller;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('secret'), // password
        'remember_token' => Str::random(10),
        'verified' => $verified = $faker->randomElement([User::VERIFIED_USER , User::UNVERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerficationCode(),
        'admin' => $faker->randomElement([User::ADMIN_USER , User::REGULAR_USER])
    ];
});


$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1)

    ];
});


$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement([Product::PRODUCT_AVAILABLE , Product::PRODUCT_UNAVAILABLE]),
        'image' => $faker->randomElement(['1.jpg' , '2.jpg' , '3.jpg']),
        'seller_id' => User::all()->random()->id,

    ];
});


$factory->define(Transaction::class, function (Faker $faker) {
    $seller = Seller::has('products')->get()->random();
    $buyer = User::all()->except($seller->id)->random();
    return [
        'quantity' => $faker->numberBetween(1,10),
        'buyer_id' => $buyer->id,
        'product_id' => $seller->products->random()->id,
    ];
});
