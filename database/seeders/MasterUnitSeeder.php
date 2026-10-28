<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterUnit;

class MasterUnitSeeder extends Seeder
{
    public function run(): void
    {
        // Hierarki persis sesuai Bagan Organisasi
        $data = [
            // ==========================================
            // LEVEL 1
            // ==========================================
            ['nama' => 'Direktur', 'parent' => null],

            // ==========================================
            // LEVEL 2 (Di bawah Direktur)
            // ==========================================
            ['nama' => 'Kelompok Jabatan Fungsional', 'parent' => 'Direktur'],
            ['nama' => 'Bagian Tata Usaha', 'parent' => 'Direktur'],
            ['nama' => 'Bidang Pelayanan', 'parent' => 'Direktur'],
            ['nama' => 'Bidang Keperawatan', 'parent' => 'Direktur'],
            ['nama' => 'Bidang Pengembangan & Pengaduan', 'parent' => 'Direktur'],

            // ==========================================
            // LEVEL 3 (Seksi & Sub Bagian)
            // ==========================================
            // Sub Bagian di bawah Tata Usaha
            ['nama' => 'Sub Bagian Perencanaan & Evaluasi', 'parent' => 'Bagian Tata Usaha'],
            ['nama' => 'Sub Bagian Umum & Kepegawaian', 'parent' => 'Bagian Tata Usaha'],
            ['nama' => 'Sub Bagian Keuangan', 'parent' => 'Bagian Tata Usaha'],

            // Seksi di bawah Bidang Pelayanan
            ['nama' => 'Seksi Pelayanan Medis & Rujukan', 'parent' => 'Bidang Pelayanan'],
            ['nama' => 'Seksi Pelayanan Penunjang Medis & Non Medis', 'parent' => 'Bidang Pelayanan'],

            // Seksi di bawah Bidang Keperawatan
            ['nama' => 'Seksi Pelayanan & Asuhan Keperawatan', 'parent' => 'Bidang Keperawatan'],
            ['nama' => 'Seksi Etika & Mutu Keperawatan', 'parent' => 'Bidang Keperawatan'],

            // Seksi di bawah Bidang Pengembangan & Pengaduan
            ['nama' => 'Seksi Diklat & Pengembangan', 'parent' => 'Bidang Pengembangan & Pengaduan'],
            ['nama' => 'Seksi Pengaduan', 'parent' => 'Bidang Pengembangan & Pengaduan'],

            // ==========================================
            // LEVEL 4 (Unit Pelaksana dari ms_unit.txt)
            // ==========================================

            // Di bawah Seksi Pelayanan Medis & Rujukan
            ['nama' => 'Instalasi Rawat Jalan', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'Instalasi Gawat Darurat', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'Bedah Sentral', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'Rehabilitasi Medis', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'Anestesiologi Dan Terapi Intensif', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'Rawat Intensif', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'INSTALASI DIALISIS', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'ICU', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'HCU', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'OBYGN', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'Ambulans', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],
            ['nama' => 'Kecantikan', 'parent' => 'Seksi Pelayanan Medis & Rujukan'],

            // Di bawah Seksi Pelayanan Penunjang Medis & Non Medis
            ['nama' => 'Rekam Medis', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Laboratorium', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Radiologi', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Farmasi', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Gizi', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Bank Darah', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Sterilisasi', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Pulasara Jenazah', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Gas Medis', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],
            ['nama' => 'Laundry', 'parent' => 'Seksi Pelayanan Penunjang Medis & Non Medis'],

            // Di bawah Seksi Pelayanan & Asuhan Keperawatan
            ['nama' => 'Instalasi Rawat Inap', 'parent' => 'Seksi Pelayanan & Asuhan Keperawatan'],
            ['nama' => 'Persalinan', 'parent' => 'Seksi Pelayanan & Asuhan Keperawatan'],
            ['nama' => 'Kamar Bersalin', 'parent' => 'Seksi Pelayanan & Asuhan Keperawatan'],
            ['nama' => 'RUANG ANAK', 'parent' => 'Seksi Pelayanan & Asuhan Keperawatan'],

            // Di bawah Sub Bagian Umum & Kepegawaian
            ['nama' => 'Unit Rumah Tangga', 'parent' => 'Sub Bagian Umum & Kepegawaian'],
            ['nama' => 'Teknologi Informasi', 'parent' => 'Sub Bagian Umum & Kepegawaian'],
            ['nama' => 'Unit Layanan Pengadaan', 'parent' => 'Sub Bagian Umum & Kepegawaian'],
            ['nama' => 'Unit Pengadaan Barang dan Jasa', 'parent' => 'Sub Bagian Umum & Kepegawaian'],
            ['nama' => 'Pemeliharaan Sarana', 'parent' => 'Sub Bagian Umum & Kepegawaian'],
            ['nama' => 'Keamanan Dan Transportasi', 'parent' => 'Sub Bagian Umum & Kepegawaian'],
            ['nama' => 'Logistik', 'parent' => 'Sub Bagian Umum & Kepegawaian'],
            ['nama' => 'Koperasi', 'parent' => 'Sub Bagian Umum & Kepegawaian'],

            // Di bawah Sub Bagian Keuangan
            ['nama' => 'Kasir', 'parent' => 'Sub Bagian Keuangan'],

            // Tambahan (jika Manajemen dianggap unit tersendiri di bawah Direktur)
            ['nama' => 'Manajemen', 'parent' => 'Direktur'],
        ];

        foreach ($data as $index => $item) {
            $nama = trim($item['nama']);
            $parentName = $item['parent'];

            // Cari ID dan Level dari Parent
            $parentId = null;
            $level = 1;

            if ($parentName !== null) {
                $parent = MasterUnit::where('nama', $parentName)->first();
                if ($parent) {
                    $parentId = $parent->id;
                    $level = $parent->level + 1;
                }
            }

            // Buat nama_singkat otomatis (Contoh: "Seksi Pelayanan Medis & Rujukan" -> "SPMR-10")
            $words = explode(' ', $nama);
            $acronym = '';
            foreach ($words as $word) {
                $cleanWord = preg_replace('/[^A-Za-z0-9]/', '', $word);
                if (!empty($cleanWord)) {
                    $acronym .= strtoupper(substr($cleanWord, 0, 1));
                }
            }
            $namaSingkat = substr($acronym, 0, 10) . '-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);

            // Insert / Update data
            MasterUnit::updateOrCreate(
                ['nama' => $nama],
                [
                    'nama_singkat' => substr($namaSingkat, 0, 30),
                    'parent_id'    => $parentId,
                    'level'        => $level,
                    'status'       => 'Aktif',
                ]
            );
        }
    }
}
