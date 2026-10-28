<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKelurahan extends Model
{
    use HasFactory;

    protected $table = 'master_kelurahan';

    protected $fillable = [
        'code',
        'district_code',
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
     * master_kelurahan.district_code → master_kecamatan.code
     */
    public function kecamatan()
    {
        return $this->belongsTo(MasterKecamatan::class, 'district_code', 'code');
    }
}
