<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndonesiaSeeder extends Seeder
{
    public function run(): void
    {
        // Path utama ke folder CSV package laravolt
        $basePath = base_path('vendor/laravolt/indonesia/resources/csv/');
        $now = now();

        $this->command->info('Mempersiapkan database...');
        // Matikan foreign key sementara agar bisa truncate berurutan
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('master_kelurahan')->truncate();
        DB::table('master_kecamatan')->truncate();
        DB::table('master_kota')->truncate();
        DB::table('master_provinsi')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ==========================================
        // 1. PROVINSI
        // ==========================================
        $this->command->info('Mengisi data Provinsi...');
        if (($handle = fopen($basePath . 'provinces.csv', 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                DB::table('master_provinsi')->insert([
                    'id'         => $data[0],
                    'code'       => $data[0],
                    'name'       => $data[1],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            fclose($handle);
        }

        // ==========================================
        // 2. KOTA / KABUPATEN
        // ==========================================
        $this->command->info('Mengisi data Kota/Kabupaten...');
        if (($handle = fopen($basePath . 'cities.csv', 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                DB::table('master_kota')->insert([
                    'id'            => $data[0],
                    'code'          => $data[0],
                    'province_code' => $data[1],
                    'name'          => $data[2],
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);
            }
            fclose($handle);
        }

        // ==========================================
        // 3. KECAMATAN
        // ==========================================
        $this->command->info('Mengisi data Kecamatan...');
        if (($handle = fopen($basePath . 'districts.csv', 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                DB::table('master_kecamatan')->insert([
                    'id'         => $data[0],
                    'code'       => $data[0],
                    'city_code'  => $data[1],
                    'name'       => $data[2],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            fclose($handle);
        }

        // ==========================================
        // 4. KELURAHAN / DESA (Dari dalam Folder)
        // ==========================================
        $this->command->info('Mengisi data Kelurahan/Desa (Mohon tunggu, ini memakan waktu)...');

        $villagesPath = $basePath . 'villages/';

        // Ambil semua file .csv di dalam folder villages
        $villageFiles = glob($villagesPath . '*.csv');

        foreach ($villageFiles as $file) {
            if (($handle = fopen($file, 'r')) !== false) {
                $chunk = [];
                while (($data = fgetcsv($handle)) !== false) {
                    $chunk[] = [
                        'id'            => $data[0],
                        'code'          => $data[0],
                        'district_code' => $data[1],
                        'name'          => $data[2],
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ];

                    // Insert per 1000 baris agar tidak kehabisan memori (Memory Limit)
                    if (count($chunk) == 1000) {
                        DB::table('master_kelurahan')->insert($chunk);
                        $chunk = [];
                    }
                }
                // Masukkan sisa data yang kurang dari 1000
                if (count($chunk) > 0) {
                    DB::table('master_kelurahan')->insert($chunk);
                }
                fclose($handle);
            }
        }

        $this->command->info('✅ Seluruh data wilayah Indonesia berhasil dimasukkan!');
    }
}
