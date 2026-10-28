<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\PegawaiKepegawaian;
use App\Models\PegawaiKeluarga;
use App\Models\PegawaiPendidikan;
use App\Models\PegawaiNakes;
use App\Models\PegawaiRekening;
use App\Models\PegawaiKepangkatan;
use App\Models\PegawaiJabatanStruktural;
use App\Models\PegawaiDokumen;
use App\Models\PegawaiRiwayatKerja;
use App\Models\PegawaiKepanitiaan;
use App\Models\PegawaiAktivitasKerja;
use App\Models\MasterAgama;
use App\Models\MasterPendidikan;
use App\Models\MasterStatusPernikahan;
use App\Models\MasterStatusPegawai;
use App\Models\MasterUnit;
use App\Models\MasterJabatan;
use App\Models\MasterPangkat;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        // 1. AMBIL DATA MASTER (Pastikan Seeder Master sudah dijalankan)
        $agama = MasterAgama::first();
        $pendidikan = MasterPendidikan::first();
        $statusPernikahan = MasterStatusPernikahan::first();

        $statusPegawai = MasterStatusPegawai::first();
        $unit = MasterUnit::first();
        $jabatan = MasterJabatan::first();
        $pangkat = MasterPangkat::first();

        // Validasi Dependensi
        if (!$agama || !$pendidikan || !$statusPernikahan || !$statusPegawai || !$unit || !$jabatan || !$pangkat) {
            $this->command->error('❌ Gagal: Pastikan Master Data (Agama, Pendidikan, Status, Unit, Jabatan, Pangkat) sudah di-seed terlebih dahulu!');
            return;
        }

        // Ambil data wilayah dari package Laravolt (ID 3578 = Surabaya, dll)
        $provinsi = DB::table('master_provinsi')->where('id', 35)->first() ?? DB::table('master_provinsi')->first();
        $kota = DB::table('master_kota')->where('id', 3578)->first() ?? DB::table('master_kota')->first();
        $kecamatan = DB::table('master_kecamatan')->where('city_code', 3578)->first() ?? DB::table('master_kecamatan')->first();
        $kelurahan = DB::table('master_kelurahan')->where('district_code', $kecamatan->code)->first() ?? DB::table('master_kelurahan')->first();

        if (!$provinsi || !$kota || !$kecamatan || !$kelurahan) {
            $this->command->error('❌ Gagal: Data wilayah (Provinsi/Kota/Kecamatan/Kelurahan) belum di-seed!');
            return;
        }

        // Bungkus dengan Transaction agar jika gagal di tengah jalan, data tidak masuk setengah-setengah
        DB::beginTransaction();
        try {
            // ==========================================
            // 2. BUAT DATA PEGAWAI (INDUK)
            // ==========================================
            $pegawai = Pegawai::create([
                'gelar_depan'                 => 'dr.',
                'nama'                        => 'Budi Santoso',
                'gelar_belakang'              => 'Sp.PD',
                'nip'                         => '198501012010011001',
                'jenis_identitas'             => 'KTP',
                'no_identitas'                => '3578014101850001', // NIK 16 digit
                'tempat_lahir'                => 'Surabaya',
                'tanggal_lahir'               => '1985-01-01',
                'jenis_kelamin'               => 'Laki-Laki',
                'master_agama_id'             => $agama->id,
                'master_pendidikan_id'        => $pendidikan->id,
                'master_status_pernikahan_id' => $statusPernikahan->id,
                'no_hp'                       => '081234567890',
                'email'                       => 'budi.santoso@rsud.local',
                'master_provinsi_id'          => $provinsi->id,
                'master_kota_id'              => $kota->id,
                'master_kecamatan_id'         => $kecamatan->id,
                'master_kelurahan_id'         => $kelurahan->id,
                'alamat'                      => 'Jl. Raya Darmo No. 123',
                'kode_pos'                    => '60241',
                'foto'                        => null,
            ]);

            // ==========================================
            // 3. BUAT RELASI KEPEGAWAIAN (AKTIF)
            // ==========================================
            PegawaiKepegawaian::create([
                'pegawai_id'               => $pegawai->id,
                'master_status_pegawai_id' => $statusPegawai->id, // misal: PNS
                'master_unit_id'           => $unit->id,
                'master_jabatan_id'        => $jabatan->id,
                'tmt_awal'                 => '2020-01-01',
                'is_aktif'                 => true,
            ]);

            // ==========================================
            // 4. BUAT RELASI NAKES & REKENING (HAS ONE)
            // ==========================================
            PegawaiNakes::create([
                'pegawai_id'       => $pegawai->id,
                'profesi'          => 'Dokter Spesialis Penyakit Dalam',
                'no_str'           => 'STR-1234567890',
                'tgl_berakhir_str' => '2028-12-31',
                'no_sip'           => 'SIP-1234567890',
                'tgl_berakhir_sip' => '2028-12-31',
                'no_sik'           => 'SIK-1234567890',
            ]);

            PegawaiRekening::create([
                'pegawai_id'  => $pegawai->id,
                'nama_bank'   => 'Bank Jatim',
                'no_rekening' => '1234567890',
                'atas_nama'   => 'Budi Santoso',
            ]);

            // ==========================================
            // 5. BUAT RELASI RIWAYAT (HAS MANY)
            // ==========================================

            // Keluarga
            PegawaiKeluarga::create([
                'pegawai_id'     => $pegawai->id,
                'nama'           => 'Siti Aminah',
                'hubungan'       => 'Istri',
                'nik'            => '3578014101900002',
                'tanggal_lahir'  => '1990-01-01',
                'is_tanggungan'  => true,
            ]);

            // Pendidikan
            PegawaiPendidikan::create([
                'pegawai_id'           => $pegawai->id,
                'master_pendidikan_id' => $pendidikan->id,
                'nama_institusi'       => 'Universitas Airlangga',
                'jurusan'              => 'Kedokteran',
                'tahun_lulus'          => 2010,
                'no_ijazah'            => 'IJZ-123456',
            ]);

            // Kepangkatan
            PegawaiKepangkatan::create([
                'pegawai_id'        => $pegawai->id,
                'status_kerja'      => 'PNS',
                'master_pangkat_id' => $pangkat->id,
                'no_sk'             => 'SK/123/2020',
                'tmt'               => '2020-04-01',
                'berkala'           => '2024-04-01',
            ]);

            // Jabatan Struktural
            PegawaiJabatanStruktural::create([
                'pegawai_id'        => $pegawai->id,
                'master_jabatan_id' => $jabatan->id,
                'master_unit_id'    => $unit->id,
                'no_sk'             => 'SK/789/2020',
                'tanggal_awal'      => '2020-01-01',
            ]);

            // Dokumen
            PegawaiDokumen::create([
                'pegawai_id'     => $pegawai->id,
                'jenis_dokumen'  => 'KTP',
                'nomor_dokumen'  => '3578014101850001',
                'file_path'      => 'pegawai/dokumen/dummy-ktp.pdf',
            ]);

            // Riwayat Kerja
            PegawaiRiwayatKerja::create([
                'pegawai_id'      => $pegawai->id,
                'no_surat'        => 'SR/001/2015',
                'unit_kerja'      => 'RS Swasta Surabaya',
                'klasifikasi'     => 'Internal',
                'posisi'          => 'Dokter Umum',
                'tanggal_mulai'   => '2015-01-01',
                'tanggal_selesai' => '2019-12-31',
            ]);

            // Kepanitiaan
            PegawaiKepanitiaan::create([
                'pegawai_id'      => $pegawai->id,
                'kegiatan'        => 'Panitia Bulan K3',
                'no_surat'        => 'SK/456/2024',
                'tingkat'         => 'Nasional',
                'tanggal_mulai'   => '2024-01-15',
                'tanggal_selesai' => '2024-02-15',
            ]);

            // Aktivitas Kerja
            PegawaiAktivitasKerja::create([
                'pegawai_id'       => $pegawai->id,
                'status_aktivitas' => 'Cuti Tahunan',
                'no_surat'         => 'CUTI/001/2024',
                'tanggal_mulai'    => '2024-06-01',
                'tanggal_selesai'  => '2024-06-05',
                'keterangan'       => 'Cuti tahunan 2024',
            ]);

            DB::commit();
            $this->command->info('✅ PegawaiSeeder: 1 Pegawai lengkap beserta seluruh riwayat berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Gagal membuat Pegawai: ' . $e->getMessage());
        }
    }
}
