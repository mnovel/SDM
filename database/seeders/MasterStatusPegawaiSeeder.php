<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterStatusPegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $status = [
            ['nama' => 'CPNS'],
            ['nama' => 'PNS'],
            ['nama' => 'NON PNS TETAP'],
            ['nama' => 'NON PNS TIDAK TETAP'],
            ['nama' => 'PPPK'],
            ['nama' => 'HONORER / KONTRAK'],
            ['nama' => 'BLUD'],
            ['nama' => 'CPNS & PNS'],
            ['nama' => 'MOU'],
            ['nama' => 'Magang'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::table('master_status_pegawai')->truncate();

            $now = now();
            $data = array_map(fn($item) => array_merge($item, [
                'status'     => 'Aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ]), $status);

            DB::table('master_status_pegawai')->insert($data);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('✅ MasterStatusPegawaiSeeder: ' . count($status) . ' status pegawai di-seed.');
    }
}
