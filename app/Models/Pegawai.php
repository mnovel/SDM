<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'pegawai';

    protected $fillable = [
        'gelar_depan',
        'nama',
        'gelar_belakang',
        'nip',
        'jenis_identitas',
        'no_identitas',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'master_agama_id',
        'master_pendidikan_id',
        'master_status_pernikahan_id',
        'no_hp',
        'no_hp_darurat',
        'email',
        'email_rs',
        'master_provinsi_id',
        'master_kota_id',
        'master_kecamatan_id',
        'master_kelurahan_id',
        'alamat',
        'kode_pos',
        'master_provinsi_domisili_id',
        'master_kota_domisili_id',
        'master_kecamatan_domisili_id',
        'master_kelurahan_domisili_id',
        'alamat_domisili',
        'kode_pos_domisili',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ==========================================
    // RELASI KE TABEL MASTER (BelongsTo)
    // ==========================================

    public function agama()
    {
        return $this->belongsTo(MasterAgama::class, 'master_agama_id');
    }

    public function pendidikan_terakhir()
    {
        return $this->belongsTo(MasterPendidikan::class, 'master_pendidikan_id');
    }

    public function status_pernikahan()
    {
        return $this->belongsTo(MasterStatusPernikahan::class, 'master_status_pernikahan_id');
    }

    // Relasi Alamat KTP
    public function provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'master_provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(MasterKota::class, 'master_kota_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(MasterKecamatan::class, 'master_kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(MasterKelurahan::class, 'master_kelurahan_id');
    }

    // Relasi Alamat Domisili
    public function provinsi_domisili()
    {
        return $this->belongsTo(MasterProvinsi::class, 'master_provinsi_domisili_id');
    }

    public function kota_domisili()
    {
        return $this->belongsTo(MasterKota::class, 'master_kota_domisili_id');
    }

    public function kecamatan_domisili()
    {
        return $this->belongsTo(MasterKecamatan::class, 'master_kecamatan_domisili_id');
    }

    public function kelurahan_domisili()
    {
        return $this->belongsTo(MasterKelurahan::class, 'master_kelurahan_domisili_id');
    }

    // ==========================================
    // RELASI KE DATA PEGAWAI (HasOne / HasMany)
    // ==========================================

    public function kepegawaian_aktif()
    {
        return $this->hasOne(PegawaiKepegawaian::class)->where('is_aktif', true);
    }

    public function riwayat_kepegawaian()
    {
        return $this->hasMany(PegawaiKepegawaian::class);
    }

    public function nakes()
    {
        return $this->hasMany(PegawaiNakes::class);
    }

    public function rekening()
    {
        return $this->hasMany(PegawaiRekening::class);
    }

    // ==========================================
    // RELASI RIWAYAT (HasMany)
    // ==========================================

    public function pendidikan()
    {
        return $this->hasMany(PegawaiPendidikan::class)->orderBy('tahun_lulus', 'desc');
    }

    public function keluarga()
    {
        return $this->hasMany(PegawaiKeluarga::class);
    }

    public function dokumen()
    {
        return $this->hasMany(PegawaiDokumen::class);
    }

    public function kepangkatan()
    {
        return $this->hasMany(PegawaiKepangkatan::class)->orderBy('tmt', 'desc');
    }

    public function riwayat_kerja()
    {
        return $this->hasMany(PegawaiRiwayatKerja::class)->orderBy('tanggal_mulai', 'desc');
    }

    public function kepanitiaan()
    {
        return $this->hasMany(PegawaiKepanitiaan::class)->orderBy('tanggal_mulai', 'desc');
    }

    public function jabatan_struktural()
    {
        return $this->hasMany(PegawaiJabatanStruktural::class)->orderBy('tanggal_awal', 'desc');
    }

    public function aktivitas_kerja()
    {
        return $this->hasMany(PegawaiAktivitasKerja::class)->orderBy('tanggal_mulai', 'desc');
    }

    /**
     * Sinkronisasi Pendidikan Terakhir
     * Mengambil riwayat pendidikan dengan tahun lulus paling baru.
     */
    public function syncPendidikanTerakhir()
    {
        // Karena di relasi 'pendidikan()' Anda sudah ada ->orderBy('tahun_lulus', 'desc')
        // Kita cukup mengambil data pertama (yang paling baru)
        $latestPendidikan = $this->pendidikan()->first();

        // Update master_pendidikan_id di tabel pegawai
        $this->update([
            'master_pendidikan_id' => $latestPendidikan ? $latestPendidikan->master_pendidikan_id : null
        ]);
    }
}
