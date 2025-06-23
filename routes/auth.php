<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardSuperAdmin\SuperAdminController;
use Illuminate\Support\Facades\Route;


// Route untuk login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

//Login Super Admin
Route::post('login-superadmin', [SuperAdminController::class, 'prosesloginSuperAdmin'])->name('prosesloginSuperAdmin');

//Forgot password
Route::get('/forgot-password', [PasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');

Route::get('/success-reset-password', function () {
    return view('auth.success-reset-password'); 
})->name('success-reset-password');

Route::get('/success-forgot-password', function () {
    return view('auth.success-forgot-password'); 
})->name('success-forgot-password');

// Route untuk login dengan Google
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');

// Route untuk callback setelah login dengan Google
Route::get('auth/google-callback', [LoginController::class, 'handleGoogleCallback']);

//Route untuk register
Route::get('register', [RegisterController::class, 'show'])->name('register');
Route::get('register-mentor', [RegisterController::class, 'showmentor'])->name('registermentor');
Route::post('register', [RegisterController::class, 'register']);

// Route untuk logout
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logoutadmin', [LoginController::class, 'logoutAdmin'])->name('logout.admin');
Route::get('/logoutmentor', [LoginController::class, 'logoutMentor'])->name('logout.mentor');
