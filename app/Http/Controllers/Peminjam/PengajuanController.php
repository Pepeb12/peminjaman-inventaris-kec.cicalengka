<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function create()
    {
        $kategoris = \App\Models\Kategori::all();
        // HANYA me-load barang yang kondisi bukan Rusak
        $barangs = Barang::with('kategori')
                         ->where('kondisi', '!=', 'Rusak')
                         ->get();
        return view('peminjam.pengajuan.create', compact('barangs', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_pinjam' => 'required|date_format:d/m/Y H:i',
            'tgl_kembali' => 'required|date_format:d/m/Y H:i|after_or_equal:tgl_pinjam',
            'kode_barang' => 'required|array',
            'kode_barang.*' => 'required|exists:barangs,kode_barang',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'surat_resmi' => 'nullable|mimes:pdf|max:5120'
        ], [
            'required' => 'isi bagian ini',
            'tgl_kembali.after_or_equal' => 'tanggal kembali harus lebih dari tanggal pinjam',
            'surat_resmi.required' => 'isi bagian ini',
            'surat_resmi.mimes' => 'Format file surat resmi harus PDF.',
            'surat_resmi.max' => 'Ukuran file surat resmi maksimal 5MB.'
        ]);

        // Handle File Upload
        $suratPath = null;
        if ($request->hasFile('surat_resmi')) {
            $suratPath = $request->file('surat_resmi')->store('surat_resmi', 'public');
        }

        // Auto-generate ID (Format: TRX-YYYYMMDD-001)
        $tanggal = date('Ymd');
        $prefix = "TRX-{$tanggal}-";
        
        $lastPeminjaman = Peminjaman::where('id', 'LIKE', "{$prefix}%")
                                    ->orderBy('id', 'desc')
                                    ->first();

        if ($lastPeminjaman) {
            $lastUrutan = (int) substr($lastPeminjaman->id, -3);
            $newUrutan = str_pad($lastUrutan + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newUrutan = '001';
        }
        
        $trxId = $prefix . $newUrutan;

        // Ambil data profil peminjam dari user yang sedang login
        $peminjamId = Auth::user()->peminjam->id;

        DB::beginTransaction();
        try {
            // 1. Insert ke tabel peminjamans (Status Default: Menunggu Proses)
            Peminjaman::create([
                'id' => $trxId,
                'peminjam_id' => $peminjamId,
                'tgl_pinjam' => \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->tgl_pinjam)->format('Y-m-d H:i:s'),
                'tgl_kembali' => \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->tgl_kembali)->format('Y-m-d H:i:s'),
                'surat_resmi' => $suratPath,
                'status' => 'Menunggu Proses'
            ]);

            // 2. Insert ke detail_peminjamans (Bisa lebih dari 1 barang)
            foreach ($request->kode_barang as $index => $kode) {
                $jumlahDiminta = $request->jumlah[$index];
                
                // Validasi ulang untuk memastikan stok tidak dicurangi
                $cekBarang = Barang::where('kode_barang', $kode)->lockForUpdate()->first();
                if ($jumlahDiminta > $cekBarang->stok_tersedia) {
                    throw new \Exception("stok tersedia kurang untuk barang {$cekBarang->nama_barang}. (Sisa: {$cekBarang->stok_tersedia})");
                }

                DetailPeminjaman::create([
                    'peminjaman_id' => $trxId,
                    'kode_barang' => $kode,
                    'jumlah' => $jumlahDiminta
                ]);
                 
                 // LANGSUNG kurangi stok agar tidak di-booking orang lain
                 $cekBarang->decrement('stok_tersedia', $jumlahDiminta);
            }

            DB::commit();
            return redirect()->back()->with('success', "Pengajuan berhasil dikirim dengan ID: {$trxId}. Menunggu ACC Umpeg.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}