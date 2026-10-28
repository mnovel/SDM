<?php

namespace Database\Seeders;

use App\Models\MasterPendidikan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterPangkatSeeder extends Seeder
{
    public function run(): void
    {
        // Lookup: nama pendidikan → id
        $pendidikanIds = MasterPendidikan::pluck('id', 'nama')->toArray();

        // Validasi dependency
        if (empty($pendidikanIds)) {
            $this->command->error('❌ MasterPendidikan kosong. Jalankan MasterPendidikanSeeder dulu.');
            return;
        }

        // Format: [golongan, pangkat, nama_pendidikan (bukan id)]
        $data = [
            // GOLONGAN I
            ['golongan' => 'I/A',  'pangkat' => 'Juru Muda',               'pendidikan' => 'SD'],
            ['golongan' => 'I/B',  'pangkat' => 'Juru Muda Tingkat I',     'pendidikan' => 'SD'],
            ['golongan' => 'I/C',  'pangkat' => 'Juru',                    'pendidikan' => 'SD'],
            ['golongan' => 'I/D',  'pangkat' => 'Juru Tingkat 1',          'pendidikan' => 'SLTP'],

            // GOLONGAN II
            ['golongan' => 'II/A', 'pangkat' => 'Pengatur Muda',           'pendidikan' => 'SLTP'],
            ['golongan' => 'II/B', 'pangkat' => 'Pengatur Muda Tingkat 1', 'pendidikan' => 'D1'],
            ['golongan' => 'II/C', 'pangkat' => 'Pengatur',                'pendidikan' => 'SLTA'],
            ['golongan' => 'II/D', 'pangkat' => 'Pengatur Tingkat 1',      'pendidikan' => 'SLTA'],

            // GOLONGAN III
            ['golongan' => 'III/A', 'pangkat' => 'Penata Muda',            'pendidikan' => 'S1'],
            ['golongan' => 'III/B', 'pangkat' => 'Penata Muda Tingkat 1',  'pendidikan' => 'S2'],
            ['golongan' => 'III/C', 'pangkat' => 'Penata',                 'pendidikan' => 'S3'],
            ['golongan' => 'III/D', 'pangkat' => 'Penata Tingkat 1',       'pendidikan' => 'SLTA'],

            // GOLONGAN IV
            ['golongan' => 'IV/A', 'pangkat' => 'Pembina',                 'pendidikan' => 'S1'],
            ['golongan' => 'IV/B', 'pangkat' => 'Pembina Tingkat I',       'pendidikan' => 'S1'],
            ['golongan' => 'IV/C', 'pangkat' => 'Pembina Utama Muda',      'pendidikan' => 'S2'],
            ['golongan' => 'IV/D', 'pangkat' => 'Pembina Utama Madya',     'pendidikan' => 'S2'],
            ['golongan' => 'IV/E', 'pangkat' => 'Pembina Utama',           'pendidikan' => 'S2'],

            // GOLONGAN BLUD
            ['golongan' => 'I (BLUD)',    'pangkat' => 'Pratama I (BLUD)',    'pendidikan' => 'SLTA'],
            ['golongan' => 'II (BLUD)',   'pangkat' => 'Pratama II (BLUD)',   'pendidikan' => 'SLTA'],
            ['golongan' => 'III (BLUD)',  'pangkat' => 'Pratama III (BLUD)',  'pendidikan' => 'SLTA'],
            ['golongan' => 'IV',          'pangkat' => 'Pratama IV (BLUD)',   'pendidikan' => 'SLTA'],
            ['golongan' => 'V (BLUD)',    'pangkat' => 'Madya I (BLUD)',      'pendidikan' => 'SLTA'],
            ['golongan' => 'VI (BLUD)',   'pangkat' => 'Madya II (BLUD)',     'pendidikan' => 'SLTA'],
            ['golongan' => 'VII (BLUD)',  'pangkat' => 'Madya III (BLUD)',    'pendidikan' => 'D3'],
            ['golongan' => 'VIII (BLUD)', 'pangkat' => 'Madya IV (BLUD)',     'pendidikan' => 'D3'],
            ['golongan' => 'IX (BLUD)',   'pangkat' => 'Ahli I (BLUD)',       'pendidikan' => 'S1'],
            ['golongan' => 'X (BLUD)',    'pangkat' => 'Ahli II (BLUD)',      'pendidikan' => 'S1'],
            ['golongan' => 'XI (BLUD)',   'pangkat' => 'Ahli III (BLUD)',     'pendidikan' => 'Pendidikan Profesi'],
            ['golongan' => 'XII (BLUD)',  'pangkat' => 'Ahli IV (BLUD)',      'pendidikan' => 'Pendidikan Profesi'],
            ['golongan' => 'XIII',        'pangkat' => 'Utama (BLUD)',        'pendidikan' => 'S2'],
        ];

        $now = now();
        $insertData = [];

        foreach ($data as $item) {
            $namaPendidikan = $item['pendidikan'];

            if (!isset($pendidikanIds[$namaPendidikan])) {
                $this->command->warn("⚠️  Pendidikan '{$namaPendidikan}' tidak ditemukan, skip: {$item['pangkat']}");
                continue;
            }

            $insertData[] = [
                'golongan'      => $item['golongan'],
                'pangkat'       => $item['pangkat'],
                'pendidikan_id' => $pendidikanIds[$namaPendidikan],
                'status'        => 'Aktif',
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::table('master_pangkat')->truncate();
            DB::table('master_pangkat')->insert($insertData);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('✅ MasterPangkatSeeder: ' . count($insertData) . ' pangkat di-seed.');
    }
}
