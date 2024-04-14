<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource("biodata", BiodataController::class);
Route::get('/biodata-check-password/{param}','BiodataController@CheckPassword');
Route::post('/biodata-reset-password/{param}','BiodataController@ResetPassword');

// Route::prefix('biodata')->group(function() {
//     Route::get('/', 'BiodataController@index');
// });