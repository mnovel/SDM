<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiKepegawaian extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_kepegawaian';

    protected $fillable = [
        'pegawai_id',
        'master_status_pegawai_id',
        'master_unit_id',
        'master_jabatan_id',
        'tmt_awal',
        'tmt_akhir',
        'is_aktif',
    ];

    protected $casts = [
        'tmt_awal'  => 'date',
        'tmt_akhir' => 'date',
        'is_aktif'  => 'boolean',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function status_pegawai()
    {
        return $this->belongsTo(MasterStatusPegawai::class, 'master_status_pegawai_id');
    }

    public function unit()
    {
        return $this->belongsTo(MasterUnit::class, 'master_unit_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(MasterJabatan::class, 'master_jabatan_id');
    }
}
