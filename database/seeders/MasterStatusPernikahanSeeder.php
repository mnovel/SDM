<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusPernikahanSeeder extends Seeder
{
    public function run(): void
    {
        $statusPernikahan = [
            ['nama' => 'Belum Menikah'],
            ['nama' => 'Menikah'],
            ['nama' => 'Cerai Hidup'],
            ['nama' => 'Cerai Mati'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::table('master_status_pernikahan')->truncate();

            $now = now();
            $data = array_map(fn($item) => array_merge($item, [
                'status'     => 'Aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ]), $statusPernikahan);

            DB::table('master_status_pernikahan')->insert($data);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('✅ MasterStatusPernikahanSeeder: ' . count($statusPernikahan) . ' status di-seed.');
    }
}
