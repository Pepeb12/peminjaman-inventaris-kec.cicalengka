<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Barang::with('kategori');
        
        if ($search) {
            $query->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }
        
        // Hanya tampilkan barang yang kondisi tidak Rusak
        $query->where('kondisi', '!=', 'Rusak');
        
        $barangs = $query->paginate(12);
        
        return view('peminjam.katalog.index', compact('barangs', 'search'));
    }
}
