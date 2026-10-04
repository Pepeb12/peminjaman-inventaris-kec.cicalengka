<?php

namespace App\Http\Controllers\Umpeg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Peminjam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PesanPeminjamMail;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        $query = Peminjaman::with(['peminjam.user', 'detailPeminjaman.barang']);

        if ($search) {
            $query->whereHas('peminjam', function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', '%' . $search . '%');
                })->orWhere('nama_instansi', 'like', '%' . $search . '%');
            });
        }

        if ($kategori) {
            $query->whereHas('peminjam', function($q) use ($kategori) {
                $q->where('jenis_peminjam', $kategori);
            });
        }

        $peminjamans = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());
        
        $semuaPeminjam = Peminjam::with('user')->get();
                                 
        return view('umpeg.peminjaman.index', compact('peminjamans', 'semuaPeminjam', 'search', 'kategori'));
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
            return back()->with('success', 'peminjaman telah disetujui menunggu cetak bukti');
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
            return back()->with('success', 'barang telah diserahkan');
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
            return back()->with('success', 'barang telah dikembalikan');
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

    public function sendEmailPeminjam(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        try {
            Mail::to($request->email)
                ->send(new PesanPeminjamMail($request->pesan));
            return response()->json(['success' => true, 'message' => 'Email berhasil dikirim!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal mengirim email: ' . $e->getMessage()], 500);
        }
    }
}