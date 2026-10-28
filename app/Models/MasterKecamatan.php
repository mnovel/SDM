<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKecamatan extends Model
{
    use HasFactory;

    protected $table = 'master_kecamatan';

    protected $fillable = [
        'code',
        'city_code',
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
     * master_kecamatan.city_code → master_kota.code
     */
    public function kota()
    {
        return $this->belongsTo(MasterKota::class, 'city_code', 'code');
    }

    /**
     * master_kelurahan.district_code → master_kecamatan.code
     */
    public function kelurahan()
    {
        return $this->hasMany(MasterKelurahan::class, 'district_code', 'code');
    }
}
