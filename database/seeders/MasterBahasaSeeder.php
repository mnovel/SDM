<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterBahasaSeeder extends Seeder
{
    public function run(): void
    {
        $bahasa = [
            ['nama' => 'Indonesia'],
            ['nama' => 'Inggris'],
            ['nama' => 'Jepang'],
            ['nama' => 'Mandarin'],
            ['nama' => 'Jerman'],
            ['nama' => 'Arab'],
            ['nama' => 'Korea'],
            ['nama' => 'Spanyol'],
            ['nama' => 'Prancis'],
            ['nama' => 'Italia'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::table('master_bahasa')->truncate();

            $now = now();
            $data = array_map(fn($item) => array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]), $bahasa);

            DB::table('master_bahasa')->insert($data);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('✅ MasterBahasaSeeder: ' . count($bahasa) . ' bahasa di-seed.');
    }
}
