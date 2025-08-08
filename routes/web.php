<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;


Route::get('/', [TransaksiController::class, 'index'])->name('kasir.index');
Route::post('/kasir', [TransaksiController::class, 'store'])->name('kasir.store');

Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/transaksi', [TransaksiController::class, 'indextransaksi'])->name('transaksi.index');
Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'ajaxDetail']);