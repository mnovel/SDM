<?php

namespace Database\Seeders;

use App\Models\MasterAgama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterAgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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

        // Kosongkan tabel sebelum memasukkan data baru
        MasterAgama::truncate();

        foreach ($agama as $item) {
            MasterAgama::create($item);
        }
    }
}
