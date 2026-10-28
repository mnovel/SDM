<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiKepangkatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai_kepangkatan';

    protected $fillable = [
        'pegawai_id',
        'status_kerja',
        'master_pangkat_id',
        'no_sk',
        'tmt',
        'berkala',
        'file_berkas',
    ];

    protected $casts = [
        'tmt'     => 'date',
        'berkala' => 'date',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function pangkat()
    {
        return $this->belongsTo(MasterPangkat::class, 'master_pangkat_id');
    }
}
