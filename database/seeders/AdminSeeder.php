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
        // Membuat akun khusus untuk Umpeg (Admin)
        User::create([
            'name' => 'Admin Umpeg Cicalengka',
            'email' => 'admin.cicalengka@gmail.com', // Ganti dengan Gmail khusus Anda
            'password' => Hash::make('password123'), // Ganti dengan password yang diinginkan
            'role' => 'umpeg',
        ]);
    }
}