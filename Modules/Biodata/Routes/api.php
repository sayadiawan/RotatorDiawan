<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/biodata', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/update-password', 'ApiBiodataController@update');
    Route::get('/test', 'ApiBiodataController@test');
    Route::get('/get-data-biodata', 'ApiBiodataController@GetData');
    Route::post('/update-biodata','ApiBiodataController@UpdateData');
});