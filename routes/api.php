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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('/orders', \App\Http\Controllers\Api\OrderController::class);
Route::get('/products',[\App\Http\Controllers\Api\ProductController::class,'index']);
Route::get('/products-order/{order}',[\App\Http\Controllers\Api\OrderController::class,'getProductOrder']);
Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class,'register'])->name('register');
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class,'login'])->name('login');
Route::get('/user', [\App\Http\Controllers\Auth\AuthController::class,'user']);
