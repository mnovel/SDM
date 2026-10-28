<?php

use App\Http\Controllers\MasterData\MasterAgamaController;
use App\Http\Controllers\MasterData\MasterBahasaController;
use App\Http\Controllers\MasterData\MasterJabatanController;
use App\Http\Controllers\MasterData\MasterKecamatanController;
use App\Http\Controllers\MasterData\MasterKelurahanController;
use App\Http\Controllers\MasterData\MasterKotaController;
use App\Http\Controllers\MasterData\MasterLiburController;
use App\Http\Controllers\MasterData\MasterPangkatController;
use App\Http\Controllers\MasterData\MasterPendidikanController;
use App\Http\Controllers\MasterData\MasterProvinsiController;
use App\Http\Controllers\MasterData\MasterStatusPegawaiController;
use App\Http\Controllers\MasterData\MasterStatusPernikahanController;
use App\Http\Controllers\MasterData\MasterSukuController;
use App\Http\Controllers\MasterData\MasterUnitController;
use Illuminate\Support\Facades\Route;

Route::prefix('master')->name('master.')->group(function () {

    // ==========================================
    // MASTER CRUD
    // ==========================================

    Route::prefix('agama')->name('agama.')->group(function () {
        Route::get('/', [MasterAgamaController::class, 'index'])->name('index');
        Route::post('/', [MasterAgamaController::class, 'store'])->name('store');
        Route::get('/{agama}', [MasterAgamaController::class, 'show'])->name('show');
        Route::put('/{agama}', [MasterAgamaController::class, 'update'])->name('update');
        Route::delete('/{agama}', [MasterAgamaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('bahasa')->name('bahasa.')->group(function () {
        Route::get('/', [MasterBahasaController::class, 'index'])->name('index');
        Route::post('/', [MasterBahasaController::class, 'store'])->name('store');
        Route::get('/{bahasa}', [MasterBahasaController::class, 'show'])->name('show');
        Route::put('/{bahasa}', [MasterBahasaController::class, 'update'])->name('update');
        Route::delete('/{bahasa}', [MasterBahasaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('pendidikan')->name('pendidikan.')->group(function () {
        Route::get('/', [MasterPendidikanController::class, 'index'])->name('index');
        Route::post('/', [MasterPendidikanController::class, 'store'])->name('store');
        Route::get('/{pendidikan}', [MasterPendidikanController::class, 'show'])->name('show');
        Route::put('/{pendidikan}', [MasterPendidikanController::class, 'update'])->name('update');
        Route::delete('/{pendidikan}', [MasterPendidikanController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('libur')->name('libur.')->group(function () {
        Route::get('/', [MasterLiburController::class, 'index'])->name('index');
        Route::post('/', [MasterLiburController::class, 'store'])->name('store');
        Route::get('/{libur}', [MasterLiburController::class, 'show'])->name('show');
        Route::put('/{libur}', [MasterLiburController::class, 'update'])->name('update');
        Route::delete('/{libur}', [MasterLiburController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('pangkat')->name('pangkat.')->group(function () {
        Route::get('/', [MasterPangkatController::class, 'index'])->name('index');
        Route::post('/', [MasterPangkatController::class, 'store'])->name('store');
        Route::get('/{pangkat}', [MasterPangkatController::class, 'show'])->name('show');
        Route::put('/{pangkat}', [MasterPangkatController::class, 'update'])->name('update');
        Route::delete('/{pangkat}', [MasterPangkatController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('suku')->name('suku.')->group(function () {
        Route::get('/', [MasterSukuController::class, 'index'])->name('index');
        Route::post('/', [MasterSukuController::class, 'store'])->name('store');
        Route::get('/{suku}', [MasterSukuController::class, 'show'])->name('show');
        Route::put('/{suku}', [MasterSukuController::class, 'update'])->name('update');
        Route::delete('/{suku}', [MasterSukuController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('status-pegawai')->name('status-pegawai.')->group(function () {
        Route::get('/', [MasterStatusPegawaiController::class, 'index'])->name('index');
        Route::post('/', [MasterStatusPegawaiController::class, 'store'])->name('store');
        Route::get('/{statusPegawai}', [MasterStatusPegawaiController::class, 'show'])->name('show');
        Route::put('/{statusPegawai}', [MasterStatusPegawaiController::class, 'update'])->name('update');
        Route::delete('/{statusPegawai}', [MasterStatusPegawaiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('status-pernikahan')->name('status-pernikahan.')->group(function () {
        Route::get('/', [MasterStatusPernikahanController::class, 'index'])->name('index');
        Route::post('/', [MasterStatusPernikahanController::class, 'store'])->name('store');
        Route::get('/{statusPernikahan}', [MasterStatusPernikahanController::class, 'show'])->name('show');
        Route::put('/{statusPernikahan}', [MasterStatusPernikahanController::class, 'update'])->name('update');
        Route::delete('/{statusPernikahan}', [MasterStatusPernikahanController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('unit')->name('unit.')->group(function () {
        Route::get('/', [MasterUnitController::class, 'index'])->name('index');
        Route::post('/', [MasterUnitController::class, 'store'])->name('store');
        Route::get('/{unit}', [MasterUnitController::class, 'show'])->name('show');
        Route::put('/{unit}', [MasterUnitController::class, 'update'])->name('update');
        Route::delete('/{unit}', [MasterUnitController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jabatan')->name('jabatan.')->group(function () {
        Route::get('/', [MasterJabatanController::class, 'index'])->name('index');
        Route::post('/', [MasterJabatanController::class, 'store'])->name('store');
        Route::get('/{jabatan}', [MasterJabatanController::class, 'show'])->name('show');
        Route::put('/{jabatan}', [MasterJabatanController::class, 'update'])->name('update');
        Route::delete('/{jabatan}', [MasterJabatanController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('provinsi')->name('provinsi.')->group(function () {
        Route::get('/', [MasterProvinsiController::class, 'index'])->name('index');
        Route::get('/{provinsi}', [MasterProvinsiController::class, 'show'])->name('show');
        Route::get('/{provinsi}/kota', [MasterProvinsiController::class, 'kota'])->name('kota');
    });

    Route::prefix('kota')->name('kota.')->group(function () {
        Route::get('/', [MasterKotaController::class, 'index'])->name('index');
        Route::get('/{kota}', [MasterKotaController::class, 'show'])->name('show');
        Route::get('/{kota}/kecamatan', [MasterKotaController::class, 'kecamatan'])->name('kecamatan');
    });

    Route::prefix('kecamatan')->name('kecamatan.')->group(function () {
        Route::get('/', [MasterKecamatanController::class, 'index'])->name('index');
        Route::get('/{kecamatan}', [MasterKecamatanController::class, 'show'])->name('show');
        Route::get('/{kecamatan}/kelurahan', [MasterKecamatanController::class, 'kelurahan'])->name('kelurahan');
    });

    Route::prefix('kelurahan')->name('kelurahan.')->group(function () {
        Route::get('/', [MasterKelurahanController::class, 'index'])->name('index');
        Route::get('/{kelurahan}', [MasterKelurahanController::class, 'show'])->name('show');
    });
});
