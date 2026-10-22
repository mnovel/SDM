<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_libur', function (Blueprint $table) {
            $table->id();
            $table->string('nama_libur');
            $table->date('tanggal_libur');
            $table->enum('jenis_libur', ['Nasional', 'Regional', 'Lokal'])->default('Nasional');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_libur');
    }
};
