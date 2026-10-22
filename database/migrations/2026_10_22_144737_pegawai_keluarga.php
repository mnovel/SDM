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
        Schema::create('pegawai_keluarga', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawai')->onDelete('cascade');

            $table->string('nama');
            $table->enum('hubungan', ['Suami', 'Istri', 'Anak', 'Ayah', 'Ibu']);
            $table->string('nik', 16)->nullable();
            $table->string('no_bpjs', 20)->nullable();
            $table->date('tanggal_lahir');
            $table->boolean('is_tanggungan')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_keluarga');
    }
};
