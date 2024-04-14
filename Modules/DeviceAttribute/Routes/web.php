<?php

use Illuminate\Support\Facades\Route;
use Modules\DeviceAttribute\Http\Controllers\DeviceAttributeController;

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

// Route::resource('deviceattribute', DeviceAttributeController::class);
Route::get('/deviceattribute', [DeviceAttributeController::class, 'index'])->name('deviceattribute.index');
Route::get('/deviceattribute/create', [DeviceAttributeController::class, 'create'])->name('deviceattribute.create');
Route::post('/deviceattribute', [DeviceAttributeController::class, 'store'])->name('deviceattribute.store');
Route::get('/deviceattribute/{id}', [DeviceAttributeController::class, 'show'])->name('deviceattribute.show');
Route::get('/deviceattribute/{id}/edit', [DeviceAttributeController::class, 'edit'])->name('deviceattribute.edit');
Route::put('/deviceattribute/{id}', [DeviceAttributeController::class, 'update'])->name('deviceattribute.update');
Route::delete('/deviceattribute/{id}', [DeviceAttributeController::class, 'destroy'])->name('deviceattribute.destroy');

Route::get('/deviceattribute/delete/{id}', 'DeviceAttributeController@destroy')->name('deviceattribute-destroy');
/* Route::post('/deviceattribute/get-deviceattribute-by-select2', 'DeviceAttributeController@getDeviceAttributeBySelect2')->name('getDeviceAttributeBySelect2'); */