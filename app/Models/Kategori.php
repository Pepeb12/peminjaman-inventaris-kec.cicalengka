<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];
    protected $primaryKey = 'id_kategori';

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id', 'id_kategori');
    }
}