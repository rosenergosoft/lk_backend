<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DisclosureController;

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
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::get('user', [AuthController::class,'me']);
});

Route::post('registration',[AuthController::class,'registration']);

Route::group(['middleware' => 'api'],function ($router) {
    Route::group(['prefix' => 'user'], function () {
        Route::post('/',[UserController::class,'save']);
        Route::post('profile',[UserController::class,'saveProfile']);
        Route::post('company',[UserController::class,'saveCompany']);
        Route::delete('company',[UserController::class,'deleteCompany']);
        Route::post('documents',[UserController::class,'upload']);
        Route::get('documents',[UserController::class,'getDocuments']);
        Route::get('list',[UserController::class,'getList']);
    });

    Route::group(['prefix' => 'application'], function () {
        Route::get('draft',[ApplicationController::class,'getDraft']);
        Route::get('get/{id}',[ApplicationController::class,'getApplication']);
        Route::post('draft',[ApplicationController::class,'draft']);
        Route::post('create',[ApplicationController::class,'create']);
    });

    Route::group(['prefix' => 'disclosure'], function () {
        Route::get('getByType/{group}/{type}',[DisclosureController::class,'getByType']);
        Route::get('getList/{group}',[DisclosureController::class,'getList']);
        Route::post('fileUpload',[DisclosureController::class,'fileUpload']);
    });
});
