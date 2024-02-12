<?php

use App\Http\Controllers\Shop\OffController;
use Illuminate\Support\Facades\Route;

Route::post('check-off', [OffController::class, 'check'])->name('checkoff');

?>