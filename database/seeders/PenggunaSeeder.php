<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengguna::updateOrCreate(
            ['email' => 'admin@laundry.com'],
            [
                'nama' => 'Super Admin',
                'kata_sandi' => Hash::make('password'),
                'peran' => 'super_admin',
            ]
        );

        Pengguna::updateOrCreate(
            ['email' => 'kasir@laundry.com'],
            [
                'nama' => 'Kasir Utama',
                'kata_sandi' => Hash::make('password'),
                'peran' => 'kasir',
            ]
        );

        Pengguna::updateOrCreate(
            ['email' => 'pemilik@laundry.com'],
            [
                'nama' => 'Pemilik Laundry',
                'kata_sandi' => Hash::make('password'),
                'peran' => 'pemilik',
            ]
        );
    }
}
