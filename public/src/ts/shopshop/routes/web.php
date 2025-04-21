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

/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/', function () {
    return view('index');
});*/

Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart/del-item/{product_id}', [\App\Http\Controllers\CartController::class, 'delItem'])->name('cart.del_item');
Route::get('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/show', [\App\Http\Controllers\CartController::class, 'show'])->name('cart.show');
Route::match(['get', 'post'], '/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
//Route::get('/', '\App\Http\Controllers\ProductController@index')->name('home');
