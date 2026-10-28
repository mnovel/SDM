<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJabatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'master_jabatan';

    protected $fillable = [
        'nama',
        'nama_singkat',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    protected $attributes = [
        'status' => 'Aktif',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function kepegawaian()
    {
        return $this->hasMany(PegawaiKepegawaian::class, 'master_jabatan_id');
    }

    public function jabatan_struktural()
    {
        return $this->hasMany(PegawaiJabatanStruktural::class, 'master_jabatan_id');
    }

    public function unit_formasi()
    {
        return $this->hasMany(UnitJabatan::class, 'jabatan_id');
    }
}
