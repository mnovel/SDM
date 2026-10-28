<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterUnit;
use App\Models\MasterJabatan;
use App\Models\UnitJabatan;
use Illuminate\Support\Str;

class UnitJabatanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. MAPPING ID UNIT LAMA KE NAMA UNIT BARU
        // Menyesuaikan dengan struktur MasterUnitSeeder.php Anda
        $legacyUnitMap = [
            1  => 'Direktur',
            2  => 'Bagian Tata Usaha', // Wadir Umum & Keuangan di bawah Tata Usaha
            3  => 'Bidang Pelayanan',  // Wadir Pelayanan
            6  => 'Sub Bagian Perencanaan & Evaluasi', // Kabag Perencanaan
            7  => 'Sub Bagian Umum & Kepegawaian',     // Kabag Umum
            8  => 'Sub Bagian Keuangan',               // Kabag Keuangan
            9  => 'Seksi Pelayanan Medis & Rujukan',   // Kabag Yanmed
            10 => 'Seksi Pelayanan Penunjang Medis & Non Medis', // Kabid Penunjang
            11 => 'Seksi Pelayanan & Asuhan Keperawatan',        // Kabid Keperawatan
            12 => 'Sub Bagian Perencanaan & Evaluasi', // Kasubbag Perencanaan
            13 => 'Sub Bagian Umum & Kepegawaian',     // Kasubbag Hukum & Humas
            14 => 'Sub Bagian Umum & Kepegawaian',     // Kasubbag Pengembangan SDM
            15 => 'Sub Bagian Umum & Kepegawaian',     // Kasubbag TU
            16 => 'Sub Bagian Umum & Kepegawaian',     // Kasubbag Adm SDM
            17 => 'Sub Bagian Umum & Kepegawaian',     // Kasubbag RTP
            18 => 'Sub Bagian Keuangan',               // Kasubbag Pendapatan
            19 => 'Sub Bagian Keuangan',               // Kasubbag Belanja
            20 => 'Sub Bagian Keuangan',               // Kasubbag Akuntansi
            21 => 'Seksi Pelayanan Medis & Rujukan',   // Kasi Yanmed
            22 => 'Rekam Medis',                       // Kasubbag RM
            23 => 'Seksi Pelayanan Penunjang Medis & Non Medis', // Kasi Penunjang
            25 => 'Seksi Pelayanan & Asuhan Keperawatan',
            26 => 'Seksi Pelayanan & Asuhan Keperawatan',
            97 => 'Kelompok Jabatan Fungsional',       // Komite Farmasi
            139 => 'Kelompok Jabatan Fungsional',       // Komite Medik
            // Map default jika tidak ditemukan
            'default' => 'Kelompok Jabatan Fungsional',
        ];

        // 2. DATA DARI MS_JABATAN.CSV
        // Format: [Legacy Unit ID, Nama Jabatan, Kode Jabatan]
        $legacyData = [
            [1, 'Direktur', '01'],
            [2, 'Wadir Umum dan Keuangan', '01.01'],
            [3, 'Wadir Pelayanan', '01.02'],
            [9, 'Kabag Yanmed dan RM', '01.02.01'],
            [10, 'Kabid Penunjang Medis dan Non Medis', '01.02.02'],
            [11, 'Kabid Keperawatan', '01.02.03'],
            [6, 'Kabag Perencanaan', '01.03.02'],
            [7, 'Kabag Umum', '01.01.02'],
            [8, 'Kabag Keuangan', '01.01.03'],
            [97, 'Ketua Komite Farmasi dan Terapi', '01.02.04'],
            [139, 'Ketua Komite Medik', '01.09'],
            [12, 'Kasubbag Perencanaan', '01.03.02.01'],
            [13, 'Kasubbag Hukum dan Humas', '01.01.01.02'],
            [14, 'Kasubbag Pengembangan SDM', '01.03.01.03'],
            [15, 'Kasubbag Tata Usaha', '01.01.02.01'],
            [16, 'Kasubbag Administrasi SDM', '01.03.01.01'],
            [17, 'Kasubbag RTP', '01.01.02.03'],
            [18, 'Kasubbag Pendapatan', '01.01.03.01'],
            [19, 'Kasubbag Belanja', '01.01.03.02'],
            [20, 'Kasubbag Akuntansi', '01.01.03.03'],
            [21, 'Kasi Pelayanan Medis', '01.02.01.01'],
            [22, 'Kasubbag Rekam Medis', '01.02.01.02'],
            [23, 'Kasi Penunjang Medis', '01.02.02.01'],
            [24, 'Kasi Penunjang Non Medis', '01.02.02.02'],
            [26, 'Kasi Asuhan Keperawatan', '01.02.03.01'],
            [25, 'Kasi Pengembangan Paramedis', '01.02.03.02'],
            [23, 'Apoteker Muda', '01.02.02.01.01'],
            [23, 'Staf Penunjang Medis', '01.02.02.01.02'],
            [42, 'Front Office IGD', '01.01.02.01.02.04.07'],
            [5, 'Duty Manager', '01.03.11'],
        ];

        foreach ($legacyData as $item) {
            $legacyUnitId = $item[0];
            $namaJabatanLegacy = trim($item[1]);
            $kodeJabatan = $item[2];

            // A. Cari Unit Baru
            $namaUnitBaru = $legacyUnitMap[$legacyUnitId] ?? $legacyUnitMap['default'];
            $unit = MasterUnit::where('nama', $namaUnitBaru)->first();

            // B. Cari Jabatan Baru (Gunakan LIKE untuk toleransi perbedaan format)
            $jabatan = MasterJabatan::where('nama', 'LIKE', "%{$namaJabatanLegacy}%")->first();

            // C. Insert ke Tabel Pivot jika Unit dan Jabatan ketemu
            if ($unit && $jabatan) {
                UnitJabatan::updateOrCreate(
                    [
                        'unit_id'    => $unit->id,
                        'jabatan_id' => $jabatan->id,
                    ],
                    [
                        'kode_jabatan' => $kodeJabatan,
                        'is_aktif'     => true,
                    ]
                );
            } else {
                // Opsional: Log jika ada data yang tidak ketemu saat seeding
                // $this->command->warn("Skip: Unit {$namaUnitBaru} atau Jabatan {$namaJabatanLegacy} tidak ditemukan.");
            }
        }
    }
}
