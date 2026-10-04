@extends('layouts.app')

@section('content')
<div class="bg-white relative overflow-hidden flex flex-col min-h-full">
    <div class="p-6 sm:p-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="relative z-10 flex-1">
            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 uppercase tracking-tight">Manajemen Peminjam</h3>
            <p class="text-slate-700 font-medium text-sm mt-1 max-w-2xl leading-relaxed">
                Kelola akun dan instansi/organisasi yang terdaftar di sistem.
            </p>
        </div>
    </div>
 <div class="overflow-x-auto flex-1">
 <table class="w-full text-left text-xs text-slate-600">
 <thead class="bg-[#1e3a8a] text-xs uppercase text-white font-extrabold border-b-2 border-slate-300">
 <tr>
 <th class="px-3 py-3">Penanggung Jawab</th>
 <th class="px-3 py-3">Email</th>
 <th class="px-3 py-3">Alamat</th>
 <th class="px-3 py-3">Jenis Peminjam</th>
 <th class="px-3 py-3">Kontak (WA)</th>
 <th class="px-3 py-3">Total Pinjam</th>
 <th class="px-3 py-3 text-center">Aksi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-200">
 @forelse($peminjams as $peminjam)
 <tr class="hover:bg-white transition-colors">
 <td class="px-3 py-3">
 <div class="flex items-center gap-3">
 <div class="w-10 h-10 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center overflow-hidden shrink-0 shadow-sm cursor-pointer hover:opacity-90 transition-opacity" onclick="openImageModal(this.querySelector('img') ? this.querySelector('img').src : '', 'Foto {{ $peminjam->user->name ?? 'Pengguna' }}')">
 @if(isset($peminjam->user->foto_profil) && $peminjam->user->foto_profil)
 <img src="{{ asset('storage/' . $peminjam->user->foto_profil) }}" class="w-full h-full object-cover">
 @else
 <span class="text-xs font-bold text-slate-500">{{ substr($peminjam->user->name ?? 'U', 0, 1) }}</span>
 @endif
 </div>
 <div>
 <div class="font-medium text-slate-800">{{ $peminjam->user->name ?? '-' }}</div>
 <div class="text-[10px] text-black font-bold tracking-widest mt-0.5">NIK: {{ $peminjam->nik ?? '-' }}</div>
 @php $ktpUrl = $peminjam->foto_ktp ? asset('storage/' . $peminjam->foto_ktp) : (isset($peminjam->user->foto_profil) ? asset('storage/' . $peminjam->user->foto_profil) : null); @endphp
 @if($ktpUrl)
 <div class="mt-1"><button type="button" onclick="openImageModal('{{ $ktpUrl }}', 'KTP {{ $peminjam->user->name ?? 'Pengguna' }}')" class="text-[10px] font-bold text-blue-600 hover:text-blue-800 hover:underline">Lihat KTP</button></div>
 @endif
 </div>
 </div>
 </td>
 <td class="px-3 py-3">
 <div class="text-xs font-bold text-slate-900">{{ $peminjam->user->email ?? '-' }}</div>
 </td>
 <td class="px-3 py-3">
 <div class="text-xs text-black">{{ $peminjam->user->alamat ?? '-' }}</div>
 </td>
 <td class="px-3 py-3">
 <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-widest mb-1">{{ $peminjam->jenis_peminjam ?? '-' }}</div>
 <div class="font-bold text-slate-900 text-xs">{{ $peminjam->nama_instansi ?? 'Tidak Diketahui' }}</div>
 </td>
 <td class="px-3 py-3">
 <div class="text-xs font-medium text-black">{{ $peminjam->kontak_penanggung_jawab ?? '-' }}</div>
 </td>
 <td class="px-3 py-3">
 <div class="text-xl font-extrabold text-[#064e3b] leading-none">{{ $peminjam->peminjaman()->count() }}</div>
 <div class="text-[10px] text-slate-500 font-medium uppercase tracking-widest mb-2">Transaksi</div>
 <div class="text-[10px] font-extrabold text-slate-800">KODE: {{ $peminjam->kode_peminjam ?? '-' }}</div>
 @if($peminjam->status_akun === 'Menunggu')
     <span class="inline-flex items-center gap-1 w-fit px-1.5 py-0.5 mt-1 rounded bg-rose-100 text-rose-700 text-[9px] font-extrabold uppercase tracking-widest border border-rose-200 shadow-sm" title="Belum ditindak">
         <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
         Baru
     </span>
 @endif
 </td>
 <td class="px-3 py-3 text-center">
 <div class="flex flex-col gap-2 items-center">
 @if($peminjam->status_akun === 'Disetujui' || $peminjam->is_verified)
 <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-emerald-200 w-fit">Disetujui</span>
 <div class="flex gap-3 mt-1 items-center justify-center">
     <form action="{{ route('umpeg.peminjam.verify', $peminjam->id_peminjam) }}" method="POST">
         @csrf
         <button type="submit" onclick="confirmSubmit(event, 'Batalkan persetujuan untuk akun ini? Mereka tidak akan bisa login.')" class="text-[11px] font-medium text-amber-500 hover:text-amber-700 hover:underline">Batalkan</button>
     </form>
     <span class="text-slate-300 text-xs">|</span>
     <form action="{{ route('umpeg.peminjam.nonaktif', $peminjam->id_peminjam) }}" method="POST">
         @csrf
         <button type="submit" onclick="confirmSubmit(event, 'Nonaktifkan akun ini? Mereka tidak akan bisa login.')" class="text-[11px] font-medium text-slate-500 hover:text-slate-700 hover:underline">Nonaktifkan</button>
     </form>
 </div>
 @elseif($peminjam->status_akun === 'Nonaktif')
 <span class="px-3 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-slate-300 w-fit">Nonaktif</span>
 <form action="{{ route('umpeg.peminjam.verify', $peminjam->id_peminjam) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Aktifkan kembali akun ini? Mereka akan bisa login.')" class="mt-1 px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">Aktifkan</button>
 </form>
 @elseif($peminjam->status_akun === 'Ditolak')
 <span class="px-3 py-1 bg-rose-100 text-rose-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-rose-200 w-fit">Ditolak</span>
 <form action="{{ route('umpeg.peminjam.verify', $peminjam->id_peminjam) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Setujui akun ini? Mereka akan bisa login.')" class="mt-1 px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">Setujui</button>
 </form>
 @else
 <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-widest rounded-full border border-amber-200 w-fit">Menunggu</span>
 <div class="flex gap-2 mt-1">
 <form action="{{ route('umpeg.peminjam.verify', $peminjam->id_peminjam) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Setujui akun ini? Mereka akan bisa login.')" class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">Setujui</button>
 </form>
 <form action="{{ route('umpeg.peminjam.tolak', $peminjam->id_peminjam) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Tolak pendaftaran akun ini? Akun akan ditandai sebagai ditolak.')" class="px-4 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold rounded-lg shadow-sm transition-colors">Tolak</button>
 </form>
 </div>
 @endif
 <form action="{{ route('umpeg.peminjam.destroy', $peminjam->id_peminjam) }}" method="POST" class="mt-2 pt-2 border-t border-slate-100 w-full flex justify-center">
     @csrf
     @method('DELETE')
     <button type="submit" onclick="confirmSubmit(event, 'Yakin ingin menghapus akun ini secara permanen? Akun beserta profil pengguna ini akan terhapus secara permanen.')" class="text-[10px] font-bold text-rose-500 hover:text-rose-700 hover:underline flex items-center gap-1 transition-colors">
         <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
         Hapus
     </button>
 </form>
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="7" class="px-6 py-12 text-center text-slate-500 font-medium">Belum ada peminjam yang terdaftar.</td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 
 @if($peminjams->hasPages())
 <div class="p-4 border-t border-slate-200 bg-slate-50/50">
 {{ $peminjams->links('vendor.pagination.custom') }}
 </div>
 @endif
</div>
@endsection
