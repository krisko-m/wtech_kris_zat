<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('index');
});

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products/{id}/cart', [ProductController::class, 'addToCart']);

Route::get('/cart', [CartController::class, 'show']);
Route::patch('/cart/{cartItem}/update', [CartController::class, 'update']);
Route::delete('/cart/{cartItem}', [CartController::class, 'destroy']);

Route::get('/products', [ProductController::class, 'index']);

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
    });
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
});
