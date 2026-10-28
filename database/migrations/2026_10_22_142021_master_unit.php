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
        Schema::create('master_unit', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 255)->unique();
            $table->string('nama_singkat', 30)->unique();
            $table->integer('level');

            $table->foreignUuid('parent_id')
                ->nullable()
                ->constrained('master_unit')
                ->restrictOnDelete();

            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_unit');
    }
};
