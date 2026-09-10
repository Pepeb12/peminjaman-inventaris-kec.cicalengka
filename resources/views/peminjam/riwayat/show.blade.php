@extends('layouts.app')

@section('content')
<div class="bg-white min-h-full flex flex-col">
 <div class="p-6 border-b border-slate-200 flex justify-between items-center">
 <div>
 <h2 class="text-xl sm:text-2xl font-extrabold text-slate-800 uppercase tracking-tight">Detail Transaksi</h2>
 <p class="text-sm text-slate-500 mt-1">Nomor Resi: <span class="font-bold text-slate-700">{{ $peminjaman->id }}</span></p>
 </div>
 <a href="{{ route('peminjam.riwayat.index') }}" class="text-slate-500 hover:text-slate-800 font-bold text-sm flex items-center gap-2">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
 Kembali
 </a>
 </div>

 <div class="flex flex-col md:flex-row flex-1">
 <div class="w-full md:w-1/3 border-b md:border-b-0 md:border-r border-slate-200 p-6 space-y-6">
 <div>
 <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Transaksi</h3>
 
 <div class="space-y-4">
 <div>
 <p class="text-xs text-slate-500 font-medium">Status Pengajuan</p>
 @if($peminjaman->status == 'Menunggu Proses')
 <span class="inline-block mt-1 text-sm font-extrabold text-amber-600 uppercase tracking-widest">Menunggu ACC Umum Kepegawaian</span>
 @elseif($peminjaman->status == 'Menunggu Cetak Bukti')
 <span class="inline-block mt-1 text-sm font-extrabold text-sky-600 uppercase tracking-widest">Serahkan Cetak Bukti</span>
 @elseif($peminjaman->status == 'Dipinjam')
 <span class="inline-block mt-1 text-sm font-extrabold text-indigo-600 uppercase tracking-widest">Sedang Dipinjam</span>
 @elseif($peminjaman->status == 'Selesai')
 <span class="inline-block mt-1 text-sm font-extrabold text-emerald-600 uppercase tracking-widest">Selesai Dikembalikan</span>
 @else
 <span class="inline-block mt-1 text-sm font-extrabold text-rose-600 uppercase tracking-widest">Ditolak</span>
 @endif
 </div>

 <div>
 <p class="text-xs text-slate-500 font-medium">Tanggal Peminjaman</p>
 <p class="font-bold text-black">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('j F Y H:i') }}</p>
 </div>
 
 <div>
 <p class="text-xs text-slate-500 font-medium">Tanggal Pengembalian</p>
 <p class="font-bold text-black">{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->translatedFormat('j F Y H:i') }}</p>
 </div>
 </div>

 @if($peminjaman->status == 'Dipinjam')
 <div class="mt-4 p-4 bg-indigo-50 border border-indigo-100 rounded-xl">
 <p class="text-[10px] font-bold text-indigo-800 uppercase tracking-widest mb-1">Waktu Tersisa</p>
 <div id="countdown-timer" class="font-mono text-lg font-extrabold text-indigo-700" data-target="{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->toIso8601String() }}">
 Memuat...
 </div>
 <div id="countdown-warning" class="hidden mt-2 text-xs font-bold text-rose-600 bg-rose-100 p-2 rounded-lg border border-rose-200">
 ⚠️ Waktu pengembalian telah habis! Segera kembalikan barang ke Umum Kepegawaian.
 </div>
 </div>
 @endif
 @if(in_array($peminjaman->status, ['Menunggu Cetak Bukti', 'Dipinjam', 'Selesai']))
 <div class="mt-6 pt-6 border-t border-slate-200">
 <a href="{{ route('peminjam.riwayat.cetak', $peminjaman->id) }}" target="_blank" class="w-full bg-[#064e3b] hover:bg-blue-800 text-white flex justify-center items-center gap-2 font-bold text-sm py-2.5 rounded-xl transition-colors">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
 Cetak Bukti (PDF)
 </a>
 @if($peminjaman->status == 'Menunggu Cetak Bukti')
 <p class="text-[10px] text-sky-700 font-bold uppercase tracking-wide text-center mt-3 bg-sky-50 p-2 rounded-lg border border-sky-200">Cetak bukti ini dan serahkan ke Umum Kepegawaian Kecamatan untuk proses pengambilan barang.</p>
 @endif
 </div>
 @endif
 </div>

 @if($peminjaman->status == 'Ditolak' && $peminjaman->pesan_tolak)
 <div class="bg-rose-50 border border-rose-100 p-6 rounded-2xl shadow-sm">
 <h3 class="text-xs font-bold text-rose-500 uppercase tracking-widest mb-2 flex items-center gap-2">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 Alasan Penolakan
 </h3>
 <p class="text-sm text-rose-700 font-medium">{{ $peminjaman->pesan_tolak }}</p>
 </div>
 @endif

 @if($peminjaman->status == 'Selesai' && $peminjaman->catatan_kembali)
 <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl shadow-sm">
 <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 flex items-center gap-2">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
 Catatan Pengembalian
 </h3>
 <p class="text-sm text-slate-700 font-medium">{{ $peminjaman->catatan_kembali }}</p>
 </div>
 @endif
 </div>

 <div class="w-full md:w-2/3 p-6 flex flex-col">
 <div>
 <h3 class="font-bold text-slate-800 mb-4">Rincian Barang yang Dipinjam</h3>
 </div>
 <div class="flex-1">
 <div class="space-y-4">
 @foreach($peminjaman->detailPeminjaman as $detail)
 <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-white hover:border-[#064e3b]/20 transition-colors">
 <div class="w-16 h-16 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden">
 @if($detail->barang && $detail->barang->foto_barang)
 <img src="{{ asset('storage/' . $detail->barang->foto_barang) }}" class="w-full h-full object-cover cursor-pointer hover:opacity-80 transition-opacity" onclick="openImageModal(this.src)">
 @else
 <div class="w-full h-full flex items-center justify-center text-slate-400">
 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
 </div>
 @endif
 </div>
 <div class="flex-1">
 <h4 class="font-bold text-slate-800">{{ $detail->barang->nama_barang ?? 'Barang Telah Dihapus' }}</h4>
 <p class="text-xs text-slate-500 font-medium">Kode: {{ $detail->kode_barang }}</p>
 </div>
 <div class="text-right">
 <span class="text-2xl font-extrabold text-[#064e3b]">{{ $detail->jumlah }}</span>
 <span class="text-xs text-slate-500 font-bold uppercase tracking-widest ml-1">Unit</span>
 </div>
 </div>
 @endforeach
 </div>
 </div>
 </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timerElement = document.getElementById('countdown-timer');
    const warningElement = document.getElementById('countdown-warning');
    
    if (timerElement) {
        const targetDate = new Date(timerElement.getAttribute('data-target')).getTime();
        
        const updateTimer = setInterval(function() {
            const now = new Date().getTime();
            const distance = targetDate - now;
            
            if (distance < 0) {
                clearInterval(updateTimer);
                timerElement.textContent = "00 Hari 00 Jam 00 Menit 00 Detik";
                timerElement.classList.replace('text-indigo-700', 'text-rose-600');
                if(warningElement) warningElement.classList.remove('hidden');
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            const pad = (n) => n.toString().padStart(2, '0');
            timerElement.textContent = `${pad(days)} Hari ${pad(hours)} Jam ${pad(minutes)} Menit ${pad(seconds)} Detik`;
        }, 1000);
    }
});
</script>
@endsection
