<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
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
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

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

Route::middleware(['auth'])->group(function () {
    Route::get(
        '/departments/find-user-departments/{userId}',
        array(DepartmentController::class, 'findUserDepartments')
    );
    Route::resource('departments', DepartmentController::class);

    Route::get('/users/find-career-journal/{userId}', array(UserController::class, 'findUserCareerJournal'));

    Route::get('/users/find/{userId}', array(UserController::class, 'findById'));

    Route::match(
        array(
            'GET',
            'POST'
        ),
        '/users/find',
        [UserController::class, 'findUsers']
    )->name('users.find');
    Route::post('/users/{id}', array(UserController::class, 'update'));
    Route::resource('users', UserController::class);
});


