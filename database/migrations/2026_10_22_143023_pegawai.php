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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('gelar_depan', 50)->nullable();
            $table->string('nama');
            $table->string('gelar_belakang', 50)->nullable();

            $table->string('nip', 30)->unique();
            $table->enum('jenis_identitas', ['KTP', 'SIM', 'PASSPORT']);
            $table->string('no_identitas')->unique();
            $table->string('tempat_lahir', 255);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->foreignId('master_agama_id')->constrained('master_agama')->restrictOnDelete();
            $table->foreignId('master_pendidikan_id')->constrained('master_pendidikan')->restrictOnDelete();
            $table->foreignId('master_status_pernikahan_id')->constrained('master_status_pernikahan')->restrictOnDelete();

            // Kontak
            $table->string('no_hp', 20)->nullable();
            $table->string('no_hp_darurat', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('email_rs', 255)->nullable();

            // Alamat KTP
            $table->foreignId('master_provinsi_id')->constrained('master_provinsi')->onDelete('cascade');
            $table->foreignId('master_kota_id')->constrained('master_kota')->onDelete('cascade');
            $table->foreignId('master_kecamatan_id')->constrained('master_kecamatan')->onDelete('cascade');
            $table->foreignId('master_kelurahan_id')->constrained('master_kelurahan')->onDelete('cascade');
            $table->string('alamat', 255);
            $table->string('kode_pos', 10);

            // Alamat Domisili
            $table->foreignId('master_provinsi_domisili_id')->nullable()->constrained('master_provinsi')->nullOnDelete();
            $table->foreignId('master_kota_domisili_id')->nullable()->constrained('master_kota')->nullOnDelete();
            $table->foreignId('master_kecamatan_domisili_id')->nullable()->constrained('master_kecamatan')->nullOnDelete();
            $table->foreignId('master_kelurahan_domisili_id')->nullable()->constrained('master_kelurahan')->nullOnDelete();
            $table->string('alamat_domisili', 255)->nullable();
            $table->string('kode_pos_domisili', 10)->nullable();

            $table->string('foto', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
