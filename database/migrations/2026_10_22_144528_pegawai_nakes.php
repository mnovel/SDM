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
        Schema::create('pegawai_nakes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pegawai_id')->constrained('pegawai')->onDelete('cascade');

            $table->string('profesi');
            $table->string('no_str', 50);
            $table->date('tgl_berakhir_str');
            $table->string('file_str', 255)->nullable();

            $table->string('no_sip', 50)->nullable();
            $table->date('tgl_berakhir_sip')->nullable();
            $table->string('file_sip', 255)->nullable();

            $table->string('no_sik', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_nakes');
    }
};
