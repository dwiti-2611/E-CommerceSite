<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Route for displaying the login form
Route::get('/', [Login::class, 'index'])->name('Login');

// Route for handling login POST request
Route::post('/authentications/login', [LoginBasic::class, 'login'])->name('Login.post');

// Route for logout
Route::post('/logout', [LoginBasic::class, 'logout'])->name('logout');

// Dashboard routes based on user type
Route::middleware('auth')->group(function () {
  Route::get('/admin/Home', [AdminController::class, 'adminHome'])->name('admin.Home');
  Route::get('/user/Home', [UserController::class, 'userHome'])->name('user.Home');
});

// Route for displaying the registration form
Route::get('/authentications/Register', [Register::class, 'index'])->name('Register');

// Route for handling registration POST request
Route::post('/auth/Register', [Register::class, 'register'])->name('Register.post');
