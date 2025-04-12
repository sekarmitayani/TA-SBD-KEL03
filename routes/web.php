<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PinjamBarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanPeminjamanController;   
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route publik
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    
    // Rute untuk registrasi
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
});

// Protected routes (Hanya untuk pengguna yang sudah login)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Manajemen Kategori
    Route::resource('kategori', KategoriController::class);
    Route::put('/kategori/{kategori}/soft-delete', [KategoriController::class, 'softDelete'])->name('kategori.soft-delete');
    
    // Manajemen Barang
    Route::resource('barang', BarangController::class);
    Route::put('/barang/{barang}/soft-delete', [BarangController::class, 'softDelete'])->name('barang.soft-delete');
    
    // Manajemen Karyawan (khusus admin)
    Route::resource('karyawan', KaryawanController::class);
    Route::put('/karyawan/{karyawan}/soft-delete', [KaryawanController::class, 'softDelete'])->name('karyawan.soft-delete');

    // Manajemen Peminjaman
    Route::resource('peminjaman', PeminjamanController::class);
    Route::put('/peminjaman/{peminjaman}/soft-delete', [PeminjamanController::class, 'softDelete'])->name('peminjaman.soft-delete');
    
    // Manajemen Pemeliharaan Barang
    Route::resource('pemeliharaan', PemeliharaanController::class);
    Route::put('/pemeliharaan/{pemeliharaan}/soft-delete', [PemeliharaanController::class, 'softDelete'])->name('pemeliharaan.soft-delete');

    // Manajemen Pinjam Barang (untuk karyawan)
    Route::get('/pinjam-barang', [PinjamBarangController::class, 'index'])->name('pinjam_barang.index');
    Route::get('/pinjam-barang/create', [PinjamBarangController::class, 'create'])->name('pinjam_barang.create');
    Route::post('/pinjam-barang', [PinjamBarangController::class, 'store'])->name('pinjam_barang.store');
    Route::get('/pinjam-barang/{id}', [PinjamBarangController::class, 'show'])->name('pinjam_barang.show');
    Route::get('/pinjam-barang/{id}/edit', [PinjamBarangController::class, 'edit'])->name('pinjam_barang.edit');
    Route::put('/pinjam-barang/{id}', [PinjamBarangController::class, 'update'])->name('pinjam_barang.update');
    Route::delete('/pinjam-barang/{id}', [PinjamBarangController::class, 'destroy'])->name('pinjam_barang.destroy');
    
    Route::get('barang-trash', [BarangController::class, 'trash'])->name('barang.trash');
    Route::post('barang/{id}/restore', [BarangController::class, 'restore'])->name('barang.restore');
    Route::delete('barang/{id}/force-delete', [BarangController::class, 'destroy'])->name('barang.forceDelete');
    Route::delete('barang/{barang}/soft-delete', [BarangController::class, 'softDelete'])->name('barang.softDelete');

});

