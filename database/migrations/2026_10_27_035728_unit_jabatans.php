<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_jabatans', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke Unit dan Jabatan
            $table->foreignUuid('unit_id')->constrained('master_unit')->cascadeOnDelete();
            $table->foreignUuid('jabatan_id')->constrained('master_jabatan')->cascadeOnDelete();

            // Field tambahan dari aplikasi lama
            $table->string('kode_jabatan', 50)->nullable(); // Untuk menyimpan JBT_KODE (misal: 01.02.01)
            $table->boolean('is_aktif')->default(true);     // Untuk menyimpan JBT_AKTIF

            $table->timestamps();

            // Mencegah duplikasi (satu unit tidak boleh punya jabatan yang sama persis)
            $table->unique(['unit_id', 'jabatan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_jabatans');
    }
};
