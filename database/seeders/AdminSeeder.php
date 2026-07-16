<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun khusus untuk  (Admin)
        User::updateOrCreate(
            ['email' => 'admin.cicalengka@gmail.com'], // Kondisi pencarian
            [
                'name' => 'Admin Umpeg Cicalengka',
                'password' => Hash::make('password123'), // Ganti dengan password yang diinginkan
                'role' => 'umpeg',
            ]
        );
    }
}