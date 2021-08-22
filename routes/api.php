<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DisclosureController;
use App\Http\Controllers\AppealsController;

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

Route::group(['middleware' => ['api','active']],function ($router) {
    Route::group(['prefix' => 'client'], function () {
        Route::get('/',[ClientController::class,'get']);
        Route::post('/save',[ClientController::class,'save']);
        Route::get('/list',[ClientController::class,'list']);
        Route::post('/switch',[ClientController::class,'switchClient']);
    });
    Route::group(['prefix' => 'user'], function () {
        Route::post('/',[UserController::class,'update']);
        Route::post('profile',[UserController::class,'saveProfile']);
        Route::post('company',[UserController::class,'saveCompany']);
        Route::delete('company',[UserController::class,'deleteCompany']);
        Route::post('documents',[UserController::class,'upload']);
        Route::get('documents/{id}',[UserController::class,'getDocuments']);
        Route::delete('documents',[UserController::class,'deleteDocument']);
        Route::get('document/sign',[UserController::class,'getDocumentForSign']);
        Route::post('document/sign',[UserController::class,'signDocument']);
        Route::post('document/unsign',[UserController::class,'unsignDocument']);
        Route::post('document/sendSms',[UserController::class,'sendSms']);
        Route::get('list',[UserController::class,'getList']);
        Route::get('{id}',[UserController::class,'getUser']);
        Route::post('save',[UserController::class,'save']);
    });

    Route::group(['prefix' => 'vendor'], function () {
        Route::get('/list',[VendorController::class, 'list']);
    });

    Route::group(['prefix' => 'application'], function () {
        Route::get('list',[ApplicationController::class,'list']);
        Route::get('counts',[ApplicationController::class,'getCounts']);
        Route::get('draft',[ApplicationController::class,'getDraft']);
        Route::get('get/{id}',[ApplicationController::class,'getApplication']);
        Route::post('draft',[ApplicationController::class,'draft']);
        Route::post('create',[ApplicationController::class,'create']);
        Route::post('changeStatus',[ApplicationController::class,'changeStatus']);
    });

    Route::group(['prefix' => 'appeals'], function () {
        Route::get('list',[AppealsController::class,'list']);
        Route::get('draft',[AppealsController::class,'getDraft']);
        Route::get('get/{id}',[AppealsController::class,'getAppeal']);
        Route::get('getMessages/{id}',[AppealsController::class,'getMessages']);
        Route::get('getDocs/{id}',[AppealsController::class,'getDocs']);
        Route::get('downloadFile/{fileId}',[AppealsController::class,'downloadFile']);
        Route::post('draft',[AppealsController::class,'draft']);
        Route::post('create',[AppealsController::class,'create']);
        Route::post('fileUpload',[AppealsController::class,'fileUpload']);
        Route::post('fileDelete',[AppealsController::class,'fileDelete']);
        Route::post('changeStatus',[AppealsController::class,'changeStatus']);
        Route::post('sendMessage',[AppealsController::class,'sendMessage']);
    });

    Route::group(['prefix' => 'disclosure'], function () {
        Route::get('getByType/{group}/{type}',[DisclosureController::class,'getByType']);
        Route::get('getList/{group}',[DisclosureController::class,'getList']);
        Route::post('fileUpload',[DisclosureController::class,'fileUpload']);
        Route::post('save',[DisclosureController::class,'save']);
        Route::post('fileDelete',[DisclosureController::class,'fileDelete']);
    });
});
