<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UnitJabatan extends Model
{
    use HasUuids;

    protected $table = 'unit_jabatans';

    protected $fillable = [
        'unit_id',
        'jabatan_id',
        'kode_jabatan',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    // Relasi balik ke Unit
    public function unit()
    {
        return $this->belongsTo(MasterUnit::class, 'unit_id');
    }

    // Relasi balik ke Jabatan
    public function jabatan()
    {
        return $this->belongsTo(MasterJabatan::class, 'jabatan_id');
    }
}
