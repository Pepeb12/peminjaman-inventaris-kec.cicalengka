<?php

namespace App\Http\Controllers\Umpeg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Load data peminjaman beserta relasi user dan detail barang
        $peminjamans = Peminjaman::with(['peminjam.user', 'detailPeminjaman.barang'])
                                 ->orderBy('created_at', 'desc')
                                 ->get();
                                 
        return view('umpeg.peminjaman.index', compact('peminjamans'));
    }

    // Penambahan tipe data 'string' pada parameter $id
    public function accPeminjaman(string $id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.barang')->findOrFail($id);
        
        if ($peminjaman->status !== 'Menunggu Proses') {
            return back()->with('error', 'Status tidak valid untuk di-ACC.');
        }

        DB::beginTransaction();
        try {
            $peminjaman->update(['status' => 'Menunggu Cetak Bukti']);

            // Stok sudah dikurangi saat pengajuan, jadi tidak perlu kurangi lagi di sini.

            DB::commit();
            return back()->with('success', "Peminjaman {$id} disetujui. Status berubah menjadi Menunggu Cetak Bukti.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function serahkanBarang(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status !== 'Menunggu Cetak Bukti') {
            return back()->with('error', 'Status tidak valid untuk penyerahan barang.');
        }

        DB::beginTransaction();
        try {
            $peminjaman->update(['status' => 'Dipinjam']);
            DB::commit();
            return back()->with('success', "Barang untuk peminjaman {$id} telah diserahkan. Status berubah menjadi Dipinjam.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function terimaBarang(Request $request, string $id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.barang')->findOrFail($id);
        
        if ($peminjaman->status !== 'Dipinjam') {
            return back()->with('error', 'Barang belum berstatus dipinjam.');
        }

        DB::beginTransaction();
        try {
            $peminjaman->update([
                'status' => 'Selesai',
                'catatan_kembali' => $request->input('catatan_kembali')
            ]);

            // Mutasi: Tambah kembali stok_tersedia
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->barang) {
                    $detail->barang->increment('stok_tersedia', $detail->jumlah);
                }
            }

            DB::commit();
            return back()->with('success', "Peminjaman {$id} selesai. Stok barang telah dikembalikan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengembalian barang.');
        }
    }
    
    public function tolakPeminjaman(Request $request, string $id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman.barang')->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $peminjaman->update([
                'status' => 'Ditolak',
                'pesan_tolak' => $request->input('pesan_tolak')
            ]);
            
            // Kembalikan stok karena pengajuan ditolak
            foreach ($peminjaman->detailPeminjaman as $detail) {
                if ($detail->barang) {
                    $detail->barang->increment('stok_tersedia', $detail->jumlah);
                }
            }
            
            DB::commit();
            return back()->with('success', "Peminjaman {$id} telah ditolak dan stok dikembalikan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses penolakan: ' . $e->getMessage());
        }
    }
}