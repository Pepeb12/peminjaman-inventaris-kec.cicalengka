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

        .bg-utama-batik {
            background-image: url("{{ asset('img/bg-batik kiri.png') }}");
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center relative bg-utama-batik bg-cover bg-center bg-no-repeat bg-fixed py-10">
    <div class="z-10 w-full max-w-md px-4 sm:px-6 flex flex-col items-center">
        <div class="w-full space-y-8 bg-white p-7 sm:p-10 rounded-2xl shadow-xl border border-slate-200">
            <div>
                <h2 class="mt-2 text-center text-3xl font-extrabold text-slate-900 tracking-tight">
                    Verifikasi OTP
                </h2>
                <p class="mt-2 text-center text-sm text-slate-600 font-medium">
                    Masukkan 6 digit kode OTP yang telah kami kirimkan ke <strong>WhatsApp</strong> Anda.
                </p>
            </div>

            @if(session('success'))
                <div
                    class="bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium border border-emerald-100">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 text-rose-600 px-4 py-3 rounded-xl text-sm font-medium border border-rose-100">
                    {{ session('error') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('password.verify.submit') }}" method="POST">
                @csrf
                <div>
                    <label class="block text-slate-700 text-sm font-bold mb-2 text-center">Kode OTP</label>
                    <input type="text" name="otp" required maxlength="6"
                        class="block w-full px-4 py-4 text-center text-2xl tracking-[0.5em] font-bold bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                        placeholder="------">
                    @error('otp') <span class="text-xs text-rose-500 mt-1 block text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all">
                        Verifikasi Kode
                    </button>
                </div>
            </form>

            <div class="text-center mt-4 flex flex-col gap-3">
                <a href="{{ route('password.request') }}"
                    class="text-sm font-medium text-emerald-600 hover:text-emerald-500 transition-colors">
                    Kirim ulang kode?
                </a>
                <a href="{{ route('login') }}"
                    class="w-full flex justify-center py-3.5 px-4 border border-slate-300 rounded-xl shadow-sm text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition-all">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</body>

</html>