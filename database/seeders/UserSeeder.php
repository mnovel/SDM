<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'admin',       'name' => 'Administrator',   'email' => 'admin@rsud.local',       'password' => 'Admin123!',    'is_active' => true],
            ['username' => 'hrd',         'name' => 'HRD Officer',     'email' => 'hrd@rsud.local',         'password' => 'Hrd123!',      'is_active' => true],
            ['username' => 'verifikator', 'name' => 'Verifikator Cuti','email' => 'verifikator@rsud.local', 'password' => 'Verif123!',    'is_active' => true],
            ['username' => 'pegawai',     'name' => 'Pegawai Contoh',  'email' => null,                     'password' => 'Pegawai123!',  'is_active' => true],
            ['username' => 'nonaktif',    'name' => 'User Nonaktif',   'email' => 'nonaktif@rsud.local',    'password' => 'Nonaktif123!', 'is_active' => false],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['username' => $data['username']],
                [
                    'name'      => $data['name'],
                    'email'     => $data['email'],
                    'password'  => Hash::make($data['password']),
                    'is_active' => $data['is_active'],
                ],
            );
        }

        $this->command->info('✅ UserSeeder: ' . count($users) . ' user dibuat/diperbarui.');
    }
}