@extends('layouts.app')

@section('content')
<div class="bg-white border border-slate-200 shadow-sm p-6 sm:p-8 rounded-2xl relative overflow-hidden mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
 <div class="relative z-10">
 <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 uppercase tracking-tight">Kelola Data Peminjaman</h3>
 <p class="text-slate-700 font-medium text-sm mt-1 max-w-2xl leading-relaxed">
 Pantau, validasi, dan kelola sirkulasi inventaris secara real-time.
 </p>
 </div>
 <div class="relative z-10 shrink-0 flex gap-2">
 <a href="{{ route('umpeg.dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-300 transition-colors shadow-sm">
 Kembali
 </a>
 </div>
</div>

@if(session('success'))
 <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center gap-3">
 <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 <span class="font-semibold text-sm">{{ session('success') }}</span>
 </div>
@endif
@if(session('error'))
 <div class="bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center gap-3">
 <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 <span class="font-semibold text-sm">{{ session('error') }}</span>
 </div>
@endif

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
 <div class="overflow-x-auto">
 <table class="w-full text-left text-sm text-slate-600">
 <thead class="bg-slate-50/50 text-xs uppercase text-slate-500 font-bold border-b border-slate-200">
 <tr>
 <th scope="col" class="px-6 py-4">ID Transaksi</th>
 <th scope="col" class="px-6 py-4">Nama Peminjam</th>
 <th scope="col" class="px-6 py-4">Instansi</th>
 <th scope="col" class="px-6 py-4">Tanggal Pinjam</th>
 <th scope="col" class="px-6 py-4">Tanggal Kembali</th>
 <th scope="col" class="px-6 py-4">Surat Resmi</th>
 <th scope="col" class="px-6 py-4">Status</th>
 <th scope="col" class="px-6 py-4">Rincian Barang</th>
 <th scope="col" class="px-6 py-4 text-center">Aksi Validasi</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-slate-200">
 @forelse($peminjamans as $trx)
 <tr class="hover:bg-white transition-colors">
 <td class="px-6 py-4 font-bold text-slate-900">
 {{ $trx->id }}
 </td>
 <td class="px-6 py-4">
 <p class="font-medium text-slate-800">{{ $trx->peminjam->user->name ?? '-' }}</p>
 <p class="text-[11px] text-slate-500 font-bold tracking-wider mt-0.5">NIK: {{ $trx->peminjam->nik ?? '-' }}</p>
 </td>
 <td class="px-6 py-4">
 <p class="text-[11px] text-[#064e3b] font-bold uppercase tracking-wider mt-0.5">{{ $trx->peminjam?->nama_instansi ?? $trx->peminjam?->jenis_peminjam }}</p>
 </td>
 <td class="px-6 py-4">
 <p class="text-slate-800 font-medium">{{ strtolower(\Carbon\Carbon::parse($trx->tgl_pinjam)->translatedFormat('l j F Y H:i')) }}</p>
 </td>
 <td class="px-6 py-4">
 <p class="text-slate-800 font-medium">{{ strtolower(\Carbon\Carbon::parse($trx->tgl_kembali)->translatedFormat('l j F Y H:i')) }}</p>
 </td>
 <td class="px-6 py-4">
 @if($trx->surat_resmi)
 <a href="{{ asset('storage/' . $trx->surat_resmi) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 hover:underline font-bold text-xs flex items-center gap-1">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
 Lihat PDF
 </a>
 @else
 <span class="text-slate-400 text-xs italic">Tidak ada surat</span>
 @endif
 </td>
 <td class="px-6 py-4">
 @if($trx->status == 'Menunggu Proses')
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-widest border border-amber-200 shadow-sm">
 <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
 </span>
 @elseif($trx->status == 'Menunggu Cetak Bukti')
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-widest border border-rose-200 shadow-sm whitespace-nowrap">
 <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Menunggu Cetak Bukti
 </span>
 @elseif($trx->status == 'Dipinjam')
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700 uppercase tracking-widest border border-indigo-200 shadow-sm">
 <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Dipinjam
 </span>
 @elseif($trx->status == 'Selesai')
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-widest border border-emerald-200 shadow-sm">
 <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
 </span>
 @else
 <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-widest border border-rose-200 shadow-sm">
 <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
 </span>
 @endif
 </td>
 <td class="px-6 py-4">
 <ul class="list-disc list-inside text-slate-600 text-xs space-y-1">
 @foreach($trx->detailPeminjaman as $detail)
 <li>{{ $detail->barang->nama_barang ?? 'Barang Terhapus' }} <span class="font-bold text-slate-800">({{ $detail->jumlah }}x)</span></li>
 @endforeach
 </ul>
 </td>
 <td class="px-6 py-4 text-center">
 <div class="flex justify-center gap-2">
 @if($trx->status == 'Menunggu Proses')
 <form action="{{ route('umpeg.peminjaman.acc', $trx->id) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'ACC pengajuan ini?')" class="p-2 text-emerald-700 bg-emerald-100 border border-emerald-200 rounded-lg hover:bg-emerald-200 transition-colors shadow-sm" title="Setujui">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
 </button>
 </form>
 <form action="{{ route('umpeg.peminjaman.tolak', $trx->id) }}" method="POST" id="form_tolak_{{ $trx->id }}">
 @csrf
 <input type="hidden" name="pesan_tolak" id="input_tolak_{{ $trx->id }}">
 <button type="button" onclick="tolakDenganCatatan('{{ $trx->id }}')" class="p-2 text-rose-700 bg-rose-100 border border-rose-200 rounded-lg hover:bg-rose-200 transition-colors shadow-sm" title="Tolak">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
 </button>
 </form>
 @elseif($trx->status == 'Menunggu Cetak Bukti')
 <form action="{{ route('umpeg.peminjaman.serahkan', $trx->id) }}" method="POST">
 @csrf
 <button type="submit" onclick="confirmSubmit(event, 'Serahkan barang kepada peminjam? (Pastikan bukti sudah dicetak & diserahkan)')" class="flex items-center gap-1.5 px-3 py-1.5 text-sky-700 bg-sky-100 border border-sky-200 rounded-lg hover:bg-sky-200 transition-colors font-bold text-xs shadow-sm" title="Serahkan Barang">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
 Serahkan
 </button>
 </form>
 @elseif($trx->status == 'Dipinjam')
 <form action="{{ route('umpeg.peminjaman.terima', $trx->id) }}" method="POST" id="form_terima_{{ $trx->id }}">
 @csrf
 <input type="hidden" name="catatan_kembali" id="input_terima_{{ $trx->id }}">
 <button type="button" onclick="terimaDenganCatatan('{{ $trx->id }}')" class="flex items-center gap-1.5 px-3 py-1.5 text-indigo-700 bg-indigo-100 border border-indigo-200 rounded-lg hover:bg-indigo-200 transition-colors font-bold text-xs shadow-sm">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
 Terima
 </button>
 </form>
 @else
 <span class="text-slate-400 text-xs italic font-medium">Selesai</span>
 @endif
 </div>
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="9" class="px-6 py-12 text-center text-slate-500 font-medium">
 <div class="flex flex-col items-center justify-center">
 <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
 Belum ada riwayat transaksi yang tercatat.
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>

<script>
 function tolakDenganCatatan(id) {
 Swal.fire({
 title: 'Tolak Peminjaman',
 text: 'Masukkan alasan penolakan (Wajib):',
 input: 'textarea',
 inputPlaceholder: 'Alasan penolakan...',
 icon: 'warning',
 showCancelButton: true,
 confirmButtonColor: '#e11d48',
 cancelButtonColor: '#64748b',
 confirmButtonText: 'Tolak Pengajuan',
 cancelButtonText: 'Batal',
 customClass: {
 popup: 'rounded-2xl shadow-xl border border-slate-200',
 confirmButton: 'rounded-xl font-bold px-6 py-2 bg-rose-600 text-white hover:bg-rose-700 transition-colors',
 cancelButton: 'rounded-xl font-bold px-6 py-2 bg-slate-500 text-white hover:bg-slate-600 transition-colors',
 actions: 'gap-3',
 input: 'rounded-xl border-slate-200 focus:ring-rose-500 focus:border-rose-500'
 },
 buttonsStyling: false,
 inputValidator: (value) => {
 if (!value || value.trim() === '') {
 return 'Alasan penolakan tidak boleh kosong!';
 }
 }
 }).then((result) => {
 if (result.isConfirmed) {
 document.getElementById('input_tolak_' + id).value = result.value;
 document.getElementById('form_tolak_' + id).submit();
 }
 });
 }

 function terimaDenganCatatan(id) {
 Swal.fire({
 title: 'Terima Pengembalian',
 text: 'Masukkan catatan pengembalian (Opsional, cth: 1 kursi rusak):',
 input: 'textarea',
 inputPlaceholder: 'Catatan pengembalian...',
 icon: 'info',
 showCancelButton: true,
 confirmButtonColor: '#1e3a8a',
 cancelButtonColor: '#64748b',
 confirmButtonText: 'Terima Barang',
 cancelButtonText: 'Batal',
 customClass: {
 popup: 'rounded-2xl shadow-xl border border-slate-200',
 confirmButton: 'rounded-xl font-bold px-6 py-2 bg-[#1e3a8a] text-white hover:bg-blue-800 transition-colors',
 cancelButton: 'rounded-xl font-bold px-6 py-2 bg-slate-500 text-white hover:bg-slate-600 transition-colors',
 actions: 'gap-3',
 input: 'rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500'
 },
 buttonsStyling: false
 }).then((result) => {
 if (result.isConfirmed) {
 document.getElementById('input_terima_' + id).value = result.value || '';
 document.getElementById('form_terima_' + id).submit();
 }
 });
 }
</script>
@endsection