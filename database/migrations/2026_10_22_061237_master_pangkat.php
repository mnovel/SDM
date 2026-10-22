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
        Schema::create('master_pangkat', function (Blueprint $table) {
            $table->id();
            $table->string('pangkat', 100);
            $table->string('golongan', 50);
            $table->foreignId('pendidikan_id')->constrained('master_pendidikan')->onDelete('cascade');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pangkat');
    }
};
