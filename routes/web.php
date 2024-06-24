<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Users\AdminController;
use App\Http\Controllers\Users\DosenController;
use App\Http\Controllers\Users\KaryawanController;
use App\Http\Controllers\Users\MahasiswaController;
use Illuminate\Support\Facades\Route;

// ! Jangan ubah route yang ada dalam group ini
Route::controller(AuthController::class)
    ->group(function () {
        Route::get('/', 'checkToken')->name('check');
        Route::get('/logout', 'logout')->name('logout'); // gunakan untuk logout
        Route::get('/roles', 'changeUserRole')->middleware('auth.token');
    });

/**
 * ! Jadikan route di bawah sebagai halaman utama dari web
 * ! harap tidak mengubah nilai pada name('home');
 */
Route::controller(DashboardController::class)
    ->middleware(['auth.token', 'auth.admin'])
    ->group(function () {
        Route::get('/home', 'index')->name('home');

        // manage users
        Route::prefix('users')
            ->group(function () {
                // admin menu
                Route::controller(AdminController::class)
                    ->prefix('admin')
                    ->group(function () {
                        Route::get('/', 'index');
                        Route::post('/add', 'add');
                        Route::put('/update', 'update');
                        Route::delete('/delete', 'delete');
                        Route::get('/detail', 'detail');
                    });

                // Route::post('/import-excel', [UserController::class, 'addUserFromExcel']);

                // dosen
                Route::controller(DosenController::class)
                    ->prefix('dosen')
                    ->group(function () {
                        Route::get('/', 'index');
                        Route::delete('/delete', 'delete');
                        Route::post('/add', 'add');
                        Route::get('/detail', 'detail');
                        Route::put('/update', 'update');
                    });

                // karyawan
                Route::controller(KaryawanController::class)
                    ->prefix('karyawan')
                    ->group(function () {
                        Route::get('/', 'index');
                        Route::delete('/delete', 'delete');
                        Route::post('/add', 'add');
                        Route::get('/detail', 'detail');
                        Route::put('/update', 'update');
                    });

                // mahasiswa
                Route::controller(MahasiswaController::class)
                    ->prefix('mahasiswa')
                    ->group(function () {
                        Route::get('/', 'index');
                        Route::delete('/delete', 'delete');
                        Route::post('/add', 'add');
                        Route::get('/detail', 'detail');
                        Route::put('/update', 'update');
                    });
            });

        // manage user access
        Route::controller(SiteController::class)
            ->prefix('accesses')
            ->group (function () {
                Route::get('/', 'index');
                Route::post('/user/add', 'addUserSiteAccess');
                Route::delete('/delete', 'deleteAccess');
                Route::get('/users', 'getUserBySiteId');
                Route::post('/site/add', 'addSite');

                Route::get('/render-table', 'renderTable');

                // Route::post('/import-excel', 'addUserAccessFromExcel');
            });

        // User account
        Route::prefix('account')
            ->group(function () {
                Route::get('/', 'account');
                Route::post('/password/update', [UserController::class, 'updatePasswordAccount']);
            });
    });
