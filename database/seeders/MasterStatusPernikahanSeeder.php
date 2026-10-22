<?php

namespace Database\Seeders;

use App\Models\MasterStatusPernikahan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterStatusPernikahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusPernikahan = [
            ['nama' => 'Belum Menikah'],
            ['nama' => 'Menikah'],
            ['nama' => 'Cerai Hidup'],
            ['nama' => 'Cerai Mati'],
        ];

        // Kosongkan tabel sebelum memasukkan data baru


        foreach ($statusPernikahan as $status) {
            MasterStatusPernikahan::create($status);
        }
    }
}
