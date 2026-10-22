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
        Schema::create('pegawai_jabatan_struktural', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawai')->onDelete('cascade');

            $table->foreignId('master_jabatan_id')->constrained('master_jabatan')->restrictOnDelete();
            $table->foreignId('master_unit_id')->nullable()->constrained('master_unit')->nullOnDelete();
            $table->string('no_sk');
            $table->date('tanggal_awal');
            $table->string('file_berkas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_jabatan_struktural');
    }
};
