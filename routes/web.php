<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
//auth
Auth::routes(['verify' => true]);
Auth::routes();

//route reset password from login form
Route::post('/send-reset-password-email', [App\Http\Controllers\Auth\ResetPasswordController::class, 'ResetPasswordEmail'])->name('passwords.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'ShowResetPasswordEmail'])->name('password.email.token');
Route::post('/reset-password-customes', [App\Http\Controllers\Auth\ResetPasswordController::class, 'ResetPasswordCustome'])->name('passwords.reset');

//home
Route::get('/', [LoginController::class, 'showLoginForm']);
// Route::get('/home', [Modules\Home\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

//file manager
Route::group(['prefix' => 'file-manager', 'middleware' => ['web', 'auth']], function () {
  \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['middleware' => ['web']], function () {
  Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

//sempel
Route::get('sample/home', [App\Http\Controllers\SampleController::class, 'home']);
Route::get('sample/table', [App\Http\Controllers\SampleController::class, 'table']);
Route::get('sample/form', [App\Http\Controllers\SampleController::class, 'form']);
Route::get('sample/all_form', [App\Http\Controllers\SampleController::class, 'all_form']);
Route::get('sample/notfound', [App\Http\Controllers\SampleController::class, 'notfound']);