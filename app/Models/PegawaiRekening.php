<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiRekening extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_rekening';

    protected $fillable = [
        'pegawai_id',
        'nama_bank',
        'no_rekening',
        'atas_nama',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
