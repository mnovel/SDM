<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiAktivitasKerja extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_aktivitas_kerja';

    protected $fillable = [
        'pegawai_id',
        'status_aktivitas',
        'no_surat',
        'tanggal_mulai',
        'tanggal_selesai',
        'file_berkas',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
