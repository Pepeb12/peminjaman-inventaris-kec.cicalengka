<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // --- BARIS INI YANG MENYELESAIKAN ERROR ---
    protected $table = 'peminjamans';
    // ------------------------------------------

    // Set Primary Key karena menggunakan string (Format TRX)
    protected $primaryKey = 'id_peminjaman';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_peminjaman', 'peminjam_id', 'tgl_pinjam', 'tgl_kembali', 'status', 'surat_resmi', 'pesan_tolak', 'catatan_kembali'
    ];

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'peminjam_id', 'id_peminjam');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id', 'id_peminjaman');
    }
}