@extends('layouts.app')

@section('content')

<!-- HEADER & WAKTU -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white border border-slate-300 p-5 rounded-sm shadow-sm mb-6">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Dashboard Peminjam</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola peminjaman barang dengan mudah.</p>
    </div>
    <div class="mt-4 md:mt-0 flex items-center gap-3 bg-slate-900 text-white px-5 py-3 rounded-lg shadow-inner">
        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div id="realtime-clock" class="font-mono font-bold text-lg tracking-wider"></div>
    </div>
</div>

@if(isset($peringatanPengembalian) && $peringatanPengembalian->count() > 0)
<div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-bold text-rose-800">Peringatan Pengembalian Barang</h3>
            <div class="mt-2 text-sm text-rose-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($peringatanPengembalian as $peringatan)
                    <li>
                        Transaksi <strong>{{ $peringatan->id }}</strong> harus dikembalikan pada 
                        <strong>{{ \Carbon\Carbon::parse($peringatan->tgl_kembali)->translatedFormat('j F Y') }}</strong>.
                        <a href="{{ route('peminjam.riwayat.show', $peringatan->id) }}" class="underline font-bold hover:text-rose-900 ml-1">Lihat Detail</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

<!-- STATISTIK RINGKASAN -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 mt-6">
 <div class="bg-white border border-slate-300 p-5 rounded-sm relative overflow-hidden">
 <p class="text-blue-800 font-bold text-[10px] uppercase tracking-widest mb-1 relative z-10">Total Pengajuan</p>
 <h2 class="text-3xl font-extrabold text-slate-900 relative z-10">{{ $totalPengajuan ?? 0 }}</h2>
 </div>
 
 <div class="bg-white border border-slate-300 p-5 rounded-sm relative overflow-hidden">
 <p class="text-amber-700 font-bold text-[10px] uppercase tracking-widest mb-1 relative z-10">Menunggu Validasi</p>
 <h2 class="text-3xl font-extrabold text-slate-900 relative z-10">{{ $menungguValidasi ?? 0 }}</h2>
 </div>

 <div class="bg-white border border-slate-300 p-5 rounded-sm relative overflow-hidden">
 <p class="text-indigo-700 font-bold text-[10px] uppercase tracking-widest mb-1 relative z-10">Sedang Dipinjam</p>
 <h2 class="text-3xl font-extrabold text-slate-900 relative z-10">{{ $sedangDipinjam ?? 0 }}</h2>
 </div>

 <div class="bg-white border border-slate-300 p-5 rounded-sm relative overflow-hidden">
 <p class="text-emerald-700 font-bold text-[10px] uppercase tracking-widest mb-1 relative z-10">Selesai Dikembalikan</p>
 <h2 class="text-3xl font-extrabold text-slate-900 relative z-10">{{ $selesai ?? 0 }}</h2>
 </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
 <!-- ATURAN PEMINJAMAN -->
 <div class="lg:col-span-1 bg-slate-900 rounded-sm p-6 text-white relative overflow-hidden border border-slate-800">
 <h4 class="text-lg font-bold mb-4 flex items-center gap-2 relative z-10">
 <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 Prosedur Peminjaman
 </h4>
 <ul class="space-y-3 text-sm text-slate-300 relative z-10">
 <li class="flex items-start gap-2">
 <span class="font-bold text-white mt-0.5">1.</span>
 <span>Cek ketersediaan barang di menu <strong>Katalog Barang</strong>.</span>
 </li>
 <li class="flex items-start gap-2">
 <span class="font-bold text-white mt-0.5">2.</span>
 <span>Ajukan peminjaman melalui menu <strong>Buat Pengajuan</strong>.</span>
 </li>
 <li class="flex items-start gap-2">
 <span class="font-bold text-white mt-0.5">3.</span>
 <span>Tunggu hingga status berubah menjadi <strong>Dipinjam</strong> (Di-ACC Admin).</span>
 </li>
 <li class="flex items-start gap-2">
 <span class="font-bold text-white mt-0.5">4.</span>
 <span>Cetak <strong>Bukti Peminjaman (PDF)</strong> di menu Riwayat sebagai syarat pengambilan fisik barang.</span>
 </li>
 <li class="flex items-start gap-2">
 <span class="font-bold text-white mt-0.5">5.</span>
 <span>Kembalikan barang sesuai batas waktu. Jika terjadi kerusakan/kehilangan, akan dicatat oleh pihak Kecamatan.</span>
 </li>
 </ul>
 </div>

 <!-- TRANSAKSI TERBARU -->
 <div class="lg:col-span-2 bg-white border border-slate-300 rounded-sm overflow-hidden flex flex-col">
 <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-white">
 <div>
 <h4 class="text-lg font-bold text-slate-900">Riwayat Pengajuan Terakhir</h4>
 <p class="text-xs text-slate-500 font-medium mt-1">Daftar transaksi peminjaman terbaru Anda</p>
 </div>
 <a href="{{ route('peminjam.riwayat.index') }}" class="text-sm font-bold text-blue-700 hover:text-blue-900 hover:underline">Lihat Semua</a>
 </div>
 
 <div class="overflow-x-auto flex-1">
 <table class="w-full text-left text-sm text-slate-600">
 <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 font-bold border-b border-slate-200">
 <tr>
 <th scope="col" class="px-6 py-4">ID Transaksi</th>
 <th scope="col" class="px-6 py-4">Tgl Pinjam</th>
 <th scope="col" class="px-6 py-4">Status</th>
 <th scope="col" class="px-6 py-4">Catatan Admin</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-200">
 @forelse($riwayat as $trx)
 <tr class="hover:bg-white transition-colors">
 <td class="px-6 py-4 font-bold text-slate-900">
 {{ $trx->id }}
 </td>
 <td class="px-6 py-4 font-medium">
 {{ \Carbon\Carbon::parse($trx->tgl_pinjam)->translatedFormat('j F Y') }}
 </td>
 <td class="px-6 py-4">
 @if($trx->status == 'Menunggu Proses')
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-widest border border-amber-200">
 Menunggu ACC Umum Kepegawaian
 </span>
 @elseif($trx->status == 'Menunggu Cetak Bukti')
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-sky-100 text-sky-700 uppercase tracking-widest border border-sky-200">
 Serahkan Cetak Bukti
 </span>
 @elseif($trx->status == 'Dipinjam')
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700 uppercase tracking-widest border border-indigo-200">
 Dipinjam
 </span>
 @elseif($trx->status == 'Selesai')
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-widest border border-emerald-300">
 Selesai
 </span>
 @else
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-widest border border-rose-200">
 Ditolak
 </span>
 @endif
 </td>
 <td class="px-6 py-4 text-xs max-w-[200px]">
 @if($trx->status == 'Selesai' && $trx->catatan_kembali)
 <span class="text-slate-600 font-medium">{{ \Illuminate\Support\Str::limit($trx->catatan_kembali, 50) }}</span>
 @elseif($trx->status == 'Ditolak' && $trx->pesan_tolak)
 <span class="text-rose-600 font-medium">{{ \Illuminate\Support\Str::limit($trx->pesan_tolak, 50) }}</span>
 @else
 <span class="text-slate-400 italic">-</span>
 @endif
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="4" class="px-6 py-8 text-center text-slate-500 font-medium">
 Anda belum memiliki riwayat peminjaman.
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const dayName = days[now.getDay()];
        
        const pad = (n) => n.toString().padStart(2, '0');
        const hours = pad(now.getHours());
        const minutes = pad(now.getMinutes());
        const seconds = pad(now.getSeconds());
        
        const clockElement = document.getElementById('realtime-clock');
        if (clockElement) {
            clockElement.textContent = `${dayName}, ${hours}:${minutes}:${seconds}`;
        }
    }
    
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection