<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterPendidikanSeeder extends Seeder
{
    public function run(): void
    {
        $pendidikan = [
            ['nama' => 'SD'],
            ['nama' => 'SLTP'],
            ['nama' => 'SLTA'],
            ['nama' => 'D1'],
            ['nama' => 'D2'],
            ['nama' => 'D3'],
            ['nama' => 'D4'],
            ['nama' => 'S1'],
            ['nama' => 'S2'],
            ['nama' => 'S3'],
            ['nama' => 'Pendidikan Profesi'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::table('master_pendidikan')->truncate();

            $now = now();
            $data = array_map(fn($item) => array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]), $pendidikan);

            DB::table('master_pendidikan')->insert($data);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('✅ MasterPendidikanSeeder: ' . count($pendidikan) . ' pendidikan di-seed.');
    }
}
