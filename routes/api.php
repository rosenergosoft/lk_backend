<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
        Route::post('documents',[UserController::class,'upload']);
        Route::get('documents',[UserController::class,'getDocuments']);
        Route::get('list',[UserController::class,'getList']);
    });
});
