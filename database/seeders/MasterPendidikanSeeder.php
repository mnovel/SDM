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
            ['pendidikan' => 'SD'],
            ['pendidikan' => 'SLTP'],
            ['pendidikan' => 'SLTA'],
            ['pendidikan' => 'D1'],
            ['pendidikan' => 'D2'],
            ['pendidikan' => 'D3'],
            ['pendidikan' => 'D4'],
            ['pendidikan' => 'S1'],
            ['pendidikan' => 'S2'],
            ['pendidikan' => 'S3'],
            ['pendidikan' => 'Pendidikan Profesi '],
        ];

        foreach ($pendidikan as $item) {
            MasterPendidikan::create($item);
        }
    }
}
