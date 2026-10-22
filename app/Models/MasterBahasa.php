<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBahasa extends Model
{
    use HasFactory;

    protected $table = 'master_bahasa';

    protected $fillable = [
        'bahasa',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
