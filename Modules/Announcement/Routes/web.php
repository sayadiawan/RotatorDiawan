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

Route::prefix('announcement')->group(function() {
    Route::get('/', 'AnnouncementController@index');
    Route::post('/', 'AnnouncementController@store')->name('announcement.store');
});
