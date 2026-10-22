<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKecamatan extends Model
{
    protected $table = 'master_kecamatan';

    protected $fillable = [
        'master_kota_id',
        'nama',
    ];

    public function kelurahan()
    {
        return $this->hasMany(MasterKelurahan::class, 'master_kecamatan_id');
    }

    public function kota()
    {
        return $this->belongsTo(MasterKota::class, 'master_kota_id');
    }
}
