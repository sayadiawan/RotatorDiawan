<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!baru
|
*/

// Route::prefix('user')->group(function() {
//     Route::get('/', 'UserController@index');
// });
Route::resource("user", UserController::class);
// Route::get('user/export', ['as' => 'user.export', 'uses' => 'UserController@export']);
Route::get('/user-destroy/{id}', 'UserController@destroy');
Route::get('/user-reset/{id}', 'UserController@ResetPass');
Route::get('/user-reset-status/{id}/{val}', 'UserController@ChangeStatus');
Route::get('/user-data', 'UserController@json');
Route::get('/user-pdf', 'UserController@LoadPdf');
Route::get('/user-excel', 'UserController@LoadExcel');
Route::get('/user-form-import', 'UserController@FormImport');
Route::post('/user-proses-import', 'UserController@ProsesImport');
Route::post('user/get-users-by-select2', 'UserController@getUsersBySelect2')->name('getUsersBySelect2');