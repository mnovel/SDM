<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiJabatanStruktural extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_jabatan_struktural';

    protected $fillable = [
        'pegawai_id',
        'master_jabatan_id',
        'master_unit_id',
        'no_sk',
        'tanggal_awal',
        'file_berkas',
    ];

    protected $casts = [
        'tanggal_awal' => 'date',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(MasterJabatan::class, 'master_jabatan_id');
    }

    public function unit()
    {
        return $this->belongsTo(MasterUnit::class, 'master_unit_id');
    }
}
