<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Berakhir - Inventaris Cicalengka</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-cicalengka.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-100 p-8 text-center space-y-6">
        <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto shadow-inner">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <div class="space-y-2">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Sesi Telah Berakhir</h1>
            <p class="text-sm text-slate-600 leading-relaxed">
                Halaman atau sesi Anda telah kedaluwarsa karena tidak ada aktivitas. Silakan login kembali untuk melanjutkan.
            </p>
        </div>

        <div>
            <a href="{{ route('logout') }}" 
               class="inline-block w-full py-3 px-4 bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold rounded-xl shadow-md shadow-blue-900/20 transition-all text-sm">
                Kembali ke Halaman Login
            </a>
        </div>
    </div>
</body>
</html>

