<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Inventaris Barang Kecamatan</title>
 <link rel="icon" type="image/jpeg" href="{{ asset('img/logo rapih.jpg') }}">
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
 <script src="https://cdn.tailwindcss.com"></script>
 <style>
 body { font-family: 'Inter', sans-serif; }
 .bg-utama-batik {
 background-image: url("{{ asset('img/bg-batik kiri.png') }}");
 }
 </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
 
 <div class="absolute inset-0 bg-slate-900/40 z-0"></div>

 <div class="relative z-10 w-full max-w-5xl bg-white border-2 border-slate-200 rounded-3xl shadow-md overflow-hidden flex flex-col md:flex-row">
 
 <!-- Kolom Kiri: Ilustrasi / Deskripsi -->
 <div class="md:w-3/5 bg-blue-900/80 p-8 md:p-12 text-white flex flex-col justify-center relative overflow-hidden">
 <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
 
 <div class="relative z-10">
 <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center p-2 mb-6 shadow-lg border-4 border-blue-400">
 <img src="{{ asset('img/logo rapih.jpg') }}" onerror="this.src='https://ui-avatars.com/api/?name=C&background=fff&color=1e3a8a'" alt="Logo" class="w-full h-full object-contain rounded-full">
 </div>
 
 <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-2">SIPI</h1>
 <h2 class="text-lg md:text-xl font-bold text-emerald-200 uppercase tracking-widest mb-6">Kecamatan Cicalengka</h2>
 
 <p class="text-emerald-50 text-sm md:text-base leading-relaxed max-w-md font-medium">
 Sistem Informasi Peminjaman Inventaris (SIPI) adalah platform digital yang dirancang untuk mempermudah pengelolaan, pengajuan, dan pelaporan inventaris di lingkungan Kecamatan Cicalengka.
 </p>

 <div class="mt-8 flex gap-4">
 <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-slate-200">
 <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 <span class="text-xs font-semibold">Cepat</span>
 </div>
 <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-slate-200">
 <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
 <span class="text-xs font-semibold">Aman</span>
 </div>
 <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-slate-200">
 <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
 <span class="text-xs font-semibold">Terdata</span>
 </div>
 </div>
 </div>
 </div>

 <!-- Kolom Kanan: Aksi / Login -->
 <div class="md:w-2/5 bg-white p-8 md:p-12 flex flex-col justify-center items-center text-center">
 
 <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Selamat Datang</h3>
 <p class="text-slate-600 text-sm font-medium mb-8">Silakan masuk untuk melanjutkan ke dashboard</p>

 @if (Route::has('login'))
 <div class="w-full space-y-4">
 @auth
 <a href="{{ url('/dashboard') }}" class="flex items-center justify-center gap-2 w-full bg-[#064e3b] text-white px-6 py-4 rounded-xl font-bold hover:bg-[#152c6b] transition-colors shadow-lg group">
 Masuk ke Dashboard
 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
 </a>
 @else
 <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full bg-[#064e3b] text-white px-6 py-4 rounded-xl font-bold hover:bg-[#152c6b] transition-colors shadow-lg group">
 Log In
 <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
 </a>
 
 @if (Route::has('register'))
 <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 w-full bg-white text-[#064e3b] border-2 border-[#064e3b] px-6 py-4 rounded-xl font-bold hover:bg-emerald-50 transition-colors shadow-sm">
 Register Peminjam Baru
 </a>
 @endif
 @endauth
 </div>
 @endif

 <div class="mt-12 text-xs text-slate-500 font-semibold">
 &copy; {{ date('Y') }} Kecamatan Cicalengka
 </div>
 </div>

 </div>

</body>
</html>
