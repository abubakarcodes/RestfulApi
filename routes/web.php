<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/' ,  function (){
    return view('welcome');
});
Route::get('/home/get-tokens' , "HomeController@getTokens")->name('get-tokens');
Route::get('/home/passport-clients' , "HomeController@getClients")->name('passport-clients');
Route::get('/home/passport-authorized-clients' , "HomeController@getAuthorizedClients")->name('passport-authorized-clients');
