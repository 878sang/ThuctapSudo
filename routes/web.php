<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Client\CategoriesClientController;
use App\Http\Controllers\Client\ProductClientController;
use App\Http\Controllers\Client\CartClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('categories', [CategoriesClientController::class, 'showClient'])->name('categories.showClient');
Route::get('categories/{id}', [CategoriesClientController::class, 'detailClient'])->name('categories.detailClient');
Route::get('products/{id}', [ProductClientController::class, 'productDetailClient'])->name('products.detailClient');
Route::get('cart', [CartClientController::class, 'cartClient'])->name('cart.showClient');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('categories')->middleware('role')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/{id}', [CategoriesController::class, 'show'])->name('categories.show');
        Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::put('/{id}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::patch('/{id}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
        Route::get('/{id}/check', [CategoriesController::class, 'checkHasProducts'])->name('categories.check');
        Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    });
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::get('/{slug}/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::patch('/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
    Route::prefix('brands')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::get('/{slug}/{id}', [BrandController::class, 'show'])->name('brands.show');
        Route::put('/{id}', [BrandController::class, 'update'])->name('brands.update');
        Route::patch('/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
        Route::delete('/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    });
});
