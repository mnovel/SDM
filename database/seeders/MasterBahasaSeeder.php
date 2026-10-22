<?php

namespace Database\Seeders;

use App\Models\MasterBahasa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterBahasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahasas = [
            ['bahasa' => 'Indonesia'],
            ['bahasa' => 'Inggris'],
            ['bahasa' => 'Jepang'],
            ['bahasa' => 'Mandarin'],
            ['bahasa' => 'Jerman'],
            ['bahasa' => 'Arab'],
            ['bahasa' => 'Korea'],
            ['bahasa' => 'Spanyol'],
            ['bahasa' => 'Prancis'],
            ['bahasa' => 'Italia'],
        ];

        foreach ($bahasas as $bahasa) {
            MasterBahasa::create($bahasa);
        }
    }
}
