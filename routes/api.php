<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiBarangController;

// API Barang
Route::post('/barang', [ApiBarangController::class, 'store']);
Route::get('/barang/search/{query}', [ApiBarangController::class, 'search']);
