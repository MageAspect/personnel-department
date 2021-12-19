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

Route::get('/', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('auth.login');

Route::post(
    '/login-process',
    [App\Http\Controllers\AuthController::class, 'processLoginForm']
)->name('auth.login-process');


Route::get(
    '/forgot-password',
    [App\Http\Controllers\AuthController::class, 'showForgotPasswordForm']
)->name('auth.forgot-password');

Route::post(
    '/forgot-password-process',
    [App\Http\Controllers\AuthController::class, 'processForgotPasswordForm']
)->name('auth.forgot-password-process');

Route::get(
    '/reset-password/{token}',
    [App\Http\Controllers\AuthController::class, 'showResetPasswordForm']
)->name('auth.reset-password');

Route::get('/reset-password-success', function () {
    return view('auth.password-reset-success');
}
)->name('auth.reset-password-success');

Route::post(
    '/reset-password-process/',
    [App\Http\Controllers\AuthController::class, 'processResetPasswordForm']
)->name('auth.reset-password-process');

Route::get('/departments', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('home');
