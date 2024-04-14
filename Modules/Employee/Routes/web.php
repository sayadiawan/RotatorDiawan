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
Route::resource("employee", EmployeeController::class);
Route::get('/employee-data', 'EmployeeController@json');
Route::get('/employees/data', 'EmployeeController@json_data');
Route::get('/employees/data/{id}', 'EmployeeController@json_data');
Route::get('/employee-excel', 'EmployeeController@export');
// Route::prefix('employee')->group(function() {
//     Route::get('/', 'EmployeeController@index');
  

// });