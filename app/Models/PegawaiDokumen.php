<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiDokumen extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_dokumen';

    protected $fillable = [
        'pegawai_id',
        'jenis_dokumen',
        'nomor_dokumen',
        'file_path',
        'tanggal_kadaluarsa',
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
