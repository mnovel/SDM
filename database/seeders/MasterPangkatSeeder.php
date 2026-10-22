<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterPangkatSeeder extends Seeder
{
    public function run(): void
    {
        // Data diurutkan dari Golongan Terendah (I/A) hingga Tertinggi (XIII BLUD)
        // Format: [golongan, pangkat, pendidikan_id]
        $data = [
            // ================= GOLONGAN I (PNS) =================
            ['golongan' => 'I/A',        'pangkat' => 'Juru Muda',               'pendidikan_id' => 1],  // SD
            ['golongan' => 'I/B',        'pangkat' => 'Juru Muda Tingkat I',     'pendidikan_id' => 1],  // SD
            ['golongan' => 'I/C',        'pangkat' => 'Juru',                    'pendidikan_id' => 1],  // SD
            ['golongan' => 'I/D',        'pangkat' => 'Juru Tingkat 1',          'pendidikan_id' => 2],  // SLTP

            // ================= GOLONGAN II (PNS) =================
            ['golongan' => 'II/A',       'pangkat' => 'Pengatur Muda',           'pendidikan_id' => 2],  // SLTP
            ['golongan' => 'II/B',       'pangkat' => 'Pengatur Muda Tingkat 1', 'pendidikan_id' => 4],  // D1
            ['golongan' => 'II/C',       'pangkat' => 'Pengatur',                'pendidikan_id' => 3],  // SLTA
            ['golongan' => 'II/D',       'pangkat' => 'Pengatur Tingkat 1',      'pendidikan_id' => 3],  // SLTA

            // ================= GOLONGAN III (PNS) =================
            ['golongan' => 'III/A',      'pangkat' => 'Penata Muda',             'pendidikan_id' => 8],  // S1
            ['golongan' => 'III/B',      'pangkat' => 'Penata Muda Tingkat 1',   'pendidikan_id' => 9],  // S2
            ['golongan' => 'III/C',      'pangkat' => 'Penata',                  'pendidikan_id' => 10], // S3
            ['golongan' => 'III/D',      'pangkat' => 'Penata Tingkat 1',        'pendidikan_id' => 3],  // SLTA

            // ================= GOLONGAN IV (PNS) =================
            ['golongan' => 'IV/A',       'pangkat' => 'Pembina',                 'pendidikan_id' => 8],  // S1
            ['golongan' => 'IV/B',       'pangkat' => 'Pembina Tingkat I',       'pendidikan_id' => 8],  // S1
            ['golongan' => 'IV/C',       'pangkat' => 'Pembina Utama Muda',      'pendidikan_id' => 9],  // S2
            ['golongan' => 'IV/D',       'pangkat' => 'Pembina Utama Madya',     'pendidikan_id' => 9],  // S2
            ['golongan' => 'IV/E',       'pangkat' => 'Pembina Utama',           'pendidikan_id' => 9],  // S2

            // ================= GOLONGAN BLUD =================
            ['golongan' => 'I (BLUD)',   'pangkat' => 'Pratama I (BLUD)',        'pendidikan_id' => 3],  // SLTA
            ['golongan' => 'II (BLUD)',  'pangkat' => 'Pratama II (BLUD)',       'pendidikan_id' => 3],  // SLTA
            ['golongan' => 'III (BLUD)', 'pangkat' => 'Pratama III (BLUD)',      'pendidikan_id' => 3],  // SLTA
            ['golongan' => 'IV',         'pangkat' => 'Pratama IV (BLUD)',       'pendidikan_id' => 3],  // SLTA
            ['golongan' => 'V (BLUD)',   'pangkat' => 'Madya I (BLUD)',          'pendidikan_id' => 3],  // SLTA
            ['golongan' => 'VI (BLUD)',  'pangkat' => 'Madya II (BLUD)',         'pendidikan_id' => 3],  // SLTA
            ['golongan' => 'VII (BLUD)', 'pangkat' => 'Madya III (BLUD)',        'pendidikan_id' => 6],  // D3
            ['golongan' => 'VIII (BLUD)', 'pangkat' => 'Madya IV (BLUD)',         'pendidikan_id' => 6],  // D3
            ['golongan' => 'IX (BLUD)',  'pangkat' => 'Ahli I (BLUD)',           'pendidikan_id' => 8],  // S1
            ['golongan' => 'X (BLUD)',   'pangkat' => 'Ahli II (BLUD)',          'pendidikan_id' => 8],  // S1
            ['golongan' => 'XI (BLUD)',  'pangkat' => 'Ahli III (BLUD)',         'pendidikan_id' => 11], // Profesi
            ['golongan' => 'XII (BLUD)', 'pangkat' => 'Ahli IV (BLUD)',          'pendidikan_id' => 11], // Profesi
            ['golongan' => 'XIII',       'pangkat' => 'Utama (BLUD)',            'pendidikan_id' => 9],  // S2
        ];

        // Tambahkan timestamp dan status ke setiap baris data
        $insertData = array_map(function ($item) {
            return array_merge($item, [
                'status'     => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);

        // Kosongkan tabel sebelum memasukkan data baru
        DB::table('master_pangkat')->truncate();

        // Insert semua data sekaligus
        DB::table('master_pangkat')->insert($insertData);
    }
}
