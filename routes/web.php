<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Helpers\DatabaseConnectionHelper;

Route::get('/', function () {
    return view('landing_page');
});
Route::get('/', [LandingPageController::class, 'index'])->name('landing_page');

// LOGIN
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// SUPER ADMIN
Route::prefix('dashboard/superadmin')->middleware(['auth', 'LoginCheck:1'])->name('superadmin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/data-pengunjung', [PengunjungController::class, 'index'])->name('data_pengunjung');
    Route::get('/data-peminjaman', [PeminjamanController::class, 'index'])->name('data_peminjaman');
    Route::get('/data-koleksi', [SuperAdminController::class, 'dataKoleksi'])->name('data_koleksi');
    Route::get('/edit-koleksi', [SuperAdminController::class, 'editKoleksi'])->name('edit_koleksi');
    Route::post('/update-koleksi', [SuperAdminController::class, 'updateKoleksi'])->name('update_koleksi');

    // Akun dikelola oleh UserManagementController khusus Super Admin
    Route::get('/data-akun', [UserManagementController::class, 'index'])->name('data_akun');
    Route::get('/data-akun/create', [UserManagementController::class, 'create'])->name('data_akun.create');
    Route::post('/data-akun', [UserManagementController::class, 'store'])->name('data_akun.store');
    Route::get('/data-akun/{id}/edit', [UserManagementController::class, 'edit'])->name('data_akun.edit');
    Route::put('/data-akun/{id}', [UserManagementController::class, 'update'])->name('data_akun.update');
    Route::delete('/data-akun/{id}', [UserManagementController::class, 'destroy'])->name('data_akun.destroy');

});
    
// ADMIN
Route::prefix('dashboard/admin')->middleware(['auth', 'LoginCheck:2'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/data-pengunjung', [PengunjungController::class, 'index'])->name('data_pengunjung');
    Route::get('/data-peminjaman-buku', [PeminjamanController::class, 'index'])->name('peminjaman-buku.index');
    Route::get('/data-akun', [AdminController::class, 'dataAkun'])->name('data_akun');
    Route::get('/data-koleksi', [AdminController::class, 'dataKoleksi'])->name('data_koleksi');
    Route::get('/edit-koleksi', [AdminController::class, 'editKoleksi'])->name('edit_koleksi');

});


Route::get('/cek-semua-koneksi', function () {
    $status = [];

    $koneksiList = [
        'mysql_inlislite_local' => 'Inlislite Lokal',
        'mysql_inlislite_ssh'   => 'Inlislite Online (SSH)',
        'sqlsrv_elib_local'     => 'eLib Lokal',
        'sqlsrv_elib_remote'    => 'eLib Online (Kampus)',
    ];

    foreach ($koneksiList as $key => $label) {
        try {
            DB::connection($key)->select('SELECT 1');
            $status[$key] = "✅ $label: Terhubung";
        } catch (\Exception $e) {
            $status[$key] = "❌ $label: Gagal - " . $e->getMessage();
            Log::error("[$label] Gagal koneksi: " . $e->getMessage());
        }
    }

    return view('cek-semua-koneksi', compact('status'));
});

Route::get('/test-email', function () {
    try {
        Mail::raw('Tes kirim email dari Laravel', function ($message) {
            $message->to('emailtujuan@example.com')
                    ->subject('Tes Kirim Email');
        });

        return 'Email berhasil dikirim!';
    } catch (\Exception $e) {
        Log::error('Gagal kirim email: ' . $e->getMessage());
        return 'Gagal kirim email: ' . $e->getMessage();
    }
});

Route::get('/cek-koneksi', function () {
    DatabaseConnectionHelper::setDatabaseConnections(); // ← Ini WAJIB!

    $inlislite = session('inlislite_connection');
    $elib = session('elib_connection');

    try {
        $inlisliteDb = DB::connection($inlislite)->select('SELECT DATABASE() as db');
    } catch (\Exception $e) {
        $inlisliteDb = '❌ ERROR: Database connection [' . $inlislite . '] not configured.';
    }

    try {
        $elibDb = DB::connection($elib)->select('SELECT DB_NAME() as db');
    } catch (\Exception $e) {
        $elibDb = '❌ ERROR: Database connection [' . $elib . '] not configured.';
    }

    return view('cek-koneksi', compact('inlislite', 'elib', 'inlisliteDb', 'elibDb'));
});