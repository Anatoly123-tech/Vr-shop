<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\Table\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');


Route::get('/category/{slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

Route::get('/product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart/show', [\App\Http\Controllers\CartController::class, 'show'])->name('cart.show');
Route::get('/cart/del-item/{product_id}', [\App\Http\Controllers\CartController::class, 'delItem'])->name('cart.del_item');
Route::match(['get', 'post'], '/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::group(['namespace' => 'Table'], function () {
        Route::get('/table', [App\Http\Controllers\Admin\Table\AdminController::class, 'index'])->name('admin.table.index');
        Route::post('/table/{id}/update', [AdminController::class, 'update'])->name('admin.table.update');

        Route::get('create', [AdminController::class, 'create'])->name('admin.table.create');
        Route::post('store', [AdminController::class, 'store'])->name('admin.table.store');
        Route::post('delete', [AdminController::class, 'delete'])->name('admin.table.delete');
    });
});

Route::middleware('auth')->group(function () {

    Route::get('verify-email', function () {
        return view('user.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('home');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();


        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:3.1')->name('verification.send');

    Route::get('logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');
});



Route::middleware('guest')->group(function () {
    Route::get('register', [App\Http\Controllers\UserController::class, 'create'])->name('register');
    Route::post('register', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');

    Route::get('login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
    Route::post('login', [App\Http\Controllers\UserController::class, 'loginAuth'])->name('login.auth');

    Route::get('forgot-password', function () {
        return view('user.forgot-password');
    })->name('password.request');

    Route::post('forgot.password', [UserController::class, 'forgotPasswordStore'])->name('password.email')->middleware('throttle:3,1');

    Route::get('reset-password/{token}', function (string $token) {
        return view('user.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('reset-password', [UserController::class, 'resetPasswordUpdate'])->name('password.update');
});

Route::middleware(['auth', 'admin.email'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
