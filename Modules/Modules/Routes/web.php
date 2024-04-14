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

Route::prefix('modules')->group(function() {
    Route::get('/', 'ModulesController@index');
    Route::get('/json','ModulesController@json');
    Route::post('/sort','ModulesController@sort');
    Route::get('/delete/{id}','ModulesController@destroy');
});
Route::resource("modules", ModulesController::class);