<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// user routes
Route::resource('user', 'UserController' ,['except' => ['create' , 'edit']]);
Route::get('user/verify/{token}' , 'UserController@verify')->name('verify');
Route::get('user/{user}/resend' , 'UserController@resend')->name('resend');
//buyer routes
Route::resource('buyer', 'BuyersController' ,['except' => ['create' , 'edit']]);
Route::resource('buyer.transactions', 'BuyerTransactionsController' ,['only' => ['index']]);
Route::resource('buyer.products', 'BuyerProductsController' ,['only' => ['index']]);
Route::resource('buyer.sellers', 'BuyerSellersController' ,['only' => ['index']]);
Route::resource('buyer.categories', 'BuyerCategoriesController' ,['only' => ['index']]);
// Seller routes
Route::resource('seller', 'SellersController' ,['except' => ['create' , 'edit']]);
Route::resource('seller.transactions', 'SellerTransactionsController' ,['only' => ['index']]);
Route::resource('seller.categories', 'SellerCategoriesController' , ['only' => ['index']]);
Route::resource('seller.buyers', 'SellerBuyersController' , ['only' => ['index']]);
Route::resource('seller.products', 'SellerProductsController' , ['except' => ['create' , 'edit' , 'show']]);

//product routes
Route::resource('product', 'ProductsController' ,['only' =>['index' , 'show']]);
Route::resource('product.transactions', 'ProductTransactionsController' ,['only' =>['index']]);
Route::resource('product.buyers', 'ProductBuyersController' ,['only' =>['index']]);
Route::resource('product.categories', 'ProductCategoriesController' ,['only' =>['index' , 'update' , 'destroy']]);
Route::resource('product.buyer.transactions', 'ProductBuyerTransactionsController' ,['only' =>['store']]);
//category routes
Route::resource('category', 'CategoriesController' ,['except' => ['create' , 'edit']]);
Route::resource('category.products', 'CategoryProductsController' ,['only' => ['index']]);
Route::resource('category.sellers', 'CategorySellersController' ,['only' => ['index']]);
Route::resource('category.transactions', 'CategoryTransactionsController' ,['only' => ['index']]);
Route::resource('category.buyers', 'CategoryBuyersController' ,['only' => ['index']]);
//Transaction routes
Route::resource('transaction', 'TransactionsController' ,['only' => ['index' , 'show']]);
Route::resource('transaction.categories', 'TransactionCategoryController' ,['only' => ['index']]);
Route::resource('transaction.seller', 'TransactionSellerController' ,['only' => ['index']]);


Route::post('oauth/token' , '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
