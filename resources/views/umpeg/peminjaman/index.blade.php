@extends('layouts.app')

@section('content')
    @if(session('success'))
        <div
            class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div
            class="bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-semibold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white relative overflow-hidden flex flex-col min-h-full">
        <div class="p-6 sm:p-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative z-10 flex-1">
                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 uppercase tracking-tight">Kelola Data
                    Peminjaman</h3>
                <p class="text-slate-600 font-medium text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                    Pantau, validasi, dan kelola sirkulasi inventaris secara real-time
                </p>
            </div>
            <div
                class="relative z-10 shrink-0 flex items-center gap-3 w-full sm:w-auto justify-start sm:justify-end mt-4 sm:mt-0">

                <div id="realtime-clock"
                    class="text-base font-extrabold text-black bg-white border-2 border-slate-300 px-4 py-2 rounded-xl shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span id="clock-display" class="tracking-widest">Memuat...</span>
                </div>
                <a href="{{ route('umpeg.dashboard') }}"
                    class="inline-flex items-center justify-center gap-2 bg-slate-100 text-slate-700 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors shadow-sm flex-1 sm:flex-none">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Filter / Search -->
        <div class="p-4 sm:px-6 bg-slate-50/50 border-b border-slate-200">
            <form action="{{ route('umpeg.peminjaman.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 w-full">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam atau instansi..." class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent transition-all shadow-sm">
                    <div class="absolute left-4 top-3 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                
                <select name="kategori" class="w-full md:w-1/4 px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1e3a8a] focus:border-transparent transition-all shadow-sm font-medium" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <option value="Perangkat Desa" {{ request('kategori') == 'Perangkat Desa' ? 'selected' : '' }}>Perangkat Desa</option>
                    <option value="Masyarakat" {{ request('kategori') == 'Masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                    <option value="Instansi Lain" {{ request('kategori') == 'Instansi Lain' ? 'selected' : '' }}>Instansi Lain</option>
                </select>

                @if(request('search') || request('kategori'))
                <a href="{{ route('umpeg.peminjaman.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-sm font-bold hover:bg-rose-100 transition-colors w-full md:w-auto" title="Reset Filter">
                    <svg class="w-5 h-5 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span class="md:hidden lg:inline">Reset</span>
                </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-[#1e3a8a] text-xs uppercase text-white font-extrabold border-b-2 border-slate-300">
                    <tr>
                        <th scope="col" class="px-3 py-3">ID Transaksi</th>
                        <th scope="col" class="px-3 py-3">Nama Peminjam</th>
                        <th scope="col" class="px-3 py-3">Instansi</th>
                        <th scope="col" class="px-3 py-3">Tanggal Pinjam</th>
                        <th scope="col" class="px-3 py-3">Tanggal Kembali</th>
                        <th scope="col" class="px-3 py-3">Surat Resmi</th>
                        <th scope="col" class="px-3 py-3">Status</th>
                        <th scope="col" class="px-3 py-3 w-40">Rincian Barang</th>
                        <th scope="col" class="px-3 py-3 text-center">Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($peminjamans as $trx)
                        <tr class="hover:bg-white transition-colors">
                            <td class="px-3 py-3 font-bold text-slate-900">
                                {{ $trx->id }}
                            </td>
                            <td class="px-3 py-3">
                                <button onclick="openContactModal('{{ $trx->peminjam->id }}')" class="font-medium text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1.5 transition-colors text-left" title="Hubungi Peminjam">
                                    {{ $trx->peminjam->user->name ?? '-' }}
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </button>
                                <p class="text-[11px] text-slate-500 font-bold tracking-wider mt-0.5">KODE: {{ $trx->peminjam->kode_peminjam ?? '-' }}</p>
                                <p class="text-[11px] text-slate-500 font-bold tracking-wider">NIK:
                                    {{ $trx->peminjam->nik ?? '-' }}</p>
                            </td>
                            <td class="px-3 py-3">
                                <p class="text-[11px] text-[#064e3b] font-bold uppercase tracking-wider mt-0.5">
                                    {{ $trx->peminjam?->nama_instansi ?? $trx->peminjam?->jenis_peminjam }}</p>
                            </td>
                            <td class="px-3 py-3">
                                <p class="text-slate-800 font-medium">
                                    {{ strtolower(\Carbon\Carbon::parse($trx->tgl_pinjam)->translatedFormat('l j F Y H:i')) }}
                                </p>
                            </td>
                            <td class="px-3 py-3">
                                <p class="text-slate-800 font-medium">
                                    {{ strtolower(\Carbon\Carbon::parse($trx->tgl_kembali)->translatedFormat('l j F Y H:i')) }}
                                </p>
                            </td>
                            <td class="px-3 py-3">
                                @if($trx->surat_resmi)
                                    <a href="{{ asset('storage/' . $trx->surat_resmi) }}" target="_blank"
                                        class="text-emerald-600 hover:text-emerald-800 hover:underline font-bold text-xs flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                        Lihat PDF
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs italic">Tidak ada surat</span>
                                @endif
                            </td>
                            <td class="px-3 py-3">
                                @if($trx->status == 'Menunggu Proses')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase tracking-widest border border-amber-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
                                    </span>
                                @elseif($trx->status == 'Menunggu Cetak Bukti')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-widest border border-rose-200 shadow-sm whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Menunggu Cetak Bukti
                                    </span>
                                @elseif($trx->status == 'Dipinjam')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700 uppercase tracking-widest border border-indigo-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Dipinjam
                                    </span>
                                @elseif($trx->status == 'Selesai')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase tracking-widest border border-emerald-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-700 uppercase tracking-widest border border-rose-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-3">
                                <button type="button" onclick="document.getElementById('modal-rincian-{{$trx->id}}').classList.remove('hidden')" class="text-[10px] text-white bg-blue-600 hover:bg-blue-700 px-3 py-2 rounded-lg font-bold transition-colors w-full text-center shadow-sm">
                                    Lihat Detail
                                </button>

                                <!-- Modal Rincian -->
                                <div id="modal-rincian-{{$trx->id}}" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
                                    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh]">
                                        <div class="p-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                                            <h3 class="font-bold text-slate-800">Rincian Barang (TRX-{{$trx->id}})</h3>
                                            <button type="button" onclick="document.getElementById('modal-rincian-{{$trx->id}}').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 p-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        <div class="p-6 overflow-y-auto">
                                            <ul class="space-y-4">
                                                @foreach($trx->detailPeminjaman as $detail)
                                                    <li class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                                                        <div class="flex items-start justify-between gap-4">
                                                            <div>
                                                                <h4 class="font-bold text-slate-800 text-sm">{{ $detail->barang->nama_barang ?? 'Barang Terhapus' }}</h4>
                                                                @if(isset($detail->barang->deskripsi) && !empty($detail->barang->deskripsi))
                                                                    <p class="text-xs text-slate-500 mt-1 italic">{{ $detail->barang->deskripsi }}</p>
                                                                @endif
                                                            </div>
                                                            <span class="font-extrabold text-slate-700 bg-slate-100 px-2 py-1 rounded text-xs">{{ $detail->jumlah }}x</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="p-4 border-t border-slate-200 bg-slate-50 text-right">
                                            <button type="button" onclick="document.getElementById('modal-rincian-{{$trx->id}}').classList.add('hidden')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 text-sm font-bold rounded-xl transition-colors">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    @if($trx->status == 'Menunggu Proses')
                                        <form action="{{ route('umpeg.peminjaman.acc', $trx->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="confirmSubmit(event, 'ACC pengajuan ini?')"
                                                class="p-2 text-emerald-700 bg-emerald-100 border border-emerald-200 rounded-lg hover:bg-emerald-200 transition-colors shadow-sm"
                                                title="Setujui">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('umpeg.peminjaman.tolak', $trx->id) }}" method="POST"
                                            id="form_tolak_{{ $trx->id }}">
                                            @csrf
                                            <input type="hidden" name="pesan_tolak" id="input_tolak_{{ $trx->id }}">
                                            <button type="button" onclick="tolakDenganCatatan('{{ $trx->id }}')"
                                                class="p-2 text-rose-700 bg-rose-100 border border-rose-200 rounded-lg hover:bg-rose-200 transition-colors shadow-sm"
                                                title="Tolak">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @elseif($trx->status == 'Menunggu Cetak Bukti')
                                        <form action="{{ route('umpeg.peminjaman.serahkan', $trx->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                onclick="confirmSubmit(event, 'Serahkan barang kepada peminjam? (Pastikan bukti sudah dicetak & diserahkan)')"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-sky-700 bg-sky-100 border border-sky-200 rounded-lg hover:bg-sky-200 transition-colors font-bold text-xs shadow-sm"
                                                title="Serahkan Barang">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Serahkan
                                            </button>
                                        </form>
                                    @elseif($trx->status == 'Dipinjam')
                                        <form action="{{ route('umpeg.peminjaman.terima', $trx->id) }}" method="POST"
                                            id="form_terima_{{ $trx->id }}">
                                            @csrf
                                            <input type="hidden" name="catatan_kembali" id="input_terima_{{ $trx->id }}">
                                            <button type="button" onclick="terimaDenganCatatan('{{ $trx->id }}')"
                                                class="flex items-center gap-1.5 px-3 py-1.5 text-indigo-700 bg-indigo-100 border border-indigo-200 rounded-lg hover:bg-indigo-200 transition-colors font-bold text-xs shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                    </path>
                                                </svg>
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
                                    <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    Belum ada riwayat transaksi yang tercatat.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($peminjamans->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                {{ $peminjamans->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>

    <!-- Modal Hubungi Peminjam -->
    <div id="contactModal"
        class="fixed inset-0 z-[100] hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl relative border border-slate-200"
            onclick="event.stopPropagation()">
            <button onclick="closeContactModal()"
                class="absolute top-4 right-4 text-slate-400 hover:text-rose-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h3 class="text-xl font-extrabold text-[#1e3a8a] mb-6 flex items-center gap-2 uppercase tracking-wide">
                <svg class="w-6 h-6 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z">
                    </path>
                </svg>
                Hubungi Peminjam
            </h3>

            <div class="space-y-4">
                <div class="hidden">
                    <label class="block text-sm font-bold text-slate-700 mb-1">Pilih Peminjam</label>
                    <select id="contactPeminjam"
                        class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="" disabled selected>-- Pilih Peminjam --</option>
                        @foreach($semuaPeminjam as $p)
                            <option value="{{ $p->id }}" data-wa="{{ $p->kontak_penanggung_jawab }}"
                                data-email="{{ $p->user->email ?? '' }}">
                                {{ $p->user->name ?? 'Unknown' }} ({{ $p->nama_instansi ?? $p->jenis_peminjam }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Media Kontak</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="contactMedia" value="wa" class="peer hidden" checked>
                            <div
                                class="border-2 border-slate-200 rounded-xl px-4 py-2.5 text-center peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 font-bold text-sm transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                WhatsApp
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="contactMedia" value="email" class="peer hidden">
                            <div
                                class="border-2 border-slate-200 rounded-xl px-4 py-2.5 text-center peer-checked:bg-rose-50 peer-checked:border-rose-500 peer-checked:text-rose-700 font-bold text-sm transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Gmail
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Template Pesan Resmi</label>
                    <select id="contactTemplate"
                        class="w-full border border-slate-300 rounded-xl px-4 py-2.5 text-sm font-medium focus:ring-[#1e3a8a] focus:border-[#1e3a8a]">
                        <option value="1">Peringatan: Belum Mengembalikan Barang</option>
                        <option value="2">Pemberitahuan: Batas Waktu Akan Habis</option>
                        <option value="3">Pemberitahuan: Pengajuan Disetujui</option>
                        <option value="4">Lainnya (Hanya kirim pesan tambahan)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Pesan Tambahan (Opsional) / Ketik
                        Sendiri</label>
                    <textarea id="contactCustomMessage" rows="3"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-[#1e3a8a] focus:border-[#1e3a8a] placeholder-slate-400"
                        placeholder="Ketik pesan khusus Anda di sini..."></textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeContactModal()"
                    class="px-5 py-2.5 rounded-xl text-slate-600 font-bold text-sm hover:bg-slate-100 transition-colors">Batal</button>
                <button type="button" onclick="sendContactMessage()"
                    class="px-6 py-2.5 rounded-xl bg-[#1e3a8a] text-white font-bold text-sm hover:bg-blue-900 transition-colors shadow-md flex items-center gap-2">
                    Kirim Pesan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
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
    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock-display').innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
        }
        setInterval(updateClock, 1000);
        updateClock();

        function openContactModal(peminjamId = null) {
            document.getElementById('contactModal').classList.remove('hidden');
            if (peminjamId) {
                document.getElementById('contactPeminjam').value = peminjamId;
            }
        }

        function closeContactModal() {
            document.getElementById('contactModal').classList.add('hidden');
            document.getElementById('contactPeminjam').selectedIndex = 0;
            document.getElementById('contactCustomMessage').value = '';
        }

        document.getElementById('contactModal').addEventListener('click', function (e) {
            if (e.target === this) closeContactModal();
        });

        function sendContactMessage() {
            const select = document.getElementById('contactPeminjam');
            if (select.selectedIndex === 0) {
                Swal.fire('Peringatan', 'Silakan pilih peminjam terlebih dahulu!', 'warning');
                return;
            }

            const option = select.options[select.selectedIndex];
            let wa = option.getAttribute('data-wa');
            const email = option.getAttribute('data-email');

            const media = document.querySelector('input[name="contactMedia"]:checked').value;
            const template = document.getElementById('contactTemplate').value;
            const custom = document.getElementById('contactCustomMessage').value;

            let baseMessage = "";
            if (template === "1") {
                baseMessage = "Yth. Saudara/i Peminjam,\n\nIni adalah peringatan resmi dari Kecamatan Cicalengka. Saudara/i belum mengembalikan barang inventaris sesuai dengan tanggal yang telah disepakati. Harap segera mengembalikan barang tersebut ke kantor Kecamatan Cicalengka untuk menghindari teguran lebih lanjut. Terima kasih.";
            } else if (template === "2") {
                baseMessage = "Yth. Saudara/i Peminjam,\n\nIni adalah pemberitahuan dari Kecamatan Cicalengka. Batas waktu peminjaman barang inventaris Saudara/i akan segera habis. Mohon persiapkan pengembalian barang tersebut agar tepat waktu sesuai jadwal. Terima kasih.";
            } else if (template === "3") {
                baseMessage = "Yth. Saudara/i Peminjam,\n\nPemberitahuan dari Kecamatan Cicalengka: Pengajuan peminjaman barang Saudara/i telah disetujui. Silakan mengambil barang di kantor Kecamatan Cicalengka. Terima kasih.";
            }

            let finalMessage = baseMessage;
            if (custom.trim() !== "") {
                if (finalMessage !== "") finalMessage += "\n\nCatatan Tambahan Admin:\n";
                finalMessage += custom;
            }

            if (!finalMessage.trim()) {
                Swal.fire('Peringatan', 'Pesan tidak boleh kosong!', 'warning');
                return;
            }

            if (media === 'wa') {
                if (!wa) {
                    Swal.fire('Gagal', 'Nomor WhatsApp peminjam ini tidak ditemukan/tidak valid!', 'error');
                    return;
                }
                wa = wa.replace(/[^0-9]/g, '');
                if (wa.startsWith('0')) wa = '62' + wa.substring(1);

                const url = `https://wa.me/${wa}?text=${encodeURIComponent(finalMessage)}`;
                window.open(url, '_blank');
            } else if (media === 'email') {
                if (!email) {
                    Swal.fire('Gagal', 'Alamat Email peminjam ini tidak ditemukan!', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Pratinjau Email Resmi',
                    html: `
                      <div class="text-left bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-inner mt-2">
                          <div class="mb-4 border-b border-slate-200 pb-3">
                              <p class="text-sm font-bold text-slate-700 mb-1">Penerima: <span class="font-medium text-blue-700 bg-blue-100 px-2 py-0.5 rounded">${email}</span></p>
                              <p class="text-sm font-bold text-slate-700">Subjek: <span class="font-medium text-slate-800">Pemberitahuan Resmi Inventaris Kecamatan Cicalengka</span></p>
                          </div>
                          <div class="text-sm text-slate-800 whitespace-pre-wrap leading-relaxed">${finalMessage}</div>
                          <div class="mt-4 pt-3 border-t border-slate-200 text-xs text-slate-500 italic">
                              *Pesan ini akan dikirim menggunakan desain template surat resmi HTML Kecamatan Cicalengka.
                          </div>
                      </div>
                  `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#1e3a8a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Kirim Email Sekarang',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl shadow-2xl',
                        confirmButton: 'rounded-xl font-bold px-5 py-2.5',
                        cancelButton: 'rounded-xl font-bold px-5 py-2.5',
                        htmlContainer: 'mx-1'
                    },
                    width: '600px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Mengirim Email...',
                            text: 'Mohon tunggu sebentar...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        fetch("{{ route('umpeg.peminjaman.sendEmail') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                email: email,
                                pesan: finalMessage
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Berhasil!', 'Email resmi telah terkirim ke ' + email, 'success');
                                } else {
                                    Swal.fire('Gagal!', data.message || 'Gagal mengirim email.', 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Gagal!', 'Terjadi kesalahan sistem saat menghubungi server email.', 'error');
                            });
                    }
                });
            }

            closeContactModal();
        }
    </script>
@endsection
