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
Route::prefix('privileges')->group(function() {
    Route::get('/', 'PrivilegesController@index');
    Route::get('/json','PrivilegesController@json');
    Route::get('/delete/{id}','PrivilegesController@destroy');
    Route::get('/roles/{id}','PrivilegesController@roles')->name('privileges.roles');
    Route::post('/roles/role_store','PrivilegesController@role_store')->name('privileges.role_store');
});
Route::resource("privileges", PrivilegesController::class);
