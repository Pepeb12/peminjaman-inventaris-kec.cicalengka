<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang Kecamatan - Lupa Password</title>
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
                    Lupa Password
                </h2>
                <p class="mt-2 text-center text-sm text-slate-600 font-medium">
                    Masukkan nomor whatsapp aktif sesuaikan dengan nomor whatsapp di profil.
                </p>
            </div>

            @if(session('error'))
                <div class="bg-rose-50 text-rose-600 px-4 py-3 rounded-xl text-sm font-medium border border-rose-100">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('status'))
                <div class="bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium border border-emerald-100">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
                @csrf
                
                <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2 text-center">Nomor WhatsApp (WA) Aktif</label>
                    <input type="text" name="nomor_wa" value="{{ old('nomor_wa') }}" required class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors text-center" placeholder="Contoh: 081234567890">
                    @error('nomor_wa') <span class="text-xs text-rose-500 mt-1 block text-center">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all">
                        KIRIM KODE OTP
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">
                    Kembali ke halaman Login
                </a>
            </div>
        </div>
    </div>
</body>

</html>