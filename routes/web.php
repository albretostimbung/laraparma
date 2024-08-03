<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProductTransaction\ProductTransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::name('front.')->group(function() {
    Route::get('/', [FrontController::class, 'index'])->name('index');
    Route::get('/search', [FrontController::class, 'search'])->name('search');
    Route::get('/details/{product:slug}', [FrontController::class, 'details'])->name('product.details');
    Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('product.category');
    Route::get('/success-checkout', [FrontController::class, 'success'])->name('success-checkout');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('carts', CartController::class)->middleware('role:buyer');
    Route::resource('product-transactions', ProductTransactionController::class);

    Route::prefix('admin')->name('admin.')->group(function() {
        Route::middleware('role:owner')->group(function() {
            Route::resource('categories', CategoryController::class);
            Route::resource('products', ProductController::class);
        });
    });
});

require __DIR__.'/auth.php';
