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
            ['nama_agama' => 'Islam'],
            ['nama_agama' => 'Kristen'],
            ['nama_agama' => 'Katolik'],
            ['nama_agama' => 'Hindu'],
            ['nama_agama' => 'Buddha'],
            ['nama_agama' => 'Konghucu'],
            ['nama_agama' => 'Lainnya'],
        ];

        foreach ($agama as $item) {
            MasterAgama::create($item);
        }
    }
}
