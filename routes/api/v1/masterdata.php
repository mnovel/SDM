<?php

use App\Http\Controllers\MasterData\MasterAgamaController;
use App\Http\Controllers\MasterData\MasterBahasaController;
use App\Http\Controllers\MasterData\MasterLiburController;
use App\Http\Controllers\MasterData\MasterPangkatController;
use App\Http\Controllers\MasterData\MasterPendidikanController;
use Illuminate\Support\Facades\Route;

Route::prefix('master')->name('master.')->group(function () {

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
});
