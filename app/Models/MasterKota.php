<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKota extends Model
{
    use HasFactory;

    protected $table = 'master_kota';

    protected $fillable = [
        'code',
        'province_code',
        'name',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * master_kota.province_code → master_provinsi.code
     */
    public function provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'province_code', 'code');
    }

    /**
     * master_kecamatan.city_code → master_kota.code
     */
    public function kecamatan()
    {
        return $this->hasMany(MasterKecamatan::class, 'city_code', 'code');
    }
}
