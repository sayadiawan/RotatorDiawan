<?php

use Modules\UserAccount\Http\Controllers\UserAccountController;

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

Route::get('/user-profile-account', [UserAccountController::class, 'userProfileAccount']);
Route::post('/user-profile-account/{id}', [UserAccountController::class, 'storeUserProfileAccount']);
Route::get('/user-password-account', [UserAccountController::class, 'userPasswordAccount']);
Route::post('/user-password-account/{id}', [UserAccountController::class, 'storeUserPasswordAccount']);