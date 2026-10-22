<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSuku extends Model
{
    use HasFactory;

    protected $table = 'master_suku';

    protected $fillable = [
        'nama',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
