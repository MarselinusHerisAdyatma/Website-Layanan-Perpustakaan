<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing_page');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/superadmin', function () {
        return view('superadmin.dashboard');
    });

    Route::get('/dashboard/admin', function () {
        return view('admin.dashboard');
    });

    Route::get('/dashboard/user', function () {
        return view('user.dashboard');
    });
});

Route::get('/landing_page', [LandingPageController::class, 'index']);

Route::get('/admin_dashboard', [AdminController::class, 'index']);
// Route::get('/admin_datapengunjung', [AdminController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index']);