<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiNakes extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_nakes';

    protected $fillable = [
        'pegawai_id',
        'profesi',
        'no_str',
        'tgl_berakhir_str',
        'file_str',
        'no_sip',
        'tgl_berakhir_sip',
        'file_sip',
        'no_sik',
    ];

    protected $casts = [
        'tgl_berakhir_str' => 'date',
        'tgl_berakhir_sip' => 'date',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
