<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendudukController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {
    // Route::get('/chart/usia', [PendudukController::class, 'getUsiaChart'])->name('api.getChartUsia');
    // Route::get('/chart/jenis-kelamin', [PendudukController::class, 'getJenisKelaminChart'])->name('api.getJenisKelaminChart');
    // Route::get('/search-penduduk/{key}', [PendudukController::class, 'search'])->name('api.searchPenduduk');
});
