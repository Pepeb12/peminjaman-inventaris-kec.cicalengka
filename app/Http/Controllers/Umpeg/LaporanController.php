<?php

namespace App\Http\Controllers\Umpeg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        // Tampilkan halaman form filter
        return view('umpeg.laporan.index');
    }

    public function cetak(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:2000'
        ]);

        $query = Peminjaman::with(['peminjam.user', 'detailPeminjaman.barang'])
                           ->where('status', 'Selesai'); // Biasanya laporan difokuskan pada yang sudah selesai

        if ($request->bulan) {
            $query->whereMonth('tgl_pinjam', $request->bulan);
        }
        
        if ($request->tahun) {
            $query->whereYear('tgl_pinjam', $request->tahun);
        }

        $peminjamans = $query->orderBy('tgl_pinjam', 'asc')->get();

        $data = [
            'peminjamans' => $peminjamans,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'waktu_cetak' => now()->format('d/m/Y H:i')
        ];

        // Load view PDF dan atur ukuran kertas ke F4 / Folio (Legal)
        $pdf = Pdf::loadView('umpeg.laporan.pdf', $data)->setPaper('legal', 'landscape');
        
        // Gunakan stream() agar PDF terbuka di browser (tidak langsung download)
        return $pdf->stream('Laporan_Inventaris_Cicalengka.pdf');
    }

    public function exportCsv(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|min:1|max:12',
            'tahun' => 'nullable|integer|min:2000'
        ]);

        $query = Peminjaman::with(['peminjam.user', 'detailPeminjaman.barang'])
                           ->where('status', 'Selesai');

        if ($request->bulan) {
            $query->whereMonth('tgl_pinjam', $request->bulan);
        }
        
        if ($request->tahun) {
            $query->whereYear('tgl_pinjam', $request->tahun);
        }

        $peminjamans = $query->orderBy('tgl_pinjam', 'asc')->get();

        $filename = "laporan_inventaris_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Transaksi', 'Tgl Pinjam', 'Tgl Kembali', 'Instansi Peminjam', 'Penanggung Jawab', 'Kontak', 'Alamat', 'Detail Barang Dipinjam'];

        $callback = function() use($peminjamans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';'); 

            foreach ($peminjamans as $trx) {
                $barangList = [];
                foreach ($trx->detailPeminjaman as $detail) {
                    $namaBarang = $detail->barang->nama_barang ?? 'Dihapus';
                    $barangList[] = "{$namaBarang} ({$detail->jumlah} unit)";
                }
                
                $row = [
                    $trx->id,
                    \Carbon\Carbon::parse($trx->tgl_pinjam)->format('Y-m-d H:i'),
                    \Carbon\Carbon::parse($trx->tgl_kembali)->format('Y-m-d H:i'),
                    $trx->peminjam->nama_instansi ?? $trx->peminjam->jenis_peminjam ?? '-',
                    $trx->peminjam->user->name ?? '-',
                    $trx->peminjam->kontak_penanggung_jawab ?? '-',
                    $trx->peminjam->user->alamat ?? '-',
                    implode(', ', $barangList)
                ];

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}