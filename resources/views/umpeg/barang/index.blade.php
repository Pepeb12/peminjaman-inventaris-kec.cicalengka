@extends('layouts.app')

@section('content')
<div class="bg-white border border-slate-200 shadow-sm p-6 sm:p-8 rounded-2xl relative overflow-hidden flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
 <div class="relative z-10">
 <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 uppercase tracking-tight">Data Master Barang</h3>
 <p class="text-slate-700 font-medium text-sm mt-1 max-w-2xl leading-relaxed">
 Kelola data semua jenis barang inventaris yang tersedia di Kecamatan Cicalengka.
 </p>
 </div>
 <div class="relative z-10 shrink-0 flex gap-2">
 <a href="{{ route('umpeg.dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-300 transition-colors shadow-sm">
 Kembali
 </a>
 <a href="{{ route('umpeg.barang.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#064e3b] text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#152c6b] transition-colors shadow-lg">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
 Tambah Barang
 </a>
 </div>
</div>

@if(session('success'))
 <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center gap-3">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 <span class="font-semibold text-sm">{{ session('success') }}</span>
 </div>
@endif

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
 <div class="overflow-x-auto">
 <table class="w-full text-left text-sm text-slate-600">
 <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 font-bold border-b border-slate-200">
 <tr>
 <th scope="col" class="px-6 py-4 text-center" width="10%">Foto</th>
 <th scope="col" class="px-6 py-4">Kode Barang</th>
 <th scope="col" class="px-6 py-4">Nama Barang</th>
 <th scope="col" class="px-6 py-4">Kategori</th>
 <th scope="col" class="px-6 py-4">Stok Total</th>
 <th scope="col" class="px-6 py-4">Stok Tersedia</th>
 <th scope="col" class="px-6 py-4 text-center" width="15%">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-200">
 @forelse($barangs as $item)
 <tr class="hover:bg-white transition-colors">
 <td class="px-6 py-4 text-center">
 @if($item->foto_barang)
 <div class="w-14 h-14 rounded-lg overflow-hidden border-2 border-slate-200 shadow-sm mx-auto">
 <img src="{{ asset('storage/' . $item->foto_barang) }}" alt="Foto" class="w-full h-full object-cover cursor-pointer hover:opacity-80 transition-opacity" onclick="openImageModal(this.src)">
 </div>
 @else
 <span class="inline-flex items-center justify-center px-2 py-1 rounded text-[10px] font-bold bg-slate-200 text-slate-600 uppercase">
 No Image
 </span>
 @endif
 </td>
 <td class="px-6 py-4 font-bold text-slate-900">
 {{ $item->kode_barang }}
 </td>
 <td class="px-6 py-4 font-medium text-slate-800">
 {{ $item->nama_barang }}
 </td>
 <td class="px-6 py-4 font-medium text-slate-800 whitespace-normal">
 {{ $item->kategori->nama_kategori ?? '-' }}
 </td>
 <td class="px-6 py-4 font-bold text-slate-800">
 {{ $item->stok_total }}
 </td>
 <td class="px-6 py-4 font-bold text-emerald-600">
 {{ $item->stok_tersedia }}
 </td>
 <td class="px-6 py-4">
 <div class="flex items-center justify-center gap-2">
 <a href="{{ route('umpeg.barang.edit', $item->kode_barang) }}" class="bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Edit</a>
 
 <form action="{{ route('umpeg.barang.destroy', $item->kode_barang) }}" method="POST" class="inline" onsubmit="confirmSubmit(event, 'Yakin ingin menghapus barang ini?');">
 @csrf
 @method('DELETE')
 <button type="submit" class="bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Hapus</button>
 </form>
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="6" class="px-6 py-12 text-center text-slate-500 font-medium">
 <div class="flex flex-col items-center justify-center">
 <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
 Data barang masih kosong.
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>
@endsection