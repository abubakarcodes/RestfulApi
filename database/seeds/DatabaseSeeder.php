<?php

use App\Transaction;
use App\Product;
use App\User;
use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();


        $users = 1000;
        $categories = 10;
        $products = 300;
        $transactions = 100;
        factory(User::class , $users)->create();
        factory(Category::class , $categories)->create();
        factory(Product::class , $products)->create()->each(
            function($product){
                $categories = Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            }
        );


        factory(Transaction::class , $transactions)->create();


    }
}
