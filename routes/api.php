<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubscribeController;

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

//public
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categoryCreate', [CategoryController::class, 'store']);
Route::put('/categoryUpdate/{id}', [CategoryController::class, 'update']);

Route::get('/products', [ProductController::class, 'index']);
Route::post('/productCreate', [ProductController::class, 'store']);
Route::put('/productUpdate/{id}', [ProductController::class, 'update']);

//protected
Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/subscribe/{user_id?}', [SubscribeController::class, 'index']);
    Route::post('/subscribe', [SubscribeController::class, 'store']);
    Route::post('/cancel_subscribe', [SubscribeController::class, 'cancel']);
});

