<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Sparkling Radiant Laundry']);
});

Route::get('/user/login', [UserController::class, 'viewUserLogin']);
Route::get('/user/register', [UserController::class, 'viewUserRegister']);
Route::get('/user/dashboard', [UserController::class, 'viewUserDashboard']);
Route::get('/user/detail', [UserController::class, 'viewDetailUser']);
Route::get('/user/detail-pesanan/{pesanan}', [UserController::class, 'viewDetailPesanan']);

Route::get('/user/buat-pesanan', [UserController::class, 'viewBuatPesanan']);

Route::post('/user/register', [UserController::class, 'userRegisterHandling']);
Route::post('/user/login', [UserController::class, 'userLoginHandling']);
Route::post('/user/update-data', [UserController::class, 'userUpdateHandling']);
Route::post('/user/logout', [UserController::class, 'userLogoutHandling']);
Route::post('/user/ulasan/{pesanan}', [UserController::class, 'ulasanUserHandling']);

Route::post('/get/harga-pesanan', [PaymentController::class, 'getHitungHargaPesanan']);

Route::post('/payment/process', [PaymentController::class, 'paymentProcess']);
Route::post('/payment/notification', [PaymentController::class, 'paymentNotificationHandling']);

Route::get('/admin/login', [AdminController::class, 'viewAdminLogin']);
Route::get('/admin/detail', [AdminController::class, 'viewDetailAdmin']);
Route::get('/admin/dashboard', [AdminController::class, 'viewAdminDashboard']);
Route::get('/admin/user-detail-pesanan/{pesanan}', [AdminController::class, 'adminViewDetailPesanan']);

Route::post('/admin/login', [AdminController::class, 'adminLoginHandling']);
Route::post('/admin/update-data', [AdminController::class, 'adminUpdateHandling']);
Route::post('/admin/update-status-pesanan/{pesanan}', [AdminController::class, 'updateStatusPesananHandling']);
Route::post('/admin/logout', [AdminController::class, 'adminLogoutHandling']);