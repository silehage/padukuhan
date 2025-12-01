<?php

use App\Http\Controllers\DashboardController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InventarisControllers;
use App\Http\Controllers\KasController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return to_route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('export/excel', [ExportController::class, 'exportExcel'])->name('exportExcel');
    Route::get('export/data-induk-padukuhan', [ExportController::class, 'dataIndukPadukuhan'])->name('exportDataIndukPadukuhan');
    Route::get('export/data-induk-penduduk', [ExportController::class, 'dataIndukPenduduk'])->name('exportDataIndukPenduduk');
    Route::get('export/kas', [ExportController::class, 'exportKas'])->name('exportKas');
    Route::get('export/inventaris', [ExportController::class, 'exportInventaris'])->name('exportInventaris');
    Route::get('export/pengurus', [ExportController::class, 'exportPengurus'])->name('exportPengurus');

    Route::post('penduduk/updateKartuKeluarga', [PendudukController::class, 'updateKartuKeluarga'])->name('penduduk.updateKartuKeluarga');
    Route::get('penduduk/list', [PendudukController::class, 'list'])->name('penduduk.list');
    Route::get('penduduk/{id}/createItem', [PendudukController::class, 'createItem'])->name('penduduk.createItem');
    Route::post('penduduk/{id}/storeItem', [PendudukController::class, 'storeItem'])->name('penduduk.storeItem');
    Route::get('penduduk/{id}/editItem/{itemId}', [PendudukController::class, 'editItem'])->name('penduduk.editItem');
    Route::post('penduduk/{id}/updateItem/{itemId}', [PendudukController::class, 'updateItem'])->name('penduduk.updateItem');
    Route::resource('penduduk', PendudukController::class);
    Route::resource('inventaris', InventarisControllers::class);
    Route::get('kas/bulk', [KasController::class, 'bulkCreate'])->name('kas.bulkCreate');
    Route::post('kas/bulk', [KasController::class, 'bulkStore'])->name('kas.bulkStore');
    Route::resource('kas', KasController::class);

    Route::post('pengurus/assignPengurus', [PengurusController::class, 'assignPengurus'])->name('pengurus.assignPengurus');
    Route::resource('pengurus', PengurusController::class);
    Route::resource('users', UserController::class);
    Route::post('togglePermission', [PermissionController::class, 'togglePermission'])->name('permissions.togglePermission');
    Route::resource('permissions', PermissionController::class);

    Route::get('/chart/usia', [PendudukController::class, 'getUsiaChart'])->name('penduduk.getUsiaChart');
    Route::get('/chart/jenis-kelamin', [PendudukController::class, 'getJenisKelaminChart'])->name('penduduk.getJenisKelaminChart');
    Route::get('/search-penduduk/{key}', [PendudukController::class, 'search'])->name('penduduk.search');
    Route::get('/search-kk/{key}', [PendudukController::class, 'searchkartuKeluarga'])->name('penduduk.searchkartuKeluarga');
});

require __DIR__ . '/auth.php';
