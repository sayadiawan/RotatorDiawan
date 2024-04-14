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

Route::prefix('smarthome')->group(function () {
  Route::get('/device/{id}', 'SmartHomeDeviceController@index')->name('smarthome.device.index');
  Route::get('/device/create/{id}', 'SmartHomeDeviceController@create')->name('smarthome.device.create');
  Route::post('/device', 'SmartHomeDeviceController@store')->name('smarthome.device.store');
  // Route::get('/device/{id}', 'SmartHomeDeviceController@show')->name('smarthome.device.show');
  Route::get('/device/{id}/edit', 'SmartHomeDeviceController@edit')->name('smarthome.device.edit');
  Route::put('/device/{id}', 'SmartHomeDeviceController@update')->name('smarthome.device.update');
  Route::delete('/device/{id}', 'SmartHomeDeviceController@destroy')->name('smarthome.device.destroy');
  Route::get('/delete/{id}', 'SmartHomeDeviceController@destroy');

  Route::post('/device/store-control-manual/{id_smarthome}/{id_device}', 'SmartHomeDeviceController@storeControlManual')->name('smarthome.device.store-control-manual');
});