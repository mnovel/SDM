<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStatusPegawai extends Model
{
    use HasFactory;

    protected $table = 'master_status_pegawai';

    protected $fillable = [
        'nama',
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
        return $this->hasMany(PegawaiKepegawaian::class, 'master_status_pegawai_id');
    }
}
