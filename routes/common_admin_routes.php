<?php

use App\Http\Controllers\SliderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\InfoBoxController;
use App\Http\Controllers\Shop\OffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::resource('off', OffController::class)->except(['show', 'update']);

Route::post('off/{off}', [OffController::class, 'update'])->name('off.update');



Route::resource('infobox', InfoBoxController::class)->except(['show', 'update']);

Route::post('infobox/{infobox}', [InfoBoxController::class, 'update'])->name('infobox.update');


Route::resource('users', UserController::class)->except(['show', 'update'])->middleware('adminLevel');

Route::post('users/{user}', [UserController::class, 'update'])->name('users.update');

Route::post('change', [UserController::class, 'change'])->name('users.change');


Route::resource('slider', SliderController::class)->except(['show', 'update']);

Route::post('slider/{slider}', [SliderController::class, 'update'])->name('slider.update');



Route::resource('banner', BannerController::class)->except(['show', 'update']);

Route::post('banner/{banner}', [BannerController::class, 'update'])->name('banner.update');



Route::resource('faq', FAQController::class)->except(['show', 'update']);

Route::post('faq/{faq}', [FAQController::class, 'update'])->name('faq.update');



Route::resource('mail', MailController::class)->except('show', 'update', 'edit');

Route::get('mail_users', [MailController::class, 'users'])->name('mail.users');


Route::post('uploadImg', [HomeController::class, 'uploadImg'])->name('uploadImg');


Route::resource('config', ConfigController::class)->only(['index']);

Route::post('config', [ConfigController::class, 'update'])->name('config.update');


Route::resource('blog', BlogController::class)->except(['show', 'update']);

Route::post('blog/addBatch', [BlogController::class, 'addBatch'])->name('blog.addBatch');

Route::post('blog/{blog}', [BlogController::class, 'update'])->name('blog.update');

?>