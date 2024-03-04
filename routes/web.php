<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
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
Route::controller(DashboardController::class)
    ->middleware('auth.token')
    ->group(function () {
        Route::get('/home', 'index')->name('home');

        // Manage user access
        Route::prefix('user-access')
            ->group(function () {
                Route::get('/', 'userAccess');
                Route::post('/add', [SiteController::class, 'addUserSiteAccess']);
                Route::post('/import-excel', [SiteController::class, 'addUserAccessFromExcel']);
                Route::delete('/delete', [SiteController::class, 'deleteUserSiteAccess']);
                Route::get('/users', [SiteController::class, 'getUserBySiteId']);
                Route::post('/site/add', [SiteController::class, 'addSite']);
            });

        // User account
        Route::prefix('account')
            ->group(function () {
                Route::get('/', 'account');
                Route::post('/update', [UserController::class, 'updateEmailAccount']);
                Route::post('/password/update', [UserController::class, 'updatePasswordAccount']);
            });
    });

/**
 * * Buat route-route baru di bawah ini
 * * Pastikan untuk selalu menggunakan middleware('auth.token')
 * * middleware tersebut digunakan untuk verifikasi access pengguna dengan web
 */
