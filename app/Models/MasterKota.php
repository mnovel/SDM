<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKota extends Model
{
    use HasFactory;

    protected $table = 'master_kota';

    protected $fillable = [
        'master_provinsi_id',
        'nama',
    ];

    public function kecamatan()
    {
        return $this->hasMany(MasterKecamatan::class, 'master_kota_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'master_provinsi_id');
    }
}
