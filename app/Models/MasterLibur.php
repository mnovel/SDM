<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLibur extends Model
{
    use HasFactory;

    protected $table = 'master_libur';

    protected $fillable = [
        'nama_libur',
        'tanggal_libur',
        'jenis_libur',
        'status',
    ];

    protected $casts = [
        'tanggal_libur' => 'date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
