@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
 <div>
 <h2 class="text-2xl font-extrabold text-slate-800 uppercase tracking-tight">Manajemen Peminjam</h2>
 <p class="text-sm text-slate-500 mt-1">Kelola akun dan instansi/organisasi yang terdaftar di sistem.</p>
 </div>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
 <div class="overflow-x-auto flex-1">
 <table class="w-full text-left text-sm text-slate-600">
 <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 font-bold border-b border-slate-200">
 <tr>
 <th class="px-6 py-4">ID</th>
 <th class="px-6 py-4">Nama Instansi</th>
 <th class="px-6 py-4">Penanggung Jawab</th>
 <th class="px-6 py-4">Email</th>
 <th class="px-6 py-4">Jenis Peminjam</th>
 <th class="px-6 py-4">Kontak (WA)</th>
 <th class="px-6 py-4">Total Pinjam</th>
 <th class="px-6 py-4">Status & Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-200">
 @forelse($peminjams as $peminjam)
 <tr class="hover:bg-white transition-colors">
 <td class="px-6 py-4">
 <div class="text-xs text-slate-500 font-medium">{{ $peminjam->id }}</div>
 </td>
 <td class="px-6 py-4">
 <div class="font-bold text-slate-900">{{ $peminjam->nama_instansi ?? 'Tidak Diketahui' }}</div>
 </td>
 <td class="px-6 py-4">
 <div class="font-medium text-slate-800">{{ $peminjam->user->name ?? '-' }}</div>
 <div class="text-[10px] text-slate-500 font-bold tracking-widest mt-0.5">NIK: {{ $peminjam->nik ?? '-' }}</div>
 </td>
 <td class="px-6 py-4">
 <div class="text-sm font-bold text-slate-900">{{ $peminjam->user->email ?? '-' }}</div>
 </td>
 <td class="px-6 py-4">
 <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $peminjam->jenis_peminjam ?? '-' }}</div>
 </td>
 <td class="px-6 py-4">
 <div class="text-xs font-medium text-slate-600">{{ $peminjam->kontak_penanggung_jawab ?? '-' }}</div>
 </td>
 <td class="px-6 py-4">
 <div class="text-xl font-extrabold text-[#064e3b]">{{ $peminjam->peminjaman()->count() }}</div>
 <div class="text-[10px] text-slate-500 font-medium uppercase tracking-widest">Transaksi</div>
 </td>
 <td class="px-6 py-4 text-center">
 <div class="flex flex-col gap-2 items-center">
 @if($peminjam->status_akun === 'Disetujui' || $peminjam->is_verified)
 <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-emerald-200 w-fit">Disetujui</span>
 <form action="{{ route('umpeg.peminjam.verify', $peminjam->id) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Batalkan persetujuan untuk akun ini? Mereka tidak akan bisa login.')" class="text-xs font-medium text-rose-500 hover:text-rose-700 hover:underline">Batalkan</button>
 </form>
 @elseif($peminjam->status_akun === 'Ditolak')
 <span class="px-3 py-1 bg-rose-100 text-rose-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-rose-200 w-fit">Ditolak</span>
 <form action="{{ route('umpeg.peminjam.verify', $peminjam->id) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Setujui akun ini? Mereka akan bisa login.')" class="mt-1 px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">Setujui</button>
 </form>
 @else
 <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-amber-200 w-fit">Menunggu</span>
 <div class="flex gap-2 mt-1">
 <form action="{{ route('umpeg.peminjam.verify', $peminjam->id) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Setujui akun ini? Mereka akan bisa login.')" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">Setujui</button>
 </form>
 <form action="{{ route('umpeg.peminjam.tolak', $peminjam->id) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Tolak pendaftaran akun ini? Akun akan ditandai sebagai ditolak.')" class="px-4 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">Tolak</button>
 </form>
 </div>
 @endif
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="8" class="px-6 py-12 text-center text-slate-500 font-medium">Belum ada peminjam yang terdaftar.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>
@endsection
