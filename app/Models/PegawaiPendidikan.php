<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiPendidikan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_pendidikan';

    protected $fillable = [
        'pegawai_id',
        'master_pendidikan_id',
        'nama_institusi',
        'jurusan',
        'tahun_lulus',
        'no_ijazah',
        'file_ijazah',
    ];

    protected $casts = [
        'tahun_lulus' => 'integer',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function pendidikan()
    {
        return $this->belongsTo(MasterPendidikan::class, 'master_pendidikan_id');
    }
}
