@extends('layouts.app')

@section('content')
<!-- Flatpickr CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

@if(session('success'))
 <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center gap-3">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 <span class="font-semibold text-sm">{{ session('success') }}</span>
 </div>
@endif

@if(session('error') || $errors->any())
 <div class="bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3 rounded-xl mb-6 shadow-sm flex flex-col gap-1">
 <div class="flex items-center gap-3">
 <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 <span class="font-semibold text-sm">{{ session('error') ?? 'Terdapat kesalahan pada input Anda.' }}</span>
 </div>
 @if($errors->any())
 <ul class="list-disc list-inside text-xs font-medium mt-1 ml-8">
 @foreach($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 @endif
 </div>
@endif

<div class="bg-white min-h-full relative overflow-hidden flex flex-col">
    <div class="p-5 sm:p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="relative z-10 flex-1">
            <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 uppercase tracking-tight">Formulir Pengajuan Peminjaman</h3>
            <p class="text-slate-600 font-medium text-xs sm:text-sm mt-1 max-w-2xl leading-relaxed">
                Silakan isi detail peminjaman dan pilih barang yang ingin dipinjam.
            </p>
        </div>
        <div class="relative z-10 shrink-0 flex gap-2 w-full sm:w-auto justify-start sm:justify-end mt-4 sm:mt-0">
            <a href="{{ route('peminjam.dashboard') }}" class="inline-flex items-center justify-center gap-2 bg-slate-100 text-slate-700 px-4 py-2 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors shadow-sm flex-1 sm:flex-none">
                Kembali
            </a>
        </div>
    </div>

 <div class="p-5 sm:p-6">
 <form action="{{ route('peminjam.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
 @csrf
 
 <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
 
 <!-- Pinjam -->
 <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
 <div>
 <label class="block text-slate-800 text-sm font-bold mb-1.5 tracking-wide">Tanggal Pinjam</label>
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
 <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
 </div>
 <input type="text" name="tgl_pinjam_date" id="tgl_pinjam_date" value="{{ old('tgl_pinjam_date') }}" class="block w-full pl-11 pr-3 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm" placeholder="dd/mm/yyyy" autocomplete="off" required>
 </div>
 </div>
 <div>
 <label class="block text-slate-800 text-sm font-bold mb-1.5 tracking-wide">Jam Pinjam</label>
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
 <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 </div>
 <input type="text" name="tgl_pinjam_time" id="tgl_pinjam_time" value="{{ old('tgl_pinjam_time') }}" class="block w-full pl-11 pr-3 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm" placeholder="HH:mm" autocomplete="off" required>
 </div>
 </div>
 </div>

 <!-- Kembali -->
 <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
 <div>
 <label class="block text-slate-800 text-sm font-bold mb-1.5 tracking-wide">Tanggal Kembali</label>
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
 <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
 </div>
 <input type="text" name="tgl_kembali_date" id="tgl_kembali_date" value="{{ old('tgl_kembali_date') }}" class="block w-full pl-11 pr-3 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm" placeholder="dd/mm/yyyy" autocomplete="off" required>
 </div>
 </div>
 <div>
 <label class="block text-slate-800 text-sm font-bold mb-1.5 tracking-wide">Jam Kembali</label>
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
 <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 </div>
 <input type="text" name="tgl_kembali_time" id="tgl_kembali_time" value="{{ old('tgl_kembali_time') }}" class="block w-full pl-11 pr-3 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm" placeholder="HH:mm" autocomplete="off" required>
 </div>
 </div>
 </div>
 </div>

 <div class="mb-5">
 <label class="block text-slate-800 text-sm font-bold mb-1.5 tracking-wide">Upload Surat Resmi Peminjaman (PDF) - <span class="font-normal italic text-slate-500">Opsional</span></label>
 <div class="relative">
 <input type="file" name="surat_resmi" accept=".pdf" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-emerald-200 rounded-xl bg-white shadow-sm">
 </div>
 </div>

 <div class="relative flex items-center py-2 mb-4">
 <div class="flex-grow border-t border-emerald-200"></div>
 <span class="flex-shrink-0 mx-4 text-[#064e3b] text-xs font-extrabold uppercase tracking-widest">Daftar Barang</span>
 <div class="flex-grow border-t border-emerald-200"></div>
 </div>
 
 <div id="dynamic-item-container" class="space-y-3 mb-3">
 <div class="flex flex-col sm:flex-row gap-3 item-row">
 <div class="w-full sm:w-1/3">
 <div class="relative">
 <select class="kategori-select block w-full pl-4 pr-10 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm appearance-none">
 <option value="">-- Semua Kategori --</option>
 @foreach($kategoris as $kat)
 <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
 @endforeach
 </select>
 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
 </div>
 </div>
 </div>
 <div class="flex-1">
 <div class="relative">
 <select name="kode_barang[]" class="barang-select block w-full pl-4 pr-10 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm appearance-none" required>
 <option value="">-- Pilih Barang --</option>
 @foreach($barangs as $brg)
 <option value="{{ $brg->kode_barang }}" data-kategori="{{ $brg->kategori_id }}" data-stok="{{ $brg->stok_tersedia }}" style="display: none;" disabled>
 {{ $brg->nama_barang }} (Sisa: {{ $brg->stok_tersedia }})
 </option>
 @endforeach
 </select>
 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
 </div>
 </div>
 </div>
 <div class="w-full sm:w-32">
 <input type="number" name="jumlah[]" class="block w-full px-4 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm" placeholder="Jumlah" min="1" required>
 </div>
 <div class="w-full sm:w-auto">
 <button type="button" class="w-full sm:w-12 h-full py-2 sm:py-0 flex items-center justify-center bg-rose-100 text-rose-600 rounded-xl hover:bg-rose-200 transition-colors shadow-sm disabled:opacity-50" onclick="hapusBarang(this)" disabled>
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
 </button>
 </div>
 </div>
 </div>

 <button type="button" class="inline-flex items-center justify-center gap-2 bg-emerald-100 text-emerald-700 px-3 py-2 rounded-xl font-bold text-xs hover:bg-emerald-200 transition-colors mb-5 border border-emerald-200 shadow-sm" onclick="tambahBarang()">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
 Tambah Barang Lain
 </button>

 <div class="pt-4 border-t border-slate-200">
 <button type="submit" class="w-full sm:w-auto bg-[#064e3b] hover:bg-[#152c6b] text-white font-bold py-2.5 px-6 rounded-xl transition-colors tracking-wider shadow-md flex items-center justify-center gap-2 text-sm">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
 KIRIM PENGAJUAN
 </button>
    </div>
    </form>
 </div>
</div>

 <script>
 function tambahBarang() {
 const container = document.getElementById('dynamic-item-container');
 const row = document.createElement('div');
 row.className = 'flex flex-col sm:flex-row gap-3 item-row mt-3';
 
 row.innerHTML = `
 <div class="w-full sm:w-1/3">
 <div class="relative">
 <select class="kategori-select block w-full pl-4 pr-10 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm appearance-none">
 <option value="">-- Semua Kategori --</option>
 @foreach($kategoris as $kat)
 <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
 @endforeach
 </select>
 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
 </div>
 </div>
 </div>
 <div class="flex-1">
 <div class="relative">
 <select name="kode_barang[]" class="barang-select block w-full pl-4 pr-10 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm appearance-none" required>
 <option value="">-- Pilih Barang --</option>
 @foreach($barangs as $brg)
 <option value="{{ $brg->kode_barang }}" data-kategori="{{ $brg->kategori_id }}" data-stok="{{ $brg->stok_tersedia }}" style="display: none;" disabled>
 {{ $brg->nama_barang }} (Sisa: {{ $brg->stok_tersedia }})
 </option>
 @endforeach
 </select>
 <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
 <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
 </div>
 </div>
 </div>
 <div class="w-full sm:w-32">
 <input type="number" name="jumlah[]" class="block w-full px-4 py-2 bg-white border border-emerald-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-[#064e3b] focus:ring-1 focus:ring-[#064e3b] transition-colors text-sm shadow-sm" placeholder="Jumlah" min="1" required>
 </div>
 <div class="w-full sm:w-auto">
 <button type="button" class="w-full sm:w-12 h-full py-2 sm:py-0 flex items-center justify-center bg-rose-100 text-rose-600 rounded-xl hover:bg-rose-200 transition-colors shadow-sm" onclick="hapusBarang(this)">
 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
 </button>
 </div>
 `;
 container.appendChild(row);
 
 // Hapus disable state di tombol hapus baris pertama jika lebih dari 1 baris
 updateDeleteButtons();
 }

 function hapusBarang(btn) {
 const rows = document.querySelectorAll('.item-row');
 if (rows.length > 1) {
 btn.closest('.item-row').remove();
 updateDeleteButtons();
 }
 }

 function updateDeleteButtons() {
 const rows = document.querySelectorAll('.item-row');
 const firstDeleteBtn = rows[0].querySelector('button[onclick="hapusBarang(this)"]');
 if (rows.length === 1) {
 firstDeleteBtn.disabled = true;
 firstDeleteBtn.classList.add('opacity-50');
 } else {
 firstDeleteBtn.disabled = false;
 firstDeleteBtn.classList.remove('opacity-50');
 }
 }

 // Validasi HTML5 kustom untuk "isi bagian ini" dan tanggal kembali
 document.addEventListener('invalid', function(e) {
     if (e.target.validity.valueMissing) {
         e.target.setCustomValidity('isi bagian ini');
     }
 }, true); // true = Use capture phase

 document.addEventListener('input', function(e) {
     if (e.target.validity.customError && (e.target.validationMessage === 'isi bagian ini' || e.target.validationMessage === 'jam kembali harus lebih dari jam pinjam' || e.target.validationMessage === 'stok tersedia kurang' || e.target.validationMessage === 'perbaiki tanggal, tidak boleh kurang dari hari ini')) {
         e.target.setCustomValidity('');
     }
     checkDates();
     checkStock();
 });

 document.addEventListener('change', function(e) {
     if (e.target.validity.customError && (e.target.validationMessage === 'isi bagian ini' || e.target.validationMessage === 'jam kembali harus lebih dari jam pinjam' || e.target.validationMessage === 'stok tersedia kurang' || e.target.validationMessage === 'perbaiki tanggal, tidak boleh kurang dari hari ini')) {
         e.target.setCustomValidity('');
     }
     checkDates();
     checkStock();
 });

 function checkStock() {
     const rows = document.querySelectorAll('.item-row');
     rows.forEach(row => {
         const select = row.querySelector('select[name="kode_barang[]"]');
         const input = row.querySelector('input[name="jumlah[]"]');
         
         if (select && input && select.value && input.value) {
             const selectedOption = select.options[select.selectedIndex];
             const stok = parseInt(selectedOption.getAttribute('data-stok'));
             const jumlah = parseInt(input.value);
             
             if (!isNaN(stok) && !isNaN(jumlah) && jumlah > stok) {
                 input.setCustomValidity('stok tersedia kurang');
             } else {
                 if (input.validity.customError && input.validationMessage === 'stok tersedia kurang') {
                     input.setCustomValidity('');
                 }
             }
         }
     });
 }

 function parseDate(str) {
     if(!str) return null;
     // str is like "dd/mm/yyyy HH:mm"
     const parts = str.split(' ');
     if(parts.length === 2) {
         const dateParts = parts[0].split('/');
         const timeParts = parts[1].split(':');
         if(dateParts.length === 3 && timeParts.length === 2) {
             return new Date(dateParts[2], dateParts[1] - 1, dateParts[0], timeParts[0], timeParts[1]);
         }
     }
     return null;
 }

 function checkDates() {
     const tglPinjamDate = document.querySelector('input[name="tgl_pinjam_date"]');
     const tglPinjamTime = document.querySelector('input[name="tgl_pinjam_time"]');
     const tglKembaliDate = document.querySelector('input[name="tgl_kembali_date"]');
     const tglKembaliTime = document.querySelector('input[name="tgl_kembali_time"]');
     
     if (tglPinjamDate && tglPinjamTime && tglKembaliDate && tglKembaliTime && 
         tglPinjamDate.value && tglPinjamTime.value && tglKembaliDate.value && tglKembaliTime.value) {
         
         const pinjam = parseDate(tglPinjamDate.value + ' ' + tglPinjamTime.value);
         const kembali = parseDate(tglKembaliDate.value + ' ' + tglKembaliTime.value);
         
         const today = new Date();
         today.setHours(0, 0, 0, 0);
         
         if (pinjam && pinjam.getTime() < today.getTime()) {
             tglPinjamDate.setCustomValidity('perbaiki tanggal, tidak boleh kurang dari hari ini');
         } else {
             tglPinjamDate.setCustomValidity('');
         }

         if (kembali && kembali.getTime() < today.getTime()) {
             tglKembaliDate.setCustomValidity('perbaiki tanggal, tidak boleh kurang dari hari ini');
         } else {
             tglKembaliDate.setCustomValidity('');
         }

         if (pinjam && kembali && kembali.getTime() <= pinjam.getTime()) {
             tglKembaliTime.setCustomValidity('jam kembali harus lebih dari jam pinjam');
         } else {
             tglKembaliTime.setCustomValidity('');
         }
     }
 }

 document.addEventListener('DOMContentLoaded', function() {
     flatpickr("#tgl_pinjam_date", {
         dateFormat: "d/m/Y",
         locale: "id",
         allowInput: true,
         minDate: "today"
     });
     
     flatpickr("#tgl_kembali_date", {
         dateFormat: "d/m/Y",
         locale: "id",
         allowInput: true,
         minDate: "today"
     });
     
     flatpickr("#tgl_pinjam_time", {
         enableTime: true,
         noCalendar: true,
         time_24hr: true,
         dateFormat: "H:i",
         allowInput: true
     });
     
     flatpickr("#tgl_kembali_time", {
         enableTime: true,
         noCalendar: true,
         time_24hr: true,
         dateFormat: "H:i",
         allowInput: true
     });

     // Kategori filter handler
     document.addEventListener('change', function(e) {
         if (e.target.classList.contains('kategori-select')) {
             const row = e.target.closest('.item-row');
             const barangSelect = row.querySelector('.barang-select');
             const selectedKat = e.target.value;
             
             barangSelect.value = ''; // Reset selection
             
             Array.from(barangSelect.options).forEach(opt => {
                 if (opt.value === "") return; // keep placeholder visible
                 
                 const katId = opt.getAttribute('data-kategori');
                 const stok = parseInt(opt.getAttribute('data-stok'));
                 if (selectedKat !== "" && katId === selectedKat) {
                     opt.style.display = '';
                     opt.disabled = stok <= 0;
                 } else {
                     opt.style.display = 'none';
                     opt.disabled = true;
                 }
             });
         }
     });

     // Cek query parameters untuk auto-fill
     const urlParams = new URLSearchParams(window.location.search);
     const kategoriIdParam = urlParams.get('kategori_id');
     const barangIdParam = urlParams.get('barang_id');

     if (kategoriIdParam && barangIdParam) {
         const firstKategori = document.querySelector('.item-row .kategori-select');
         const firstBarang = document.querySelector('.item-row .barang-select');
         if (firstKategori && firstBarang) {
             firstKategori.value = kategoriIdParam;
             const event = new Event('change', { bubbles: true });
             firstKategori.dispatchEvent(event);
             setTimeout(() => {
                 firstBarang.value = barangIdParam;
             }, 100);
         }
     }

     const form = document.querySelector('form');
     if(form) {
         form.addEventListener('submit', function(e) {
             const inputs = form.querySelectorAll('input, select');
             inputs.forEach(input => {
                 input.setCustomValidity('');
             });
             checkDates();
             checkStock();
             if (!form.checkValidity()) {
                 e.preventDefault();
             }
         });
     }
 });
</script>
@endsection