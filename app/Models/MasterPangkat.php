<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPangkat extends Model
{
    use HasFactory;

    protected $table = 'master_pangkat';

    protected $fillable = [
        'pangkat',
        'golongan',
        'pendidikan_id',
        'status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pendidikan()
    {
        return $this->belongsTo(MasterPendidikan::class, 'pendidikan_id');
    }
}
