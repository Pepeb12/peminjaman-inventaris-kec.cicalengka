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

        if ($peminjaman->status === 'Menunggu Proses') {
            return back()->with('error', 'Menunggu persetujuan umum kepegawaian.');
        }

        if ($peminjaman->status === 'Ditolak') {
            return back()->with('error', 'Bukti tidak dapat dicetak untuk pengajuan yang ditolak.');
        }

        $pdf = Pdf::loadView('peminjam.riwayat.pdf_bukti', compact('peminjaman'));
        return $pdf->stream('Bukti_Peminjaman_' . $peminjaman->id_peminjaman . '.pdf');
    }
}
