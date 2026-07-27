<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Peminjam;
use Illuminate\Support\Facades\Hash;

class PeminjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'peminjam@gmail.com'],
            [
                'name' => 'Akun Peminjam',
                'password' => Hash::make('Password123'),
                'role' => 'peminjam',
                'alamat' => 'Cicalengka',
            ]
        );

        Peminjam::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nik' => '3204111122223333',
                'jenis_peminjam' => 'Organisasi',
                'nama_instansi' => 'Organisasi Peminjam Uji Coba',
                'kontak_penanggung_jawab' => '081234567890',
                'is_verified' => true,
                'status_akun' => 'Disetujui',
            ]
        );
    }
}
