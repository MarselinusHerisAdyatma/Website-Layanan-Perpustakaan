<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('landing_page');
});
Route::get('/', [LandingPageController::class, 'index'])->name('landing_page');

// LOGIN
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// SUPER ADMIN
Route::prefix('dashboard/superadmin')->middleware(['auth', 'LoginCheck:1'])->name('superadmin.')->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('index');
    Route::get('/data-pengunjung', [SuperAdminController::class, 'dataPengunjung'])->name('data_pengunjung');
    Route::get('/data-peminjaman', [SuperAdminController::class, 'dataPeminjaman'])->name('data_peminjaman');
    Route::get('/data-akun', [SuperAdminController::class, 'dataAkun'])->name('data_akun');
    Route::get('/data-koleksi', [SuperAdminController::class, 'dataKoleksi'])->name('data_koleksi');
    Route::get('/edit-koleksi', [SuperAdminController::class, 'editKoleksi'])->name('edit_koleksi');
    });
    
// ADMIN
Route::prefix('dashboard/admin')->middleware(['auth', 'LoginCheck:2'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/data-pengunjung', [AdminController::class, 'dataPengunjung'])->name('data_pengunjung');
    Route::get('/data-peminjaman', [AdminController::class, 'dataPeminjaman'])->name('data_peminjaman');
    Route::get('/data-akun', [AdminController::class, 'dataAkun'])->name('data_akun');
    Route::get('/data-koleksi', [AdminController::class, 'dataKoleksi'])->name('data_koleksi');
    Route::get('/edit-koleksi', [AdminController::class, 'editKoleksi'])->name('edit_koleksi');
});

// USER
Route::prefix('dashboard/user')->middleware(['auth', 'LoginCheck:3'])->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/data-pengunjung', [UserController::class, 'dataPengunjung'])->name('data_pengunjung');
    Route::get('/data-peminjaman', [UserController::class, 'dataPeminjaman'])->name('data_peminjaman');
    });


