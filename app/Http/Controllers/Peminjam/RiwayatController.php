<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index()
    {
        $peminjamId = Auth::user()->peminjam?->id_peminjam;
        
        if (!$peminjamId) {
            return redirect()->route('peminjam.dashboard')->with('error', 'Data peminjam tidak ditemukan.');
        }

        $riwayat = Peminjaman::where('peminjam_id', $peminjamId)
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);
                             
        return view('peminjam.riwayat.index', compact('riwayat'));
    }

    public function show(string $id)
    {
        $peminjamId = Auth::user()->peminjam?->id_peminjam;
        
        $peminjaman = Peminjaman::with('detailPeminjaman.barang')
                                ->where('id_peminjaman', $id)
                                ->where('peminjam_id', $peminjamId)
                                ->firstOrFail();
                                
        return view('peminjam.riwayat.show', compact('peminjaman'));
    }

    public function cetakBukti(string $id)
    {
        $peminjamId = Auth::user()->peminjam?->id_peminjam;
        
        $peminjaman = Peminjaman::with('detailPeminjaman.barang', 'peminjam.user')
                                ->where('id_peminjaman', $id)
                                ->where('peminjam_id', $peminjamId)
                                ->firstOrFail();

        // Bisa dicetak jika statusnya Menunggu Cetak Bukti, Dipinjam, atau Selesai
        if (!in_array($peminjaman->status, ['Menunggu Cetak Bukti', 'Dipinjam', 'Selesai'])) {
            return back()->with('error', 'Bukti hanya bisa dicetak untuk pengajuan yang telah disetujui.');
        }

        $pdf = Pdf::loadView('peminjam.riwayat.pdf_bukti', compact('peminjaman'));
        return $pdf->stream('Bukti_Peminjaman_' . $peminjaman->id_peminjaman . '.pdf');
    }
}
