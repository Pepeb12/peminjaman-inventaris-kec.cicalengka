@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Profil Saya</h2>
    <p class="text-sm text-slate-500 mt-1">Perbarui informasi profil Anda.</p>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-white">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Data Profil
        </h3>
    </div>
    
    <div class="p-6 flex-1">
        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl mb-4 text-sm font-medium border border-emerald-100 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 text-rose-600 px-4 py-3 rounded-xl mb-4 text-sm font-medium border border-rose-100">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('umpeg.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6 flex flex-col items-center sm:items-start gap-4">
                <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Foto Profil (Opsional)</label>
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-slate-100 shadow-md flex-shrink-0 bg-slate-200 flex items-center justify-center">
                        @if($user->foto_profil)
                            <img src="{{ asset('storage/' . $user->foto_profil) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-3xl font-bold text-slate-400">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div>
                        <input type="file" name="foto_profil" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 bg-white border border-slate-200 rounded-xl focus:outline-none transition-colors shadow-sm">
                        <p class="text-[10px] text-slate-500 mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 shadow-sm" required>
                </div>
                
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Alamat Email (Gmail)</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 shadow-sm" required>
                </div>

                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" class="w-full bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 shadow-sm">
                </div>

                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="w-full bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 shadow-sm">{{ old('alamat', $user->alamat) }}</textarea>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-[#064e3b] hover:bg-blue-800 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-md w-full md:w-auto">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
