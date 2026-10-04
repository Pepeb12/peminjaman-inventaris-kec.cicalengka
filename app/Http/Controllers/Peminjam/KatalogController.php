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
        $kategori_id = $request->input('kategori');
        $query = Barang::with('kategori');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        }

        // Hanya tampilkan barang yang kondisi tidak Rusak
        $query->where('kondisi', '!=', 'Rusak');

        $barangs = $query->paginate(12)->appends($request->all());
        $kategoris = \App\Models\Kategori::all();

        return view('peminjam.katalog.index', compact('barangs', 'search', 'kategoris', 'kategori_id'));
    }
}
