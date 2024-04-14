<?php

use Illuminate\Support\Facades\Route;

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

/* Route::get('/icon', 'IconController@index')->name('icon.index');
Route::get('/device/create/{id}', 'IconController@create')->name('icon.create');
Route::post('/device', 'IconController@store')->name('icon.store');
Route::get('/icon/edit', 'IconController@edit')->name('icon.edit');
Route::put('/icon', 'IconController@update')->name('icon.update'); */

Route::get('/icon/delete/{id}', 'IconController@destroy');
Route::resource('icon', IconController::class);