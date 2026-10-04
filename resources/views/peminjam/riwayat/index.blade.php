@extends('layouts.app')

@section('content')
<div class="bg-white min-h-full relative overflow-hidden flex flex-col">
    <div class="p-6 sm:p-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="relative z-10 flex-1">
            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 uppercase tracking-tight">Riwayat Peminjaman</h3>
            <p class="text-slate-700 font-medium text-sm mt-1 max-w-2xl leading-relaxed">
                Daftar semua transaksi yang pernah Anda ajukan.
            </p>
        </div>
        <div class="relative z-10 shrink-0 flex gap-2 w-full sm:w-auto justify-start sm:justify-end mt-4 sm:mt-0">
            <a href="{{ route('peminjam.pengajuan.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#064e3b] text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#152c6b] transition-colors shadow-lg flex-1 sm:flex-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Pengajuan Baru
            </a>
        </div>
    </div>
 <div class="overflow-x-auto">
 <table class="w-full text-left text-sm text-slate-600">
 <thead class="bg-[#1e3a8a] text-sm uppercase text-white font-extrabold border-b-2 border-slate-300">
 <tr>
 <th scope="col" class="px-6 py-4">ID Transaksi</th>
 <th scope="col" class="px-6 py-4">Tanggal Pinjam</th>
 <th scope="col" class="px-6 py-4">Tanggal Kembali</th>
 <th scope="col" class="px-6 py-4">Status</th>
 <th scope="col" class="px-6 py-4">Catatan Admin</th>
 <th scope="col" class="px-6 py-4 w-48">Rincian Barang</th>
 <th scope="col" class="px-6 py-4 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-200">
 @forelse($riwayat as $trx)
 @php
     $isLate = ($trx->status == 'Dipinjam' && \Carbon\Carbon::parse($trx->tgl_kembali)->isPast());
     $textClass = $isLate ? '!text-red-600 font-bold' : '';
     $bgClass = $isLate ? 'bg-red-50' : 'hover:bg-white';
 @endphp
 <tr class="{{ $bgClass }} transition-colors">
 <td class="px-6 py-4 font-bold {{ $isLate ? 'text-red-600' : 'text-slate-900' }}">{{ $trx->id_peminjaman }}</td>
 <td class="px-6 py-4 font-medium {{ $isLate ? 'text-red-600' : 'text-black' }}">{{ \Carbon\Carbon::parse($trx->tgl_pinjam)->translatedFormat('j F Y H:i') }}</td>
 <td class="px-6 py-4 font-medium {{ $isLate ? 'text-red-600' : 'text-black' }}">{{ \Carbon\Carbon::parse($trx->tgl_kembali)->translatedFormat('j F Y H:i') }}</td>
 <td class="px-6 py-4">
 @if($trx->status == 'Menunggu Proses')
 <span class="text-[10px] font-bold text-amber-700 uppercase tracking-widest">Menunggu ACC Umum Kepegawaian</span>
 @elseif($trx->status == 'Menunggu Cetak Bukti')
 <span class="text-[10px] font-bold text-sky-700 uppercase tracking-widest">Serahkan Cetak Bukti</span>
 @elseif($trx->status == 'Dipinjam')
 <span class="text-[10px] font-bold {{ $isLate ? 'text-red-600' : 'text-indigo-700' }} uppercase tracking-widest">Dipinjam</span>
 @elseif($trx->status == 'Selesai')
 <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-widest">Selesai</span>
 @else
 <span class="text-[10px] font-bold text-rose-700 uppercase tracking-widest">Ditolak</span>
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
 <td class="px-6 py-4">
 <ul class="list-disc list-inside {{ $isLate ? 'text-red-600' : 'text-slate-600' }} text-xs space-y-1">
 @foreach($trx->detailPeminjaman as $detail)
 <li class="mb-1">
     {{ $detail->barang->nama_barang ?? 'Barang Terhapus' }} <span class="font-bold {{ $isLate ? 'text-red-600' : 'text-slate-800' }}">({{ $detail->jumlah }}x)</span>
 </li>
 @endforeach
 </ul>
 </td>
 <td class="px-6 py-4 text-center">
 <div class="flex justify-center items-center gap-2">
 <a href="{{ route('peminjam.riwayat.show', $trx->id_peminjaman) }}" class="text-white bg-emerald-500 hover:bg-emerald-600 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Lihat Detail</a>
 @if(in_array($trx->status, ['Menunggu Cetak Bukti', 'Dipinjam', 'Selesai']))
 <a href="{{ route('peminjam.riwayat.cetak', $trx->id_peminjaman) }}" target="_blank" class="text-slate-600 bg-slate-200 hover:bg-slate-300 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors" title="Cetak Bukti">Cetak Bukti</a>
 @endif
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="7" class="px-6 py-8 text-center text-slate-500 font-medium">Anda belum memiliki riwayat peminjaman.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>

 @if($riwayat->hasPages())
 <div class="p-4 border-t border-slate-200 bg-slate-50/50">
 {{ $riwayat->links('vendor.pagination.custom') }}
 </div>
 @endif
</div>
@endsection
