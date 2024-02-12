<?php

use App\Http\Controllers\Shop\BasketController;
use App\Http\Controllers\Shop\BrandController;
use App\Http\Controllers\Shop\CategoryController;
use App\Http\Controllers\Shop\CommentController;
use App\Http\Controllers\Shop\FeatureController;
use App\Http\Controllers\Shop\GalleryController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\ProductFeatureController;
use App\Http\Controllers\Shop\SellerController;
use Illuminate\Support\Facades\Route;


Route::resource('brand', BrandController::class)->except(['show', 'update']);

Route::post('brand/{brand}', [BrandController::class, 'update'])->name('brand.update');


Route::resource('seller', SellerController::class)->except(['show', 'update']);

Route::post('seller/{seller}', [SellerController::class, 'update'])->name('seller.update');


Route::get('basket-report', [BasketController::class, 'report'])->name('basket-report');


Route::resource('category', CategoryController::class)->except('update');

Route::prefix('category')->group(function() {

    Route::post('/addBatch', [CategoryController::class, 'uploadCategories'])->name('category.upload');

    Route::post('/{category}', [CategoryController::class, 'update'])->name('category.update');
    
    Route::get('/sub/{category}', [CategoryController::class, 'sub'])->name('category.sub');

});

Route::resource('category.features', FeatureController::class)->except('show', 'update')->shallow();

Route::post('feature/{feature}', [FeatureController::class, 'update'])->name('feature.update');


Route::resource('product', ProductController::class)->except(['show', 'update']);

Route::prefix('product')->group(function () {
    
    Route::post('/addBatch', [ProductController::class, 'addBatchProducts'])->name('product.addBatch');

    Route::get('/excel', [ProductController::class, 'excel'])->name('product.excel');

    Route::post('/{product}', [ProductController::class, 'update'])->name('product.update');
    
    Route::get('/off/{product}', [ProductController::class, 'editOff'])->name('product.off');
    
    Route::post('/removeOff/{product}', [ProductController::class, 'removeOff'])->name('product.removeOff');

    Route::post('/changeVisibility/{product?}', [ProductController::class, 'changeVisibility'])->name('product.changeVisibility');

    Route::post('/updateAvailableCount/{product?}', [ProductController::class, 'updateAvailableCount'])->name('product.updateAvailableCount');

});


Route::resource('product.comment', CommentController::class)->except('show', 'update')->shallow();

Route::post('comment/{comment}', [CommentController::class, 'update'])->name('comment.update');

Route::resource('product.productGallery', GalleryController::class)->except('show', 'update', 'edit')->shallow();

Route::resource('product.productFeature', ProductFeatureController::class)->only('index', 'store', 'destroy')->shallow();


Route::view('/panel', 'admin.home')->name('shop.panel');


?>