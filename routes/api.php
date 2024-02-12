<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\InfoBoxController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('testUpload', [HomeController::class, 'testUpload'])->name('api.testUpload');

Route::get('getDesc/{category?}', [HomeController::class, 'getDesc'])->name('api.getDesc');

Route::get('faq', [FAQController::class, 'list'])->name('api.faq');

Route::get('banner', [BannerController::class, 'list'])->name('api.banner');

Route::get('slider', [SliderController::class, 'list'])->name('api.slider');

Route::post('submitMail', [MailController::class, 'submitMail'])->name('api.submitMail');

Route::get('infobox', [InfoBoxController::class, 'list'])->name('api.infobox');

Route::get('cities', [HomeController::class, 'getCities'])->name('api.cities');

Route::post('editInfo', [ProfileController::class, 'editInfo'])->name('api.editInfo');

Route::post('login', [AuthController::class, 'signUp'])->name('api.login');

Route::post('activate', [AuthController::class, 'activate'])->name('api.signup.verify');

Route::domain(Controller::$SHOP_SITE)->group(base_path('routes/shop_general_routes.php'));

Route::domain(Controller::$EVENT_SITE)->group(base_path('routes/event_general_routes.php'));

Route::resource('form', FormController::class)->only('index', 'store', 'destroy');

Route::post('form/{form}', [FormController::class, 'update']);

Route::get('get-all-states', [FormController::class, 'getAllStates']);