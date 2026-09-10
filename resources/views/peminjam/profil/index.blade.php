@extends('layouts.app')

@section('content')
<div class="bg-white min-h-full flex flex-col">
 <!-- FORM PROFIL INSTANSI -->
 <div class="w-full overflow-hidden flex flex-col flex-1">
 <div class="p-5 sm:p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
 <div class="relative z-10 flex-1">
 <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 uppercase tracking-tight">Kelola Profil</h3>
 <p class="text-slate-600 font-medium text-xs mt-1 max-w-2xl leading-relaxed">
 Perbarui informasi identitas instansi dan kata sandi Anda.
 </p>
 </div>
 </div>
 
 <div class="p-5 flex-1">
 @if(session('success'))
 <div class="bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl mb-4 text-sm font-medium border border-emerald-100 flex items-center gap-2">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
 {{ session('success') }}
 </div>
 @endif

 <form action="{{ route('peminjam.profil.update') }}" method="POST" enctype="multipart/form-data">
 @csrf
 <div class="space-y-3">
 <div class="mb-4 flex flex-col items-center sm:items-start gap-4">
 <label class="block text-slate-700 text-[11px] font-bold uppercase tracking-wide mb-1">Foto Profil</label>
 <div class="flex items-center gap-4">
 <div class="w-16 h-16 rounded-full overflow-hidden border-4 border-slate-100 shadow-md flex-shrink-0 bg-slate-200 flex items-center justify-center">
 @if($user->foto_profil)
 <img src="{{ asset('storage/' . $user->foto_profil) }}" class="w-full h-full object-cover">
 @else
 <span class="text-2xl font-bold text-slate-400">{{ substr($user->name, 0, 1) }}</span>
 @endif
 </div>
 <div>
 <input type="file" name="foto_profil" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 bg-white border border-slate-200 rounded-xl focus:outline-none transition-colors shadow-sm" required>
 <p class="text-[10px] text-rose-500 mt-1 font-bold italic">* Upload poto profil dengan jelas dan bersifat wajib.</p>
 </div>
 </div>
 </div>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
 <div>
 <label class="block text-slate-700 text-[11px] font-bold uppercase tracking-wide mb-1">Alamat Email (Gmail)</label>
 <input type="email" value="{{ $user->email }}" class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-sm rounded-xl px-4 py-2 cursor-not-allowed shadow-sm" readonly>
 </div>
 <div>
 <label class="block text-slate-700 text-[11px] font-bold uppercase tracking-wide mb-1">NIK (Nomor Induk Kependudukan)</label>
 <input type="text" value="{{ $peminjam->nik ?? '' }}" class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-sm rounded-xl px-4 py-2 cursor-not-allowed shadow-sm" readonly>
 </div>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
 <div>
 <label class="block text-slate-700 text-[11px] font-bold uppercase tracking-wide mb-1">Penanggung Jawab</label>
 <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-sm rounded-xl px-4 py-2 cursor-not-allowed shadow-sm" readonly>
 </div>
 
 <div>
 <label class="block text-slate-700 text-[11px] font-bold uppercase tracking-wide mb-1">Nama Instansi/Organisasi</label>
 <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $peminjam->nama_instansi ?? '') }}" class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-sm rounded-xl px-4 py-2 cursor-not-allowed shadow-sm" readonly>
 </div>
 </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
 <div>
 <label class="block text-slate-700 text-[11px] font-bold uppercase tracking-wide mb-1">Jenis Peminjam</label>
 <input type="text" name="jenis_peminjam" value="{{ old('jenis_peminjam', $peminjam->jenis_peminjam ?? '') }}" class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-sm rounded-xl px-4 py-2 cursor-not-allowed shadow-sm" readonly>
 </div>
 <div>
 <label class="block text-slate-700 text-[11px] font-bold uppercase tracking-wide mb-1">Nomor WhatsApp</label>
 <input type="text" name="kontak_penanggung_jawab" value="{{ old('kontak_penanggung_jawab', $peminjam->kontak_penanggung_jawab ?? '') }}" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl px-4 py-2 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 shadow-sm" required>
 <p class="text-[10px] text-slate-500 mt-1 italic">* Ubah nomor jika nomor anda telah ganti serta pada lupa password mengikuti otp yang ada pada profil.</p>
 </div>
 </div>

 <div>
 <label class="block text-slate-700 text-[11px] font-bold uppercase tracking-wide mb-1">Alamat Peminjam</label>
 <textarea name="alamat" rows="2" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl px-4 py-2 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 shadow-sm" required>{{ old('alamat', $user->alamat ?? '') }}</textarea>
 <p class="text-[10px] text-slate-500 mt-1 italic">* Ubah alamat bila melakukan perpindahan alamat.</p>
 </div>
 </div>

 <div class="mt-4">
 <button type="submit" class="bg-[#064e3b] hover:bg-blue-800 text-white text-sm font-bold py-2.5 px-6 rounded-xl transition-colors shadow-md w-full md:w-auto">
 Simpan Perubahan
 </button>
 </div>
 </form>
 </div>
 </div>


</div>
@endsection
