<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| API Routes untuk Frontend React
|--------------------------------------------------------------------------
*/
Route::prefix('api')->group(function () {

    // ==========================================
    // 1. PUBLIC ROUTES (Tanpa Login)
    // ==========================================
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Katalog Buku & Kategori bisa dilihat pengunjung/siswa
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/kategori/{kategori}', [KategoriController::class, 'show']);
    Route::get('/buku', [BukuController::class, 'index']);
    Route::get('/buku/{buku}', [BukuController::class, 'show']);

    // ==========================================
    // 2. PROTECTED ROUTES (Wajib Login: Semua Role)
    // ==========================================
    Route::middleware('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Melihat riwayat peminjaman & mengajukan peminjaman buku
        Route::get('/peminjaman', [PeminjamanController::class, 'index']);
        Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show']);
        Route::post('/peminjaman', [PeminjamanController::class, 'store']);

        // ==========================================
        // 3. ADMIN & PETUGAS ONLY (RBAC Middleware)
        // ==========================================
        Route::middleware('role:admin,petugas')->group(function () {
            // Data siswa untuk form transaksi
            Route::get('/siswa', [AuthController::class, 'listSiswa']);

            // Kelola Master Kategori (Tambah, Edit, Hapus)
            Route::post('/kategori', [KategoriController::class, 'store']);
            Route::put('/kategori/{kategori}', [KategoriController::class, 'update']);
            Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy']);

            // Kelola Master Buku (Tambah, Edit, Hapus)
            Route::post('/buku', [BukuController::class, 'store']);
            Route::put('/buku/{buku}', [BukuController::class, 'update']);
            Route::delete('/buku/{buku}', [BukuController::class, 'destroy']);

            // Proses Pengembalian Buku & Hapus Transaksi
            Route::put('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan']);
            Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy']);
        });
    });
});