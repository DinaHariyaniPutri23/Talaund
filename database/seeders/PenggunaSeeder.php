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
        Pengguna::create([
            'nama' => 'Super Admin',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('password'),
            'peran' => 'super_admin',
        ]);

        Pengguna::create([
            'nama' => 'Kasir Utama',
            'email' => 'kasir@laundry.com',
            'password' => Hash::make('password'),
            'peran' => 'kasir',
        ]);

        Pengguna::create([
            'nama' => 'Pemilik Laundry',
            'email' => 'pemilik@laundry.com',
            'password' => Hash::make('password'),
            'peran' => 'pemilik',
        ]);
    }
}
