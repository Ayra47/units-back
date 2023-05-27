<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('me', 'me');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'getAll');
    Route::get('products/one/{id}', 'getOne');
    Route::get('products/farmer/{id}', 'getFarmers');
    Route::post('products', 'create');
    Route::delete('products/item/{id}', 'deleteItem');
});

Route::controller(CartController::class)->group(function () {
    Route::get('cart', 'getCart');
    Route::post('cart/item/{product_id}', 'addItem');
    Route::post('cart/item/{product_id}', 'addItem');
    Route::delete('cart/item/product/{id}', 'removeItem');
});