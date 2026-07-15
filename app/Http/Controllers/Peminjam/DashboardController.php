<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peminjamId = $user->peminjam?->id;

        $totalPengajuan = 0;
        $menungguValidasi = 0;
        $sedangDipinjam = 0;
        $selesai = 0;
        $riwayat = collect();
        $peringatanPengembalian = collect();

        if ($peminjamId) {
            $totalPengajuan = Peminjaman::where('peminjam_id', $peminjamId)->count();
            $menungguValidasi = Peminjaman::where('peminjam_id', $peminjamId)->where('status', 'Menunggu Proses')->count();
            $sedangDipinjam = Peminjaman::where('peminjam_id', $peminjamId)->where('status', 'Dipinjam')->count();
            $selesai = Peminjaman::where('peminjam_id', $peminjamId)->where('status', 'Selesai')->count();

            // Riwayat diambil terpisah (hanya 5 terakhir untuk dashboard)
            $riwayat = Peminjaman::where('peminjam_id', $peminjamId)
                ->orderBy('created_at', 'desc')
                ->take(5)->get();

            // Peringatan pengembalian (H-1 atau sudah lewat)
            $peringatanPengembalian = Peminjaman::where('peminjam_id', $peminjamId)
                ->where('status', 'Dipinjam')
                ->whereDate('tgl_kembali', '<=', now()->addDays(1))
                ->orderBy('tgl_kembali', 'asc')
                ->get();
        }

        return view('peminjam.dashboard', compact('totalPengajuan', 'menungguValidasi', 'sedangDipinjam', 'selesai', 'riwayat', 'peringatanPengembalian'));
    }
}
