<?php

use App\Http\Controllers\Pegawai\PegawaiAktivitasKerjaController;
use App\Http\Controllers\Pegawai\PegawaiDokumenController;
use App\Http\Controllers\Pegawai\PegawaiJabatanStrukturalController;
use App\Http\Controllers\Pegawai\PegawaiKeluargaController;
use App\Http\Controllers\Pegawai\PegawaiKepanitiaanController;
use App\Http\Controllers\Pegawai\PegawaiKepangkatanController;
use App\Http\Controllers\Pegawai\PegawaiKepegawaianController;
use App\Http\Controllers\Pegawai\PegawaiNakesController;
use App\Http\Controllers\Pegawai\PegawaiPendidikanController;
use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Controllers\Pegawai\PegawaiRekeningController;
use App\Http\Controllers\Pegawai\PegawaiRiwayatKerjaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modul Pegawai
|--------------------------------------------------------------------------
| Semua route di sini sudah berada di dalam middleware auth:api
| (didaftarkan melalui routes/api.php).
|
| Prefix utama: /api/v1/pegawai
*/

Route::prefix('pegawai')->name('pegawai.')->group(function () {

    // ==========================================
    // INDUK: PEGAWAI
    // ==========================================

    Route::get('/', [PegawaiController::class, 'index'])->name('index');
    Route::post('/', [PegawaiController::class, 'store'])->name('store');
    Route::get('/{pegawai}', [PegawaiController::class, 'show'])->name('show');
    Route::put('/{pegawai}', [PegawaiController::class, 'update'])->name('update');
    Route::delete('/{pegawai}', [PegawaiController::class, 'destroy'])->name('destroy');

    // Detail lengkap 1 pegawai (relasi di-load semua)
    Route::get('/{pegawai}/profil', [PegawaiController::class, 'profil'])->name('profil');

    // Restore soft-deleted pegawai (opsional)
    Route::post('/{pegawai}/restore', [PegawaiController::class, 'restore'])
        ->name('restore')
        ->withTrashed();

    // ==========================================
    // DATA KEPEGAWAIAN (1 pegawai bisa punya riwayat)
    // ==========================================

    Route::prefix('{pegawai}/kepegawaian')->name('kepegawaian.')->group(function () {
        Route::get('/', [PegawaiKepegawaianController::class, 'index'])->name('index');
        Route::post('/', [PegawaiKepegawaianController::class, 'store'])->name('store');
        Route::get('/{kepegawaian}', [PegawaiKepegawaianController::class, 'show'])->name('show');
        Route::put('/{kepegawaian}', [PegawaiKepegawaianController::class, 'update'])->name('update');
        Route::delete('/{kepegawaian}', [PegawaiKepegawaianController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // NAKES (1 pegawai = 1 nakes)
    // ==========================================

    Route::prefix('{pegawai}/nakes')->name('nakes.')->group(function () {
        Route::get('/', [PegawaiNakesController::class, 'show'])->name('show');
        Route::post('/', [PegawaiNakesController::class, 'store'])->name('store');
        Route::put('/', [PegawaiNakesController::class, 'update'])->name('update');
        Route::delete('/', [PegawaiNakesController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // PENDIDIKAN (riwayat, hasMany)
    // ==========================================

    Route::prefix('{pegawai}/pendidikan')->name('pendidikan.')->group(function () {
        Route::get('/', [PegawaiPendidikanController::class, 'index'])->name('index');
        Route::post('/', [PegawaiPendidikanController::class, 'store'])->name('store');
        Route::get('/{pendidikan}', [PegawaiPendidikanController::class, 'show'])->name('show');
        Route::put('/{pendidikan}', [PegawaiPendidikanController::class, 'update'])->name('update');
        Route::delete('/{pendidikan}', [PegawaiPendidikanController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // KELUARGA (hasMany)
    // ==========================================

    Route::prefix('{pegawai}/keluarga')->name('keluarga.')->group(function () {
        Route::get('/', [PegawaiKeluargaController::class, 'index'])->name('index');
        Route::post('/', [PegawaiKeluargaController::class, 'store'])->name('store');
        Route::get('/{keluarga}', [PegawaiKeluargaController::class, 'show'])->name('show');
        Route::put('/{keluarga}', [PegawaiKeluargaController::class, 'update'])->name('update');
        Route::delete('/{keluarga}', [PegawaiKeluargaController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // REKENING (1 pegawai = 1 rekening utama)
    // ==========================================

    Route::prefix('{pegawai}/rekening')->name('rekening.')->group(function () {
        Route::get('/', [PegawaiRekeningController::class, 'show'])->name('show');
        Route::post('/', [PegawaiRekeningController::class, 'store'])->name('store');
        Route::put('/', [PegawaiRekeningController::class, 'update'])->name('update');
        Route::delete('/', [PegawaiRekeningController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // DOKUMEN (hasMany)
    // ==========================================

    Route::prefix('{pegawai}/dokumen')->name('dokumen.')->group(function () {
        Route::get('/', [PegawaiDokumenController::class, 'index'])->name('index');
        Route::post('/', [PegawaiDokumenController::class, 'store'])->name('store');
        Route::get('/{dokumen}', [PegawaiDokumenController::class, 'show'])->name('show');
        Route::put('/{dokumen}', [PegawaiDokumenController::class, 'update'])->name('update');
        Route::delete('/{dokumen}', [PegawaiDokumenController::class, 'destroy'])->name('destroy');

        // Download / preview file
        Route::get('/{dokumen}/download', [PegawaiDokumenController::class, 'download'])
            ->name('download');
    });

    // ==========================================
    // KEPANGKATAN (hasMany)
    // ==========================================

    Route::prefix('{pegawai}/kepangkatan')->name('kepangkatan.')->group(function () {
        Route::get('/', [PegawaiKepangkatanController::class, 'index'])->name('index');
        Route::post('/', [PegawaiKepangkatanController::class, 'store'])->name('store');
        Route::get('/{kepangkatan}', [PegawaiKepangkatanController::class, 'show'])->name('show');
        Route::put('/{kepangkatan}', [PegawaiKepangkatanController::class, 'update'])->name('update');
        Route::delete('/{kepangkatan}', [PegawaiKepangkatanController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // RIWAYAT KERJA (hasMany)
    // ==========================================

    Route::prefix('{pegawai}/riwayat-kerja')->name('riwayat-kerja.')->group(function () {
        Route::get('/', [PegawaiRiwayatKerjaController::class, 'index'])->name('index');
        Route::post('/', [PegawaiRiwayatKerjaController::class, 'store'])->name('store');
        Route::get('/{riwayatKerja}', [PegawaiRiwayatKerjaController::class, 'show'])->name('show');
        Route::put('/{riwayatKerja}', [PegawaiRiwayatKerjaController::class, 'update'])->name('update');
        Route::delete('/{riwayatKerja}', [PegawaiRiwayatKerjaController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // KEPANITIAAN (hasMany)
    // ==========================================

    Route::prefix('{pegawai}/kepanitiaan')->name('kepanitiaan.')->group(function () {
        Route::get('/', [PegawaiKepanitiaanController::class, 'index'])->name('index');
        Route::post('/', [PegawaiKepanitiaanController::class, 'store'])->name('store');
        Route::get('/{kepanitiaan}', [PegawaiKepanitiaanController::class, 'show'])->name('show');
        Route::put('/{kepanitiaan}', [PegawaiKepanitiaanController::class, 'update'])->name('update');
        Route::delete('/{kepanitiaan}', [PegawaiKepanitiaanController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // JABATAN STRUKTURAL (hasMany)
    // ==========================================

    Route::prefix('{pegawai}/jabatan-struktural')->name('jabatan-struktural.')->group(function () {
        Route::get('/', [PegawaiJabatanStrukturalController::class, 'index'])->name('index');
        Route::post('/', [PegawaiJabatanStrukturalController::class, 'store'])->name('store');
        Route::get('/{jabatanStruktural}', [PegawaiJabatanStrukturalController::class, 'show'])->name('show');
        Route::put('/{jabatanStruktural}', [PegawaiJabatanStrukturalController::class, 'update'])->name('update');
        Route::delete('/{jabatanStruktural}', [PegawaiJabatanStrukturalController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // AKTIVITAS KERJA (hasMany)
    // ==========================================

    Route::prefix('{pegawai}/aktivitas-kerja')->name('aktivitas-kerja.')->group(function () {
        Route::get('/', [PegawaiAktivitasKerjaController::class, 'index'])->name('index');
        Route::post('/', [PegawaiAktivitasKerjaController::class, 'store'])->name('store');
        Route::get('/{aktivitasKerja}', [PegawaiAktivitasKerjaController::class, 'show'])->name('show');
        Route::put('/{aktivitasKerja}', [PegawaiAktivitasKerjaController::class, 'update'])->name('update');
        Route::delete('/{aktivitasKerja}', [PegawaiAktivitasKerjaController::class, 'destroy'])->name('destroy');
    });
});
