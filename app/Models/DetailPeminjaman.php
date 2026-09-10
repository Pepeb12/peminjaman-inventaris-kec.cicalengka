<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    // MENYELESAIKAN ERROR: Mengunci nama tabel yang benar di database
    protected $table = 'detail_peminjamans';
    protected $primaryKey = 'id_detail_peminjaman';

    protected $fillable = [
        'peminjaman_id', 
        'kode_barang', 
        'jumlah'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'id_peminjaman');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang', 'kode_barang');
    }
}