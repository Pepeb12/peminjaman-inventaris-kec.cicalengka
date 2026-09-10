<?php

namespace App\Http\Controllers\Umpeg;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori_id = $request->input('kategori');
        $query = Barang::with('kategori');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        }

        $barangs = $query->paginate(10)->appends($request->all());
        $kategoris = Kategori::all();
        
        return view('umpeg.barang.index', compact('barangs', 'search', 'kategoris', 'kategori_id'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        // Pastikan Anda sudah punya minimal 1 data kategori di database untuk uji coba
        return view('umpeg.barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'stok_total' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        // 1. Logika Auto-Generate Kode Barang (Contoh: INV-ELK-26-001)
        $kategori = Kategori::findOrFail($request->kategori_id);

        // Ambil singkatan berdasarkan ketentuan
        $namaKategoriLower = strtolower(trim($kategori->nama_kategori));
        if ($namaKategoriLower === 'peralatan elektronik') {
            $singkatan = 'ELK';
        } elseif ($namaKategoriLower === 'peralatan kesehatan') {
            $singkatan = 'KES';
        } elseif ($namaKategoriLower === 'peralatan kebersihan') {
            $singkatan = 'KBR';
        } elseif ($namaKategoriLower === 'peralatan darurat') {
            $singkatan = 'DRT';
        } else {
            $singkatan = strtoupper(substr($kategori->nama_kategori, 0, 3));
            $singkatan = str_pad($singkatan, 3, 'X');
        }

        $tahun = date('y'); // Format 2 digit tahun (26)
        $prefix = "INV-{$singkatan}-{$tahun}-";

        // Cari nomor urut terakhir berdasarkan prefix yang sama
        $lastBarang = Barang::where('kode_barang', 'LIKE', "{$prefix}%")
            ->orderBy('kode_barang', 'desc')
            ->first();

        if ($lastBarang) {
            // Ambil 3 digit terakhir, ubah ke integer, lalu tambah 1
            $lastUrutan = (int) substr($lastBarang->kode_barang, -3);
            $newUrutan = str_pad($lastUrutan + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newUrutan = '001';
        }

        $kodeBarang = $prefix . $newUrutan;

        // 2. Logika Upload Foto
        $fotoPath = null;
        if ($request->hasFile('foto_barang')) {
            $fotoPath = $request->file('foto_barang')->store('barang', 'public');
        }

        // 3. Simpan ke Database
        Barang::create([
            'kode_barang' => $kodeBarang,
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'stok_total' => $request->stok_total,
            'stok_tersedia' => $request->stok_total, // Awalnya stok tersedia = stok total
            'kondisi' => $request->kondisi,
            'foto_barang' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('umpeg.barang.index')->with('success', 'Barang berhasil ditambahkan dengan kode: ' . $kodeBarang);
    }

    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();
        return view('umpeg.barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'stok_total' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'foto_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string'
        ]);

        $barang = Barang::findOrFail($id);

        // Menghitung selisih stok jika ada perubahan
        $selisihStok = $request->stok_total - $barang->stok_total;
        $stokTersediaBaru = $barang->stok_tersedia + $selisihStok;

        if ($stokTersediaBaru < 0) {
            return back()->with('error', 'Stok total tidak bisa kurang dari jumlah stok yang sedang dipinjam.');
        }

        $fotoPath = $barang->foto_barang;
        if ($request->hasFile('foto_barang')) {
            // Hapus foto lama jika ada
            if ($barang->foto_barang && Storage::disk('public')->exists($barang->foto_barang)) {
                Storage::disk('public')->delete($barang->foto_barang);
            }
            $fotoPath = $request->file('foto_barang')->store('barang', 'public');
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'kategori_id' => $request->kategori_id,
            'stok_total' => $request->stok_total,
            'stok_tersedia' => $stokTersediaBaru,
            'kondisi' => $request->kondisi,
            'foto_barang' => $fotoPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('umpeg.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus file fisik gambar jika ada
        if ($barang->foto_barang && Storage::disk('public')->exists($barang->foto_barang)) {
            Storage::disk('public')->delete($barang->foto_barang);
        }

        $barang->delete();

        return redirect()->route('umpeg.barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}