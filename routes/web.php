<?php

use App\Http\Controllers\Admin\Banner;
use App\Http\Controllers\Admin\Brand;
use App\Http\Controllers\Admin\Category;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Product;
use App\Http\Controllers\Admin\User;
use App\Http\Controllers\Admin\Report;
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

Route::get('/', function () {
    return view('pages.login');
})->name('login')->middleware('guest');

Route::post('/', [User::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::prefix('product')->group(function () {
        Route::get('/', [Product::class, 'index'])->name('product.index');
        Route::get('/create', [Product::class, 'create'])->name('product.create');
        Route::post('/create', [Product::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [Product::class, 'edit'])->name('product.edit');
        Route::post('/edit/{id}', [Product::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [Product::class, 'delete'])->name('product.delete');
        Route::get('/oracle', [Product::class, 'oracle'])->name('product.oracle');
    });
    
    Route::prefix('brand')->group(function () {
        Route::get('/', [Brand::class, 'index'])->name('brand.index');
        Route::get('/create', [Brand::class, 'create'])->name('brand.create');
        Route::post('/create', [Brand::class, 'store'])->name('brand.store');
    });
    
    Route::prefix('category')->group(function () {
        Route::get('/', [Category::class, 'index'])->name('category.index');
        Route::post('/', [Category::class, 'store'])->name('category.store');
        Route::get('edit/{id}', [Category::class, 'edit'])->name('category.edit');
        Route::get('delete/{id}', [Category::class, 'delete'])->name('category.delete');
    });
    
    Route::prefix('banner')->group(function () {
        Route::get('/', [Banner::class, 'index'])->name('banner.index');
        Route::get('/create', [Banner::class, 'create'])->name('banner.create');
        Route::post('/create', [Banner::class, 'store'])->name('banner.store');
    });

    Route::prefix('report')->group(function () {
        Route::get('/', [Report::class, 'index'])->name('report.index');
        Route::get('/create', [Banner::class, 'create'])->name('banner.create');
        Route::post('/create', [Banner::class, 'store'])->name('banner.store');
    });

    Route::get('/phpinfo', [Dashboard::class, 'phpinfo'])->name('phpinfo');
    Route::get('admin', [Dashboard::class, 'index'])->name('admin');
    Route::get('edit-profile', [Dashboard::class, 'edit']);
    Route::any('logout', [User::class, 'logout']);
});