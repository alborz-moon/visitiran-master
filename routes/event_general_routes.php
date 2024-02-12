<?php

use App\Http\Controllers\Event\EventBuyerController;
use App\Http\Controllers\Event\EventCommentController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\EventTagController;
use App\Http\Controllers\Event\LauncherCertificationsController;
use App\Http\Controllers\Event\LauncherCommentController;
use App\Http\Controllers\Event\LauncherController;
use App\Http\Controllers\LauncherFollowersController;
use Illuminate\Support\Facades\Route;

Route::get('events', [EventController::class, 'list'])->name('api.event.list');

Route::get('show-launcher/{launcher}', [LauncherController::class, 'show_user'])->name('api.launcher.show-user');



Route::post('/search-event', [EventController::class, 'search'])->name('event-search');

Route::post('search-event-tag', [EventTagController::class, 'search'])->name('search-event-tag');


Route::get('launchers', [LauncherController::class, 'list'])->name('api.launcher.list');

Route::get('top-launchers', [LauncherController::class, 'top'])->name('api.launcher.top');


Route::resource('launcher.launcher_comment', LauncherCommentController::class)->except('show', 'update')->shallow();

Route::post('launcher_comment/{launcher_comment}', [LauncherCommentController::class, 'update'])->name('launcher_comment.update');


Route::resource('event.event_comment', EventCommentController::class)->except('show', 'update')->shallow();

Route::post('event_comment/{event_comment}', [EventCommentController::class, 'update'])->name('event_comment.update');


Route::post('event_callback', [EventBuyerController::class, 'callback'])->name('event.callback');


Route::middleware(['myAuth'])->group(function() {

    
    Route::post('event-register/{event}', [EventBuyerController::class, 'register'])->name('api.event.register');


    Route::get('my-events', [EventBuyerController::class, 'list'])->name('api.my-events');

    Route::get('/getMyComments', [EventCommentController::class, 'getMyComments'])->name('api.comment.myevent');
    
    Route::get('/getMyBookmarks', [EventController::class, 'getMyBookmarks'])->name('api.events.my');


    Route::prefix('eventTags')->group(function() {
    
        Route::get('/list', [EventTagController::class, 'show'])->name('eventTags.show');
    
    });


    Route::resource('launcher', LauncherController::class)->except('edit', 'create', 'update');

    Route::resource('launcher.follow', LauncherFollowersController::class)->only('store')->shallow();


    Route::prefix('launcher')->group(function() {

        Route::get('/{launcher}/comments', [LauncherCommentController::class, 'list'])->name('launcher.launcher_comment.list');

        Route::post('/{launcher}', [LauncherController::class, 'update'])->name('launcher.update');

        Route::get('/{launcher}/files', [LauncherController::class, 'showFiles'])->name('launcher.files');
    
        Route::delete('/{launcher}/certificate', [LauncherController::class, 'removeFile'])->name('launcher.cert.destroy');

    });

    Route::prefix('event')->group(function() {

        Route::get('/{event}/comments', [EventCommentController::class, 'list'])->name('event.event_comment.list');

    });


    Route::resource('launcher.launcher_certifications', LauncherCertificationsController::class)->only('store')->shallow();

});


?>