<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'kode_peminjam', 'nik', 'jenis_peminjam', 'nama_instansi', 'kontak_penanggung_jawab', 'is_verified', 'status_akun', 'foto_ktp'
    ];
    protected $primaryKey = 'id_peminjam';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'peminjam_id', 'id_peminjam');
    }
}