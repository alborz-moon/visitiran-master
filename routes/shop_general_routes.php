<?php

use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Shop\AddressController;
use App\Http\Controllers\Shop\BasketController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CategoryController;
use App\Http\Controllers\Shop\CommentController;

use Illuminate\Support\Facades\Route;

Route::post('search-product', [ProductController::class, 'search'])->name('product-search');

Route::post('search-category', [CategoryController::class, 'search'])->name('category-search');

Route::get('product/{product?}', [ProductController::class, 'show'])->name('api.product.show');

Route::get('products', [ProductController::class, 'list'])->name('api.product.list');

Route::get('similar_products/{product}', [ProductController::class, 'similars'])->name('api.product.similars');

Route::get('category', [CategoryController::class, 'list'])->name('api.category.menu');

Route::get('top-categories/{category?}', [CategoryController::class, 'top'])->name('api.category.top');

Route::get('get_top_categories_products', [CategoryController::class, 'get_top_categories_products'])->name('api.get_top_categories_products');



Route::get('shop_callback', [EventController::class, 'callback'])->name('shop.callback');

Route::middleware(['myAuth'])->group(function() {


    Route::post('check_basket', [BasketController::class, 'check_basket'])->name('api.check_basket');

    Route::post('refresh_basket', [BasketController::class, 'refresh_basket'])->name('api.refresh_basket');

    Route::post('finalize_basket', [BasketController::class, 'finalize_basket'])->name('api.finalize_basket');


    Route::get('get_my_orders', [BasketController::class, 'getMyOrders'])->name('api.getMyOrders');

    Route::get('get_order/{purchase}', [BasketController::class, 'getOrder'])->name('api.getOrder');

    Route::get('/get_recp/{purchase}', [BasketController::class, 'generateRecpPDF'])->name('api.get_recp');


    Route::prefix('product/{product}')->group(function() {

        Route::get('/comment', [CommentController::class, 'list'])->name('api.product.comment.list');

        Route::post('/comment', [CommentController::class, 'store'])->name('api.product.comment.store');

    });
    
    Route::get('/getMyComments', [CommentController::class, 'getMyComments'])->name('api.comment.my');
    
    Route::get('/getMyBookmarks', [ProductController::class, 'getMyBookmarks'])->name('api.product.my');
    
    Route::resource('address', AddressController::class)->only('store', 'index');
    
    Route::post('address/{address?}', [AddressController::class, 'update'])->name('address.update');

    Route::delete('address/{address?}', [AddressController::class, 'destroy'])->name('address.destroy');

});

?>