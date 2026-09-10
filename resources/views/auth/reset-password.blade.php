<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang Kecamatan - Buat Password Baru</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo rapih.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-utama-batik {
            background-image: url("{{ asset('img/bg-batik kiri.png') }}");
        }
    </style>
</head>

<body class="bg-utama-batik bg-cover bg-center bg-no-repeat bg-fixed h-screen w-full">
    <div
        class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div
            class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl relative z-10 border border-slate-100">
            <div>
                <h2 class="mt-2 text-center text-3xl font-extrabold text-slate-900 tracking-tight">
                    Buat Password Baru
                </h2>
                <p class="mt-2 text-center text-sm text-slate-600 font-medium">
                    Silakan buat kata sandi baru untuk akun Anda.
                </p>
            </div>

            @if(session('error') || $errors->any())
                <div class="bg-rose-50 text-rose-600 px-4 py-3 rounded-xl text-sm font-medium border border-rose-100">
                    {{ session('error') ?: $errors->first() }}
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
                @csrf
                
                <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2 text-center">Password Baru</label>
                    <input type="password" name="password" required class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                    @error('password') <span class="text-xs text-rose-500 mt-1 block text-center">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2 text-center">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                </div>
                
                <p class="text-[11px] text-black text-center font-medium italic">* Password minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka.</p>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all">
                        Simpan Password Baru
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">
                    Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </div>
</body>

</html>
