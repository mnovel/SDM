<?php

namespace Database\Seeders;

use App\Models\MasterSuku; // Panggil Model
use Illuminate\Database\Seeder;

class MasterSukuSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/master_suku.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("File CSV tidak ditemukan di: {$csvFile}");
            return;
        }

        $dataToInsert = [];
        $now = now();

        if (($handle = fopen($csvFile, 'r')) !== false) {
            fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== false) {
                $namaSuku = trim($data[0]);

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

        // Menggunakan Model, bukan DB::table
        MasterSuku::truncate();

        // Masukkan per 100 baris menggunakan Model::insert()
        foreach (array_chunk($dataToInsert, 100) as $chunk) {
            MasterSuku::insert($chunk);
        }

        $this->command->info('✅ Berhasil memasukkan ' . count($dataToInsert) . ' data Suku via Model!');
    }
}
