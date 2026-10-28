<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiKepanitiaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_kepanitiaan';

    protected $fillable = [
        'pegawai_id',
        'kegiatan',
        'no_surat',
        'tingkat',
        'tanggal_mulai',
        'tanggal_selesai',
        'file_berkas',
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
