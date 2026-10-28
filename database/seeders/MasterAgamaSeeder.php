<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterAgamaSeeder extends Seeder
{
    public function run(): void
    {
        $agama = [
            ['nama' => 'Islam'],
            ['nama' => 'Kristen'],
            ['nama' => 'Katolik'],
            ['nama' => 'Hindu'],
            ['nama' => 'Buddha'],
            ['nama' => 'Konghucu'],
            ['nama' => 'Lainnya'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::table('master_agama')->truncate();

            $now = now();
            $data = array_map(fn($item) => array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]), $agama);

            DB::table('master_agama')->insert($data);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('✅ MasterAgamaSeeder: ' . count($agama) . ' agama di-seed.');
    }
}
