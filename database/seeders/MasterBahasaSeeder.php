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

        // Kosongkan tabel sebelum memasukkan data baru
        MasterBahasa::truncate();

        foreach ($bahasa as $item) {
            MasterBahasa::create($item);
        }
    }
}
