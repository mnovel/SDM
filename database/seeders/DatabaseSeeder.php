<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MasterAgamaSeeder::class,
            MasterBahasaSeeder::class,
            MasterPendidikanSeeder::class,
            MasterPangkatSeeder::class,
            MasterStatusPernikahanSeeder::class,
            MasterSukuSeeder::class,
            MasterStatusPegawaiSeeder::class,
            MasterUnitSeeder::class,
            MasterJabatanSeeder::class,
            UnitJabatanSeeder::class,
            IndonesiaSeeder::class,
            PegawaiSeeder::class
        ]);
    }
}
