<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiKeluarga extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_keluarga';

    protected $fillable = [
        'pegawai_id',
        'nama',
        'hubungan',
        'nik',
        'no_bpjs',
        'tanggal_lahir',
        'is_tanggungan',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'is_tanggungan'  => 'boolean',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
