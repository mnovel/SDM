<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKelurahan extends Model
{
    protected $table = 'master_kelurahan';

    protected $fillable = [
        'master_kota_id',
        'nama',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(MasterKecamatan::class, 'master_kecamatan_id');
    }
}
