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

Route::get('/', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login-process', [App\Http\Controllers\AuthController::class, 'processLoginForm'])->name('login.process');

Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password-process', [App\Http\Controllers\AuthController::class, 'processForgotPasswordForm'])->name('forgot-password-process');


Route::get('/departments', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('home');
