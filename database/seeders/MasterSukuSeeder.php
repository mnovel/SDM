<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSukuSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/master_suku.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("❌ File CSV tidak ditemukan di: {$csvFile}");
            return;
        }

        $dataToInsert = [];
        $now = now();

        if (($handle = fopen($csvFile, 'r')) !== false) {
            fgetcsv($handle); // skip header

            while (($data = fgetcsv($handle)) !== false) {
                $namaSuku = trim($data[0] ?? '');

                if (!empty($namaSuku)) {
                    $dataToInsert[] = [
                        'nama'       => $namaSuku,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            fclose($handle);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            DB::table('master_suku')->truncate();

            foreach (array_chunk($dataToInsert, 500) as $chunk) {
                DB::table('master_suku')->insert($chunk);
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('✅ MasterSukuSeeder: ' . count($dataToInsert) . ' suku di-seed dari CSV.');
    }
}
