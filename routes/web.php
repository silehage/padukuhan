<?php

use App\Http\Controllers\DashboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InventarisControllers;
use App\Http\Controllers\KasController;
use App\Http\Controllers\PendudukController;

Route::get('/', function () {
    return to_route('login');
})->name('home');

Route::middleware(['auth'])->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('export/excel', [ExportController::class, 'exportExcel'])->name('exportExcel');
    Route::get('export/pdf', [ExportController::class, 'exportPdf'])->name('exportPdf');
    Route::get('export/kas', [ExportController::class, 'exportKas'])->name('exportKas');
    
    Route::get('penduduk/list',[PendudukController::class, 'list'])->name('penduduk.list');
    Route::get('penduduk/{id}/createItem',[PendudukController::class, 'createItem'])->name('penduduk.createItem');
    Route::post('penduduk/{id}/storeItem',[PendudukController::class, 'storeItem'])->name('penduduk.storeItem');
    Route::get('penduduk/{id}/editItem/{itemId}',[PendudukController::class, 'editItem'])->name('penduduk.editItem');
    Route::post('penduduk/{id}/updateItem/{itemId}',[PendudukController::class, 'updateItem'])->name('penduduk.updateItem');
    Route::resource('penduduk', PendudukController::class);
    Route::resource('inventaris', InventarisControllers::class);
    Route::get('kas/bulk', [KasController::class, 'bulkCreate'])->name('kas.bulkCreate');
    Route::post('kas/bulk', [KasController::class, 'bulkStore'])->name('kas.bulkStore');
    Route::resource('kas', KasController::class);
});

require __DIR__.'/auth.php';