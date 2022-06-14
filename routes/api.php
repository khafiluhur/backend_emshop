<?php

use App\Http\Controllers\Api\Banner;
use App\Http\Controllers\Api\Category;
use App\Http\Controllers\Api\Product;
use App\Http\Controllers\Api\Users;
use Faker\Provider\Base;
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
Route::post('/register', [Users::class, 'register']);
Route::post('/login', [Users::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });

    Route::get('/product/search', [Product::class, 'searchProduct']);

    Route::get('/product', [Product::class, 'index']);
    Route::get('/product/{id}', [Product::class, 'detail']);
    Route::get('/product/category/{id}', [Product::class, 'category']);
    Route::get('/product/exclusive/{id}', [Product::class, 'exclusive']);
    Route::get('/product/toggle/{id}', [Product::class, 'updateActiveProduct']);
    Route::get('/product/click/{id}', [Product::class, 'countEcommerceProduct']);
    Route::get('/product/view/{id}', [Product::class, 'viewEcommerceProduct']);

    Route::get('/banner', [Banner::class, 'index']);
    Route::get('/page/{id}', [Banner::class, 'index']);
    Route::get('/banner/toggle/{id}', [Product::class, 'updateActiveBanner']);

    Route::get('/category', [Category::class, 'index']);

    // API route for logout user
    Route::post('/logout', [Users::class, 'logout']);
});

