<?php

namespace Database\Seeders;

use App\Models\MasterPendidikan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendidikan = [
            ['nama' => 'SD'],
            ['nama' => 'SLTP'],
            ['nama' => 'SLTA'],
            ['nama' => 'D1'],
            ['nama' => 'D2'],
            ['nama' => 'D3'],
            ['nama' => 'D4'],
            ['nama' => 'S1'],
            ['nama' => 'S2'],
            ['nama' => 'S3'],
            ['nama' => 'Pendidikan Profesi '],
        ];

        // Kosongkan tabel sebelum memasukkan data baru
        MasterPendidikan::query()->delete();

        foreach ($pendidikan as $item) {
            MasterPendidikan::create($item);
        }
    }
}
