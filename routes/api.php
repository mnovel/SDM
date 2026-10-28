<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    require __DIR__ . '/api/v1/auth.php';

    Route::middleware('auth:api')->group(function () {
        require __DIR__ . '/api/v1/masterdata.php';
        require __DIR__ . '/api/v1/pegawai.php';
        // require __DIR__.'/api/v1/attendance.php';
    });
});
