<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**mas
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawai_kepegawaian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawai')->onDelete('cascade');

            $table->foreignId('master_status_pegawai_id')->constrained('master_status_pegawai')->restrictOnDelete();
            $table->foreignUuid('master_unit_id')->constrained('master_unit');
            $table->foreignUuid('master_jabatan_id')->constrained('master_jabatan');

            $table->date('tmt_awal');
            $table->date('tmt_akhir')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_kepegawaian');
    }
};
