<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStatusPernikahan extends Model
{
    use HasFactory;

    protected $table = 'master_status_pernikahan';

    protected $fillable = [
        'status_pernikahan',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    protected $attributes = [
        'status' => 'Aktif',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
