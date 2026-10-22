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
        Schema::create('pegawai_pendidikan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawai')->onDelete('cascade');

            $table->foreignId('master_pendidikan_id')->constrained('master_pendidikan');
            $table->string('nama_institusi');
            $table->string('jurusan');
            $table->year('tahun_lulus');
            $table->string('no_ijazah')->nullable();
            $table->string('file_ijazah')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_pendidikan');
    }
};
