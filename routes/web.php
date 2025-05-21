<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;

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
    return view('welcome');
});

Route::get('/landing_page', [LandingPageController::class, 'index']);

Route::get('/admin_dashboard', [AdminController::class, 'index']);
// Route::get('/admin_datapengunjung', [AdminController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/buku', [BukuController::class, 'index']);

