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

Route::resource("room", RoomController::class);
Route::get('/room/delete/{id}', 'RoomController@destroy')->name('room-destroy');
Route::post('room/get-rooms-by-select2', 'RoomController@getRoomsBySelect2')->name('getRoomsBySelect2');