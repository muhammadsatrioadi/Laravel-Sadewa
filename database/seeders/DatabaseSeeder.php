<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Merk;
use App\Models\Lokasi;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SEED ROLES (HARUS DULU)
        Role::create(['id' => 1, 'role' => 'admin']);
        Role::create(['id' => 2, 'role' => 'user']);

        // 2. SEED USERS
        User::create([
            'name'      => 'admin',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('1234'),
            'role_id'   => 1
        ]);

        User::create([
            'name'      => 'user',
            'email'     => 'user@gmail.com',
            'password'  => bcrypt('1234'),
            'role_id'   => 2
        ]);

        // 3. SEED KATEGORI
        Kategori::create([
            'kategori'  => 'Elektronik'
        ]);

        // 4. SEED MERK
        Merk::create([
            'merk'  => 'Lenovo'
        ]);

        // 5. SEED LOKASI
        Lokasi::create(['lokasi' => 'Gedung Utama']);
        Lokasi::create(['lokasi' => 'Kantor Satpam']);
    }
}
