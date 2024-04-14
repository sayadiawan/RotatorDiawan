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

Route::prefix('position')->group(function () {
    Route::get('/json', 'PositionController@json');
    Route::get('/delete/{id}', 'PositionController@destroy');
});
Route::resource("position", PositionController::class);