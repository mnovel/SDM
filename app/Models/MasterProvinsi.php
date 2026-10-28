<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProvinsi extends Model
{
    use HasFactory;

    protected $table = 'master_provinsi';

    protected $fillable = [
        'code',
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
     * Relasi ke kota.
     * master_kota.province_code → master_provinsi.code
     */
    public function kota()
    {
        return $this->hasMany(MasterKota::class, 'province_code', 'code');
    }
}
