<?php

use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\LauncherController;
use App\Http\Controllers\Event\EventTagController;
use App\Http\Controllers\Event\FacilityController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::resource('launcher', LauncherController::class)->except('update', 'store', 'show');

Route::prefix('launcher')->group(function() {

    Route::post('/changeStatus', [LauncherController::class, 'changeStatus'])->name('launcher.changeStatus');

    Route::prefix('/{launcher}')->group(function() {
    });

});

Route::resource('facilities', FacilityController::class)->except('update', 'show');

Route::prefix('facilities')->group(function() {

    Route::post('/{facility}', [FacilityController::class, 'update'])->name('facilities.update');

});


Route::resource('eventTags', EventTagController::class)->except('update', 'show');

Route::prefix('eventTags')->group(function() {
    
    Route::post('/{eventTag}', [EventTagController::class, 'update'])->name('eventTags.update');

});


Route::post('event/changeStatus', [EventController::class, 'changeStatus'])->name('event.changeStatus');

Route::post('event/changeIsInTopList', [EventController::class, 'changeIsInTopList'])->name('event.changeIsInTopList');

Route::post('searchUsersForLauncherCandidate', [UserController::class, 'searchUsersForLauncherCandidate'])->name('searchUsersForLauncherCandidate');

Route::view('/panel', 'admin.home')->name('event.panel');

?>