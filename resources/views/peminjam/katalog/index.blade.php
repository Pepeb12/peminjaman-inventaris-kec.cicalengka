@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
 <div>
 <h2 class="text-2xl font-extrabold text-slate-800 uppercase tracking-tight">Katalog Barang</h2>
 <p class="text-sm text-slate-500 mt-1">Lihat ketersediaan barang yang dapat Anda pinjam.</p>
 </div>
 <div class="w-full sm:w-auto">
 <form action="{{ route('peminjam.katalog.index') }}" method="GET" class="relative">
 <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..." class="w-full sm:w-64 pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#064e3b] focus:border-transparent transition-all shadow-sm">
 <div class="absolute left-3 top-2.5 text-slate-400">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
 </div>
 @if(request('search'))
 <a href="{{ route('peminjam.katalog.index') }}" class="absolute right-3 top-3 text-slate-400 hover:text-rose-500">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
 </a>
 @endif
 </form>
 </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
 @forelse($barangs as $barang)
 <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group hover:-translate-y-1">
 <div class="h-48 bg-slate-100 relative overflow-hidden">
 @if($barang->foto_barang)
 <img src="{{ asset('storage/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 cursor-pointer" onclick="openImageModal(this.src)">
 @else
 <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100">
 <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
 <span class="text-xs font-medium uppercase tracking-wider">Tanpa Foto</span>
 </div>
 @endif
 
 @if($barang->stok_tersedia > 0)
 <div class="absolute top-3 right-3 bg-white text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
 <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
 Tersedia: {{ $barang->stok_tersedia }}
 </div>
 @else
 <div class="absolute top-3 right-3 bg-white text-rose-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
 <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
 Stok Habis
 </div>
 @endif
 </div>
 
 <div class="p-5 flex-1 flex flex-col">
 <div class="flex justify-between items-start mb-1">
 <h3 class="font-bold text-slate-900 text-lg line-clamp-1" title="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</h3>
 </div>
 <div class="mb-2">
 <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">{{ $barang->kategori->nama_kategori ?? 'Umum' }}</span>
 </div>
 
 <p class="text-xs text-slate-500 font-medium mb-3">
 Kode: <span class="font-bold text-slate-700">{{ $barang->kode_barang }}</span>
 </p>
 
 <p class="text-sm text-slate-600 line-clamp-2 mb-4 flex-1">
 {{ $barang->deskripsi ?? 'Tidak ada deskripsi.' }}
 </p>
 
 @if($barang->stok_tersedia > 0)
 <a href="{{ route('peminjam.pengajuan.create') }}" class="w-full bg-[#064e3b] hover:bg-blue-800 text-white text-center font-bold text-sm py-2.5 rounded-xl transition-colors mt-auto">
 Ajukan Peminjaman
 </a>
 @else
 <button disabled class="w-full bg-slate-100 text-slate-400 text-center font-bold text-sm py-2.5 rounded-xl cursor-not-allowed mt-auto border border-slate-200 shadow-sm">
 Tidak Bisa Dipinjam
 </button>
 @endif
 </div>
 </div>
 @empty
 <div class="col-span-full bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm">
 <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
 <h3 class="text-lg font-bold text-slate-800 mb-1">Barang Tidak Ditemukan</h3>
 <p class="text-slate-500 text-sm">
 @if(request('search'))
 Pencarian untuk "{{ request('search') }}" tidak memberikan hasil.
 @else
 Saat ini belum ada barang yang tersedia untuk dipinjam.
 @endif
 </p>
 @if(request('search'))
 <a href="{{ route('peminjam.katalog.index') }}" class="inline-block mt-4 text-[#064e3b] hover:underline font-medium text-sm">
 Kembali ke Katalog
 </a>
 @endif
 </div>
 @endforelse
</div>

<div class="mt-6">
 {{ $barangs->links() }}
</div>
@endsection
