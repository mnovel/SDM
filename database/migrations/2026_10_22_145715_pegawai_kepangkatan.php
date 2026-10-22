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
        Schema::create('pegawai_kepangkatan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawai')->onDelete('cascade');

            $table->string('status_kerja');
            $table->foreignId('master_pangkat_id')->constrained('master_pangkat')->restrictOnDelete();
            $table->string('no_sk');
            $table->date('tmt');
            $table->date('berkala')->nullable();

            $table->string('file_berkas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_kepangkatan');
    }
};
