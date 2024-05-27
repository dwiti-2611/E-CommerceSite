<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Route for displaying the login form
Route::get('/', [LoginController::class, 'index'])->name('Login');

// Route for handling login POST request
Route::post('/authentications/login', [LoginController::class, 'login'])->name('Login.post');

// Route for logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard routes based on user type
Route::middleware('auth')->group(function () {
  Route::get('/admin/Home', [AdminController::class, 'adminHome'])->name('admin.Home');
  Route::get('/user/Home', [UserController::class, 'userHome'])->name('user.Home');
});

// Route for displaying the registration form
Route::get('/authentications/register', [RegisterController::class, 'index'])->name('Register');

// Route for handling registration POST request
Route::post('/auth/register', [RegisterController::class, 'register'])->name('Register.post');
