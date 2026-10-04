<?php

namespace App\Http\Controllers\Umpeg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjam;
use App\Models\User;

class PeminjamController extends Controller
{
    public function index()
    {
        $peminjams = Peminjam::with('user')->paginate(10);
        return view('umpeg.peminjam.index', compact('peminjams'));
    }

    public function verify(string $id)
    {
        $peminjam = Peminjam::findOrFail($id);

        $peminjam->is_verified = !$peminjam->is_verified;
        $peminjam->status_akun = $peminjam->is_verified ? 'Disetujui' : 'Menunggu';
        $peminjam->save();

        $status = $peminjam->is_verified ? 'disetujui' : 'dibatalkan persetujuannya';
        return back()->with('success', "Akun {$peminjam->user->name} berhasil $status.");
    }

    public function tolak(string $id)
    {
        $peminjam = Peminjam::findOrFail($id);

        $peminjam->status_akun = 'Ditolak';
        $peminjam->is_verified = false;
        $peminjam->save();

        return back()->with('success', "Pendaftaran peminjam {$peminjam->user->name} berhasil ditolak.");
    }

    public function nonaktif(string $id)
    {
        $peminjam = Peminjam::findOrFail($id);

        $peminjam->status_akun = 'Nonaktif';
        $peminjam->is_verified = false;
        $peminjam->save();

        return back()->with('success', "Akun peminjam {$peminjam->user->name} berhasil dinonaktifkan.");
    }

    public function destroy(string $id)
    {
        try {
            $peminjam = Peminjam::findOrFail($id);
            $user = $peminjam->user;

            // Kembalikan stok untuk transaksi yang masih aktif (belum selesai/ditolak)
            $activePeminjamans = $peminjam->peminjaman()
                ->whereIn('status', ['Menunggu Proses', 'Menunggu Cetak Bukti', 'Dipinjam'])
                ->with('detailPeminjaman.barang')
                ->get();

            foreach ($activePeminjamans as $peminjaman) {
                foreach ($peminjaman->detailPeminjaman as $detail) {
                    if ($detail->barang) {
                        $detail->barang->increment('stok_tersedia', $detail->jumlah);
                    }
                }
            }

            $peminjam->delete();
            if ($user) {
                $user->delete();
            }

            if (Peminjam::count() == 0) {
                \Illuminate\Support\Facades\DB::statement('ALTER TABLE peminjams AUTO_INCREMENT = 1');
            }

            return back()->with('success', "Akun peminjam berhasil dihapus secara permanen.");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus akun. Pastikan tidak ada data transaksi peminjaman yang masih terkait dengan akun ini.');
        }
    }
}
