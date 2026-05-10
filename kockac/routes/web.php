<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController;

Route::get('/', [IndexController::class, 'index']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products/{id}/cart', [ProductController::class, 'addToCart']);

Route::get('/cart', [CartController::class, 'show']);
Route::patch('/cart/{cartItem}/update', [CartController::class, 'update']);
Route::delete('/cart/{cartItem}', [CartController::class, 'destroy']);

Route::get('/products', [ProductController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'show']);
    Route::put('/account', [AccountController::class, 'update']);
    Route::get('/account/orders', [AccountController::class, 'orders']);
    Route::get('/account/change-password', [AccountController::class, 'changePassword']);
    Route::put('/account/change-password', [AccountController::class, 'updatePassword']);
    Route::get('/account/logout', function() {
        return view('myaccount.logout');
    });
});


Route::get('/checkout', [CheckoutController::class, 'show'])->middleware('not.admin');
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('not.admin');
Route::get('/order-success', function () {
    return view('order-success');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::middleware('is.admin')->group(function () {
    Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [ProductController::class, 'update']);
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/add-product-admin', function () {
        return view('admin.add-product-admin');
    })->name('admin.add.product');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
});

Route::get('/admin/images', [ImageController::class, 'index']);
Route::post('/admin/images/upload', [ImageController::class, 'upload']);
Route::post('/admin/images/{id}/attach', [ImageController::class, 'attach']);
Route::post('/admin/images/{id}/detach', [ImageController::class, 'detach']);
Route::delete('/admin/images/{id}', [ImageController::class, 'destroy']);

Route::post('products/{id}/reviews', [ReviewController::class, 'store']);

Route::get('/footer/terms-conditions', function() {
    return view('footer.terms-conditions');
})->name('terms-and-conditions');
Route::get('/footer/privacy-policy', function() {
    return view('footer.privacy-policy');
})->name('privacy-policy');
