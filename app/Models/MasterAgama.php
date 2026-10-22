<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAgama extends Model
{
    use HasFactory;

    protected $table = 'master_agama';

    protected $fillable = [
        'nama_agama',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
