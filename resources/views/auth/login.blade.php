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
 body { 
 font-family: 'Inter', sans-serif; 
 }
 
 input:-webkit-autofill,
 input:-webkit-autofill:hover, 
 input:-webkit-autofill:focus, 
 input:-webkit-autofill:active{
 -webkit-box-shadow: 0 0 0 30px #eff6ff inset !important; 
 -webkit-text-fill-color: #0f172a !important;
 }


 .bg-utama-batik {
 background-image: url("{{ asset('img/bg-batik kiri.png') }}");
 }
 </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center relative bg-utama-batik bg-cover bg-center bg-no-repeat bg-fixed py-10">
 
 <div class="z-10 w-full max-w-md px-4 sm:px-6 flex flex-col items-center">
 
 <div class="bg-white rounded-2xl border border-slate-200 w-full p-7 sm:p-10">
 
 <div class="flex flex-row items-center justify-center mb-8 gap-3 sm:gap-4 w-full">
 <div class="w-14 h-14 sm:w-16 sm:h-16 shrink-0 bg-white rounded-full flex items-center justify-center border-2 border-slate-200 p-1.5 overflow-hidden shadow-sm">
 <img src="{{ asset('img/logo rapih.jpg') }}" onerror="this.src='https://ui-avatars.com/api/?name=Inv&background=1e3a8a&color=fff&size=100'" alt="Logo Instansi" class="w-full h-full object-contain">
 </div>
 
 <div class="flex flex-col items-center justify-center">
 <h2 class="text-[15px] sm:text-[19px] font-extrabold text-[#1e3a8a] uppercase whitespace-nowrap leading-none tracking-tight">
 PEMINJAMAN INVENTARIS
 </h2>
 <span class="mt-1.5 text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.22em] text-slate-500 leading-none text-center">
 KECAMATAN CICALENGKA
 </span>
 </div>
 </div>

 @if(session('error') || $errors->any())
 <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm text-center sm:text-left font-medium">
 {{ session('error') ?: $errors->first() }}
 </div>
 @endif

 <form method="POST" action="{{ route('login') }}" autocomplete="off">
 @csrf
 
 <div class="mb-5">
 <label class="block text-slate-700 text-sm font-bold mb-2 tracking-wide">Gmail</label>
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
 <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
 </div>
 <input type="email" name="email" class="block w-full pl-11 pr-3 py-3 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400" placeholder="Masukkan Gmail Aktif" required oninvalid="this.setCustomValidity('Isi bagian ini')" oninput="this.setCustomValidity('')" autofocus autocomplete="off">
 </div>
 </div>

 <div class="mb-6">
 <label class="block text-slate-700 text-sm font-bold mb-2 tracking-wide">Password</label>
 <div class="relative">
 <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
 <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
 </div>
 <input type="password" id="password" name="password" class="block w-full pl-11 pr-10 py-3 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400" placeholder="Masukkan password" required oninvalid="this.setCustomValidity('Isi bagian ini')" oninput="this.setCustomValidity('')" autocomplete="new-password">
 
 <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-[#1e3a8a] transition-colors focus:outline-none">
 <svg id="eye-open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
 <svg id="eye-closed" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
 </button>
    </div>
 </div>

 <div class="flex justify-end mb-6">
 <a href="{{ route('password.request') }}" class="text-xs text-slate-500 hover:text-[#1e3a8a] underline font-medium transition-colors">
 Lupa password?
 </a>
 </div>

 <button type="submit" class="w-full bg-[#1e3a8a] hover:bg-blue-900 text-white font-bold py-2.5 rounded-lg transition-colors mt-2 tracking-wider shadow-md">
 LOGIN
 </button>
 
 <div class="mt-6 text-center text-sm text-slate-600 font-medium flex flex-col gap-3">
 <div>
 Belum punya akun? 
 <a href="{{ route('register') }}" class="text-[#1e3a8a] hover:text-blue-700 font-bold transition-colors underline decoration-[#1e3a8a]/40 hover:decoration-blue-700">
 Registrasi di sini
 </a>
 </div>
 <div class="text-xs text-slate-500">
 Butuh bantuan? 
 <a href="https://wa.me/6289512336537?text=Halo%20Admin%2C%20saya%20butuh%20bantuan%20terkait%20Sistem%20Peminjaman%20Inventaris." target="_blank" class="text-emerald-600 hover:text-emerald-700 font-bold transition-colors underline decoration-emerald-600/40 hover:decoration-emerald-700 inline-flex items-center gap-1 justify-center">
 <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"/></svg>
 Hubungi Admin
 </a>
 </div>
 </div>
 </form>
 </div>

 <div class="mt-6 text-center w-full">
 <span class="inline-block bg-white px-5 py-2 rounded-full text-[12px] sm:text-[13px] text-emerald-900 font-bold tracking-wide border border-emerald-200 shadow-sm">
 Developed by Febrian Iradatul Rahman (242505024)
 </span>
 </div>
 
 </div>

 <script>
 function togglePassword() {
 const passwordInput = document.getElementById('password');
 const eyeOpen = document.getElementById('eye-open');
 const eyeClosed = document.getElementById('eye-closed');

 if (passwordInput.type === 'password') {
 passwordInput.type = 'text';
 eyeOpen.classList.add('hidden');
 eyeClosed.classList.remove('hidden');
 } else {
 passwordInput.type = 'password';
 eyeOpen.classList.remove('hidden');
 eyeClosed.classList.add('hidden');
 }
 }
 </script>
</body>
</html>