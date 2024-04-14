<?php

use App\Http\Controllers\RegisterCustomerController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([

    'middleware' => 'api',
    // 'prefix' => 'api'

], function () {
    Route::post('login', [App\Http\Controllers\LoginApiController::class,'login']);
    Route::post('logout',[App\Http\Controllers\LoginApiController::class,'logout']);
    Route::post('refresh',[App\Http\Controllers\LoginApiController::class,'refresh']);
    Route::post('me',[App\Http\Controllers\LoginApiController::class,'me']);
    //send email
    Route::post('send-mail',[App\Http\Controllers\MailController::class,'sendEmail']);
    //register
    Route::post('register',[App\Http\Controllers\RegisterCustomerController::class,'store']);
});