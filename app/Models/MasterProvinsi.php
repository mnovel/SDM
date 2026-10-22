<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProvinsi extends Model
{
    use HasFactory;

    protected $table = 'master_provinsi';

    protected $fillable = [
        'nama',
    ];


    public function kota()
    {
        return $this->hasMany(MasterKota::class, 'master_provinsi_id');
    }
}
