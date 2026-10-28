<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MasterUnit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'master_unit';

    protected $fillable = [
        'nama',
        'nama_singkat',
        'status',
        'level',
        'parent_id',
    ];

    protected $casts = [
        'status' => 'string',
        'level'  => 'integer',   // [FIX] biar konsisten tipe saat dihitung
    ];

    protected $attributes = [
        'status' => 'Aktif',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    /**
     * Unit induk (self-referencing).
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Sub-unit langsung (self-referencing).
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('nama');
    }

    public function formasi_jabatan()
    {
        return $this->hasMany(UnitJabatan::class, 'unit_id');
    }

    public function kepegawaian()
    {
        return $this->hasMany(PegawaiKepegawaian::class, 'master_unit_id');
    }

    public function jabatan_struktural()
    {
        return $this->hasMany(PegawaiJabatanStruktural::class, 'master_unit_id');
    }

    // ==========================================
    // HELPER
    // ==========================================

    /**
     * Cek apakah $this adalah ancestor (induk / kakek / dst) dari $node.
     * Dipakai untuk mencegah cycle saat mengubah parent_id.
     *
     * Contoh: $unit->isAncestorOf($newParent) === true
     *         → menetapkan $newParent sebagai induk akan membuat siklus.
     */
    public function isAncestorOf(self $node): bool
    {
        $current = $node->parent;

        while ($current !== null) {
            if ($current->id === $this->id) {
                return true;
            }
            $current = $current->parent;
        }

        return false;
    }

    /**
     * Semua descendant (rekursif).
     * Opsional — berguna untuk validasi / laporan. Tidak dipakai controller saat ini.
     */
    public function descendants(): Collection
    {
        $result = collect();

        foreach ($this->children as $child) {
            $result->push($child);
            $result = $result->merge($child->descendants());
        }

        return $result;
    }
}
