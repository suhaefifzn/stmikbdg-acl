<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardUserController;
use Illuminate\Support\Facades\Route;

// ! Jangan ubah route yang ada dalam group ini
Route::controller(AuthController::class)
    ->group(function () {
        Route::get('/', 'checkToken')->name('check');
        Route::get('/logout', 'logout')->name('logout'); // gunakan untuk logout
    });

/**
 * ! Jadikan route di bawah sebagai halaman utama dari web
 * ! harap tidak mengubah nilai pada name('home');
 */
Route::controller(DashboardUserController::class)
    ->middleware('auth.token')
    ->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('/site-user', 'getUserBySiteId');
        Route::post('/site-user', 'addUserSiteAccess');
    });

/**
 * * Buat route-route baru di bawah ini
 * * Pastikan untuk selalu menggunakan middleware('auth.token')
 * * middleware tersebut digunakan untuk verifikasi access pengguna dengan web
 */
