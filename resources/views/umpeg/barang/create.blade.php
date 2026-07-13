@extends('layouts.app')

@section('content')
<div class="bg-white border border-slate-200 shadow-sm p-6 sm:p-8 rounded-2xl relative overflow-hidden mb-6">
 <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
 <div>
 <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 uppercase tracking-tight">Tambah Barang Baru</h3>
 <p class="text-slate-700 font-medium text-sm mt-1 max-w-2xl leading-relaxed">
 Silakan isi detail spesifikasi barang untuk dimasukkan ke master data inventaris.
 </p>
 </div>
 <div class="shrink-0">
 <a href="{{ route('umpeg.barang.index') }}" class="inline-flex items-center justify-center gap-2 bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-300 transition-colors shadow-sm">
 Kembali
 </a>
 </div>
 </div>
</div>

@if($errors->any())
 <div class="bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex flex-col gap-1">
 <div class="flex items-center gap-3">
 <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 <span class="font-semibold text-sm">Terdapat kesalahan pada input Anda.</span>
 </div>
 <ul class="list-disc list-inside text-xs font-medium mt-1 ml-8">
 @foreach($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
@endif

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8">
 <form action="{{ route('umpeg.barang.store') }}" method="POST" enctype="multipart/form-data">
 @csrf
 
 <div class="mb-6">
 <label class="block text-slate-800 text-sm font-bold mb-2 tracking-wide">Nama Barang</label>
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
 <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
 </div>
 <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="block w-full pl-11 pr-3 py-3 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm" placeholder="Contoh: Laptop Asus VivoBook" required>
 </div>
 </div>

 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-6">
 <div class="sm:col-span-2">
 <label class="block text-slate-800 text-sm font-bold mb-2 tracking-wide">Kategori</label>
 <div class="relative">
 <select name="kategori_id" class="block w-full pl-4 pr-10 py-3 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm appearance-none" required>
 <option value="">-- Pilih Kategori --</option>
 @foreach($kategoris as $kategori)
 <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
 {{ $kategori->nama_kategori }}
 </option>
 @endforeach
 </select>
 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
 </div>
 </div>
 </div>
 <div>
 <label class="block text-slate-800 text-sm font-bold mb-2 tracking-wide">Stok Total</label>
 <input type="number" name="stok_total" value="{{ old('stok_total') }}" class="block w-full px-4 py-3 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm" placeholder="Jml" min="1" required>
 </div>
 <div>
 <label class="block text-slate-800 text-sm font-bold mb-2 tracking-wide">Kondisi</label>
 <div class="relative">
 <select name="kondisi" class="block w-full pl-4 pr-10 py-3 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm appearance-none" required>
 <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
 <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
 </select>
 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
 </div>
 </div>
 </div>
 </div>

 <div class="mb-6">
 <label class="block text-slate-800 text-sm font-bold mb-2 tracking-wide">Upload Foto Barang <span class="text-xs text-slate-500 font-medium">(Opsional)</span></label>
 <div class="relative">
 <input type="file" name="foto_barang" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 bg-white border border-emerald-200 rounded-xl focus:outline-none transition-colors shadow-sm">
 </div>
 <p class="text-[11px] text-slate-500 mt-1.5 font-medium">Maksimal ukuran file: 2MB. Format: JPG, JPEG, PNG.</p>
 </div>

 <div class="mb-8">
 <label class="block text-slate-800 text-sm font-bold mb-2 tracking-wide">Deskripsi / Spesifikasi</label>
 <textarea name="deskripsi" rows="3" class="block w-full p-4 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm placeholder-slate-400" placeholder="Tuliskan spesifikasi detail barang di sini...">{{ old('deskripsi') }}</textarea>
 </div>

 <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-end gap-3">
 <a href="{{ route('umpeg.barang.index') }}" class="w-full sm:w-auto bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 px-8 rounded-xl transition-colors tracking-wide text-center">
 Batal
 </a>
 <button type="submit" class="w-full sm:w-auto bg-[#064e3b] hover:bg-[#152c6b] text-white font-bold py-3 px-8 rounded-xl transition-colors tracking-wider shadow-md flex items-center justify-center gap-2">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
 SIMPAN BARANG
 </button>
 </div>
 </form>
</div>
@endsection