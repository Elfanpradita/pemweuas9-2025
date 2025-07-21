<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
});

Route::get('/transaksi/{id}', [\App\Http\Controllers\TransaksiController::class, 'show'])
    ->name('transaksi.show')
    ->middleware('auth');

Route::post('/midtrans/webhook', [MidtransController::class, 'webhook']);

Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/cek-status', [TransaksiController::class, 'cekStatus'])->name('transaksi.cekStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/cek-status', [TransaksiController::class, 'cekStatus'])->name('transaksi.cekStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/keranjang', [\App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang.index');
    Route::delete('/keranjang/{id}', [\App\Http\Controllers\KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    Route::get('/transaksi', [\App\Http\Controllers\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [\App\Http\Controllers\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/cek', [\App\Http\Controllers\TransaksiController::class, 'cekStatus'])->name('transaksi.cekStatus');
});

