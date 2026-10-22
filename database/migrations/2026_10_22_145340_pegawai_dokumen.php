<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai_dokumen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawai')->onDelete('cascade');

            // Jenis dokumen: KTP, KK, NPWP, BPJS, SK CPNS, SK PNS, dll
            $table->string('jenis_dokumen');

            $table->string('nomor_dokumen')->nullable(); // Nomor KTP/NPWP/SK
            $table->string('file_path', 255); // Lokasi file disimpan
            $table->date('tanggal_kadaluarsa')->nullable(); // Opsional, untuk dokumen yg ada exp-nya

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai_dokumen');
    }
};
