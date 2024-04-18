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

// Route::prefix('device')->group(function() {

// Route::delete('/device/command/delete', 'DeviceController@command_destroy');
Route::get('/site/delete/{id}', 'SiteController@destroy');
Route::resource("site", SiteController::class);
// Route::get('/device-data', 'DeviceController@json');

// Route::get('/devices/data', 'DeviceController@json_data');
// Route::get('/devices/data/{id}', 'DeviceController@json_data');
// Route::get('/', 'DeviceController@index');
// Route::post('/device/command/set_command/{id}', 'DeviceController@set_command')->name('set_command');


// });