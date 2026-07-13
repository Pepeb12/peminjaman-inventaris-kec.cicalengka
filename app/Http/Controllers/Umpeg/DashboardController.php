<?php

namespace App\Http\Controllers\Umpeg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $menunggu = Peminjaman::where('status', 'Menunggu Proses')->count();
        $dipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        
        $totalPeminjam = User::where('role', 'peminjam')->count();

        // 5 Pengajuan terbaru untuk notifikasi cepat
        $terbaru = Peminjaman::with('peminjam.user')
                             ->where('status', 'Menunggu Proses')
                             ->orderBy('created_at', 'desc')
                             ->take(5)
                             ->get();

        // Barang stok tipis (misalnya stok tersedia = 0)
        $stokTipis = Barang::where('stok_tersedia', 0)->take(5)->get();

        // Statistik Detail untuk Chart (Peminjaman 6 Bulan Terakhir)
        $chartBulan = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = \Carbon\Carbon::now()->subMonths($i);
            $chartBulan[] = $month->translatedFormat('F Y');
            $chartData[] = Peminjaman::whereMonth('created_at', $month->month)
                                     ->whereYear('created_at', $month->year)
                                     ->count();
        }

        // Top 5 Barang Paling Sering Dipinjam
        $topBarang = \Illuminate\Support\Facades\DB::table('detail_peminjamans')
            ->select('kode_barang', \Illuminate\Support\Facades\DB::raw('SUM(jumlah) as total_dipinjam'))
            ->groupBy('kode_barang')
            ->orderByDesc('total_dipinjam')
            ->take(5)
            ->get();
            
        // Ambil nama barangnya
        foreach ($topBarang as $tb) {
            $barang = Barang::find($tb->kode_barang);
            $tb->nama_barang = $barang ? $barang->nama_barang : 'Barang Dihapus';
        }

        // Status Breakdown
        $statusBreakdown = [
            'Menunggu' => $menunggu,
            'Dipinjam' => $dipinjam,
            'Selesai' => Peminjaman::where('status', 'Selesai')->count(),
            'Ditolak' => Peminjaman::where('status', 'Ditolak')->count(),
        ];

        return view('umpeg.dashboard', compact('totalBarang', 'menunggu', 'dipinjam', 'totalPeminjam', 'terbaru', 'stokTipis', 'chartBulan', 'chartData', 'topBarang', 'statusBreakdown'));
    }
}
