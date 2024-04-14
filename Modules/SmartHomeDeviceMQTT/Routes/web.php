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

Route::prefix('smarthomedevicemqtt')->group(function() {
    Route::get('/device/{id}', 'SmartHomeDeviceMQTTController@index')->name('smarthomedevicemqtt.device.index');
    Route::get('/', 'SmartHomeDeviceMQTTController@index');
});