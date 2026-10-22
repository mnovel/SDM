<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPendidikan extends Model
{
    use HasFactory;

    protected $table = 'master_pendidikan';

    protected $fillable = ['pendidikan'];

    protected $hidden = ['created_at', 'updated_at'];

    public function pangkat()
    {
        return $this->hasMany(MasterPangkat::class, 'pendidikan_id');
    }
}
