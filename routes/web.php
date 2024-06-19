<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Sparkling Radiant Laundry']);
});

Route::get('/user/login', [UserController::class, 'viewUserLogin']);
Route::get('/user/register', [UserController::class, 'viewUserRegister']);
Route::get('/user/detail', [UserController::class, 'viewDetailUser']);

Route::post('/user/register', [UserController::class, 'userRegisterHandling']);
Route::post('/user/login', [UserController::class, 'userLoginHandling']);
Route::post('/user/update-data', [UserController::class, 'userUpdateHandling']);
Route::post('/user/logout', [UserController::class, 'userLogoutHandling']);

Route::get('/admin/login', [AdminController::class, 'viewAdminLogin']);
Route::get('/admin/detail', [AdminController::class, 'viewDetailAdmin']);

Route::post('/admin/login', [AdminController::class, 'adminLoginHandling']);
Route::post('/admin/update-data', [AdminController::class, 'adminUpdateHandling']);
Route::post('/admin/logout', [AdminController::class, 'adminLogoutHandling']);