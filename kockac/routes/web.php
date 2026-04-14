<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
