<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterJabatan;
use Illuminate\Support\Str;

class MasterJabatanSeeder extends Seeder
{
    public function run(): void
    {
        // Gabungan data dari ms_jabatan_pegawai.csv dan ms_jabatan.csv
        $rawData = [
            // --- DARI MS_JABATAN_PEGAWAI (Fungsional/Umum) ---
            "DIREKTUR",
            "KEPALA BAGIAN",
            "KEPALA BIDANG",
            "KEPALA SUB BAGIAN",
            "KEPALA SEKSI",
            "MEDIS SPESIALIS",
            "MEDIS",
            "KEPALA INSTALASI",
            "KEPALA RUANGAN",
            "KOORDINATOR",
            "KEPALA TIM",
            "KEPALA POLI KLINIK",
            "KOORDINATOR KLINIK",
            "CASE MANAGER",
            "KOORDINATOR PETUGAS KEAMAAN",
            "APOTEKER",
            "ASISTEN APOTEKER",
            "ANALIS KESEHATAN",
            "KEPALA SHIFT",
            "BIDAN",
            "PERAWAT",
            "SANITARIAN",
            "PERAWAT GIGI",
            "AHLI MADYA GIGI",
            "ADMINISTRASI KLINIK",
            "NUTRISIONIST",
            "ADMINISTRASI RANAP",
            "ADMINISTRASI RUANGAN",
            "ADMINISTRASI UMUM",
            "ANALIS AKUNTABILITAS APARATUR",
            "BENDAHARA PENERIMAAN",
            "BENDAHARA PENGELUARAN",
            "CSSD",
            "ENTRYER",
            "FUNGSONAL UMUM",
            "IPCN PURNA",
            "JAMINAN",
            "JURU CUCI",
            "JURU MASAK",
            "JURU RESEP",
            "LAUNDRY",
            "MEKANIK UMUM",
            "PELAKSANA FISIO TERAPI",
            "PELAKSANA LAB",
            "PELAKSANA RADIOGRAFER",
            "PELAKSANA RADIOLOGI",
            "PEMBANTU JURU MASAK",
            "PEMULASARA JENAZAH",
            "PENATA ANASTESI",
            "PENATA BOGA",
            "PETUGAS ADMINISTRASI UMUM",
            "PETUGAS KAMAR GELAP",
            "PETUGAS KEAMANAN",
            "PETUGAS KEBERSIHAN",
            "PETUGAS KESEHATAN MASYARAKAT",
            "PETUGAS TEKNIK INFORMASI",
            "RADIOGRAFER",
            "REFRAKSIONIS",
            "STAF",
            "TEKNISI LISTRIK",
            "TEHNIK UMUM",
            "TEKNIKER GIGI",
            "TEKNISI BANGUNAN",
            "TEKNISI ELEKTROMEDIK",
            "TEKNISI ELEKTRONIK",
            "PENGEMUDI AMBULANCE",
            "PENGOLAH DATA",
            "PENYIMPAN BARANG",
            "PETUGAS ARSIP MEDICAL RECORD",
            "PETUGAS DATA REKAM MEDIK",
            "PEREKAM MEDIS PELAKSANA",
            "PEREKAM MEDIK",
            "ANTRIAN",
            "ADMINISTRASI",
            "ANALIS",
            "PARKIR",
            "AKUNTANSI",
            "KASIR",
            "PEMBANTU BENDAHARA",
            "PSIKOLOGI KLINIS",

            // --- DARI MS_JABATAN (Struktural Spesifik) ---
            "Wadir Umum dan Keuangan",
            "Wadir Pelayanan",
            "Kabag Yanmed dan RM",
            "Kabid Penunjang Medis dan Non Medis",
            "Kabid Keperawatan",
            "Kabag Perencanaan",
            "Kabag Umum",
            "Kabag Keuangan",
            "Ketua Komite Farmasi dan Terapi",
            "Ketua Komite Medik",
            "Kasubbag Perencanaan",
            "Kasubbag Hukum dan Humas",
            "Kasubbag Pengembangan SDM",
            "Kasubbag Tata Usaha",
            "Kasubbag Administrasi SDM",
            "Kasubbag RTP",
            "Kasubbag Pendapatan",
            "Kasubbag Belanja",
            "Kasubbag Akuntansi",
            "Kasi Pelayanan Medis",
            "Kasubbag Rekam Medis",
            "Kasi Penunjang Medis",
            "Kasi Penunjang Non Medis",
            "Kasi Asuhan Keperawatan",
            "Kasi Pengembangan Paramedis",
            "Apoteker Muda",
            "Staf Penunjang Medis",
            "Pembantu Umum",
            "Wadir Pendidikan dan Perencanaan",
            "Kabag SDM & Diklit",
            "Kasubbag Diklit",
            "Kasubbag Evaluasi dan Pelaporan",
            "Kasubbag Pemasaran",
            "Front Office IGD",
            "Duty Manager"
        ];

        // 1. Bersihkan duplikat dan spasi berlebih
        $cleanData = collect($rawData)->map(function ($nama) {
            return trim(preg_replace('/\s+/', ' ', $nama));
        })->unique()->filter()->values();

        foreach ($cleanData as $index => $namaJabatan) {
            // 2. Format Title Case & Perbaiki Singkatan
            $formattedNama = Str::title(strtolower($namaJabatan));
            $formattedNama = str_replace(
                ['Sdm', 'Igd', 'Cssd', 'RtP', 'Ipcn', 'Yanmed', 'Diklit'],
                ['SDM', 'IGD', 'CSSD', 'RTP', 'IPCN', 'Yanmed', 'Diklit'],
                $formattedNama
            );

            // 3. Generate nama_singkat unik (max 30 karakter)
            $words = explode(' ', $formattedNama);
            $acronym = '';
            foreach ($words as $word) {
                if (!empty($word)) $acronym .= strtoupper(substr($word, 0, 1));
            }
            if (strlen($acronym) < 3) {
                $acronym = strtoupper(substr($formattedNama, 0, 4));
            }

            $namaSingkat = substr($acronym, 0, 15) . '-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);

            // 4. Simpan
            MasterJabatan::updateOrCreate(
                ['nama' => $formattedNama],
                [
                    'nama_singkat' => $namaSingkat,
                    'status' => 'Aktif'
                ]
            );
        }
    }
}
