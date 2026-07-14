<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Umpeg\BarangController;
use App\Http\Controllers\Umpeg\PeminjamanController;
use App\Http\Controllers\Umpeg\LaporanController;
use App\Http\Controllers\Umpeg\DashboardController as UmpegDashboardController;
use App\Http\Controllers\Umpeg\PeminjamController as UmpegPeminjamController;
use App\Http\Controllers\Umpeg\ProfilController as UmpegProfilController;

use App\Http\Controllers\Peminjam\DashboardController as PeminjamDashboardController;
use App\Http\Controllers\Peminjam\PengajuanController;
use App\Http\Controllers\Peminjam\KatalogController;
use App\Http\Controllers\Peminjam\RiwayatController;
use App\Http\Controllers\Peminjam\ProfilController;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'umpeg') {
            return redirect()->route('umpeg.dashboard');
        }
        return redirect()->route('peminjam.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendOtp'])->name('password.email');

    Route::get('/verify-otp', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify');
    Route::post('/verify-otp', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.submit');

    Route::get('/reset-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Grup Rute Umpeg (Admin)
    Route::middleware(\App\Http\Middleware\CheckRole::class . ':umpeg')->prefix('umpeg')->name('umpeg.')->group(function () {

        Route::get('/dashboard', [UmpegDashboardController::class, 'index'])->name('dashboard');

        Route::resource('barang', BarangController::class);

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman/{id}/acc', [PeminjamanController::class, 'accPeminjaman'])->name('peminjaman.acc');
        Route::post('/peminjaman/{id}/serahkan', [PeminjamanController::class, 'serahkanBarang'])->name('peminjaman.serahkan');
        Route::post('/peminjaman/{id}/terima', [PeminjamanController::class, 'terimaBarang'])->name('peminjaman.terima');
        Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolakPeminjaman'])->name('peminjaman.tolak');

        // Manajemen Peminjam (Admin)
        Route::get('/peminjam', [UmpegPeminjamController::class, 'index'])->name('peminjam.index');
        Route::post('/peminjam/{id}/verify', [UmpegPeminjamController::class, 'verify'])->name('peminjam.verify');
        Route::post('/peminjam/{id}/tolak', [UmpegPeminjamController::class, 'tolak'])->name('peminjam.tolak');

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
        Route::get('/laporan/export-csv', [LaporanController::class, 'exportCsv'])->name('laporan.exportCsv');

        Route::get('/profil', [UmpegProfilController::class, 'index'])->name('profil.index');
        Route::post('/profil', [UmpegProfilController::class, 'update'])->name('profil.update');
    });

    // Grup Rute Peminjam
    Route::middleware(\App\Http\Middleware\CheckRole::class . ':peminjam')->prefix('peminjam')->name('peminjam.')->group(function () {

        Route::get('/dashboard', [PeminjamDashboardController::class, 'index'])->name('dashboard');

        Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

        Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');

        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
        Route::get('/riwayat/{id}/cetak', [RiwayatController::class, 'cetakBukti'])->name('riwayat.cetak');

        Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
        Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
        Route::post('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
    });
});


