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

        /* Penyesuaian autofill browser agar input tetap rapi */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 30px #eff6ff inset !important;
            -webkit-text-fill-color: #0f172a !important;
        }

        /* Latar Belakang Utama Batik */
        .bg-utama-batik {
            background-image: url("{{ asset('img/bg-batik kiri.png') }}");
        }
    </style>
</head>

<body
    class="min-h-screen flex flex-col items-center justify-center relative bg-utama-batik bg-cover bg-center bg-no-repeat bg-fixed py-10">

    <div class="z-10 w-full max-w-[500px] px-4 sm:px-6 flex flex-col items-center">

        <div class="bg-white rounded-2xl border border-slate-200 w-full p-6 sm:p-10">

            <div class="flex flex-row items-center justify-center mb-8 gap-4 w-full">
                <div
                    class="w-14 h-14 sm:w-16 sm:h-16 shrink-0 bg-white rounded-full flex items-center justify-center border-2 border-slate-200 p-1.5 overflow-hidden shadow-sm">
                    <img src="{{ asset('img/logo rapih.jpg') }}"
                        onerror="this.src='https://ui-avatars.com/api/?name=Inv&background=1e3a8a&color=fff&size=100'"
                        alt="Logo Instansi" class="w-full h-full object-contain">
                </div>

                <div class="flex flex-col items-center justify-center text-center">
                    <h2
                        class="text-[17px] sm:text-[22px] font-extrabold text-[#1e3a8a] uppercase whitespace-nowrap leading-none tracking-tight">
                        PEMINJAMAN INVENTARIS
                    </h2>
                    <span
                        class="mt-1.5 text-[11px] sm:text-[12px] font-bold uppercase tracking-[0.18em] text-slate-500 leading-none">
                        KECAMATAN CICALENGKA
                    </span>
                </div>
            </div>

            @if($errors->any())
                <div
                    class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm text-left font-medium shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" autocomplete="off" enctype="multipart/form-data">
                @csrf

                <div class="relative flex items-center py-2 mb-3">
                    <div class="flex-grow border-t border-slate-300"></div>
                    <span
                        class="flex-shrink-0 mx-4 text-slate-500 text-[10px] font-extrabold uppercase tracking-widest">Informasi
                        Akun</span>
                    <div class="flex-grow border-t border-slate-300"></div>
                </div>

                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Nama Lengkap <span
                            class="font-normal italic text-slate-500">(Samakan dengan KTP)</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            oninvalid="this.setCustomValidity('Isi bagian ini')" oninput="this.setCustomValidity('')"
                            class="block w-full pl-11 pr-3 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400 shadow-sm capitalize"
                            placeholder="Contoh: Febrian Iradatul">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Nomor Induk Kependudukan
                        (NIK)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                </path>
                            </svg>
                        </div>
                        <input type="text" name="nik" value="{{ old('nik') }}" required
                            oninvalid="this.setCustomValidity('Isi bagian ini')" oninput="this.setCustomValidity('')"
                            maxlength="16"
                            class="block w-full pl-11 pr-3 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400 shadow-sm"
                            placeholder="Masukkan 16 Digit NIK KTP">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Gmail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            oninvalid="this.setCustomValidity('Isi bagian ini')" oninput="this.setCustomValidity('')"
                            class="block w-full pl-11 pr-3 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400 shadow-sm"
                            placeholder="Masukkan Gmail Aktif" autocomplete="off">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Alamat Lengkap</label>
                    <div class="relative">
                        <div class="absolute top-3 left-0 pl-3.5 flex items-start pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <textarea name="alamat" rows="2" required oninvalid="this.setCustomValidity('Isi bagian ini')"
                            oninput="this.setCustomValidity('')"
                            class="block w-full pl-11 pr-3 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400 shadow-sm"
                            placeholder="Masukkan Alamat Lengkap Sesuai KTP">{{ old('alamat') }}</textarea>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Upload KTP <span
                            class="font-normal italic text-slate-500">(Wajib upload scan/foto KTP asli)</span></label>
                    <div class="relative">
                        <input type="file" name="foto_profil" accept="image/*" required
                            oninvalid="this.setCustomValidity('Upload KTP anda')"
                            oninput="this.setCustomValidity('')"
                            class="block w-full text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1e3a8a] hover:file:bg-blue-100 bg-white border border-blue-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] transition-colors cursor-pointer shadow-sm text-sm p-1.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-2">
                    <div>
                        <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                oninvalid="this.setCustomValidity('Isi bagian ini')"
                                oninput="this.setCustomValidity('')"
                                class="block w-full pl-11 pr-10 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400 shadow-sm"
                                placeholder="Buat Password" autocomplete="new-password">

                            <button type="button" onclick="toggleVisibility('password', 'eye-open-1', 'eye-closed-1')"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-[#1e3a8a] transition-colors focus:outline-none">
                                <svg id="eye-open-1" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg id="eye-closed-1" class="h-4 w-4 hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Konfirmasi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                oninvalid="this.setCustomValidity('Isi bagian ini')"
                                oninput="this.setCustomValidity('')"
                                class="block w-full pl-11 pr-10 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400 shadow-sm"
                                placeholder="Ulangi Password" autocomplete="new-password">

                            <button type="button"
                                onclick="toggleVisibility('password_confirmation', 'eye-open-2', 'eye-closed-2')"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-[#1e3a8a] transition-colors focus:outline-none">
                                <svg id="eye-open-2" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg id="eye-closed-2" class="h-4 w-4 hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <p class="text-[11px] text-slate-500 mb-6 font-medium italic">* Password minimal 8 karakter, mengandung
                    huruf besar, huruf kecil, dan angka.</p>

                <div class="relative flex items-center py-2 mb-3 mt-4">
                    <div class="flex-grow border-t border-slate-300"></div>
                    <span
                        class="flex-shrink-0 mx-4 text-slate-500 text-[10px] font-extrabold uppercase tracking-widest">Informasi
                        Instansi</span>
                    <div class="flex-grow border-t border-slate-300"></div>
                </div>

                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Jenis Peminjam</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <select name="jenis_peminjam" required oninvalid="this.setCustomValidity('Isi bagian ini')"
                            oninput="this.setCustomValidity('')"
                            class="block w-full pl-11 pr-3 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm shadow-sm appearance-none">
                            <option value="" disabled {{ old('jenis_peminjam') ? '' : 'selected' }}>-- Pilih Kategori --
                            </option>
                            <option value="Pemerintah Desa" {{ old('jenis_peminjam') == 'Pemerintah Desa' ? 'selected' : '' }}>Pemerintah Desa</option>
                            <option value="Perangkat Kecamatan" {{ old('jenis_peminjam') == 'Perangkat Kecamatan' ? 'selected' : '' }}>Perangkat Kecamatan</option>
                            <option value="Lembaga Kemasyarakatan Desa" {{ old('jenis_peminjam') == 'Lembaga Kemasyarakatan Desa' ? 'selected' : '' }}>Lembaga Kemasyarakatan Desa</option>
                            <option value="Instansi Pemerintah" {{ old('jenis_peminjam') == 'Instansi Pemerintah' ? 'selected' : '' }}>Instansi Pemerintah</option>
                            <option value="Organisasi" {{ old('jenis_peminjam') == 'Organisasi' ? 'selected' : '' }}>
                                Organisasi</option>
                            <option value="Lainnya" {{ old('jenis_peminjam') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Nama Instansi /
                        Organisasi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <input type="text" name="nama_instansi" value="{{ old('nama_instansi') }}"
                            class="block w-full pl-11 pr-3 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400 shadow-sm"
                            placeholder="Contoh: Karang Taruna Desa">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-slate-700 text-sm font-bold mb-1.5 tracking-wide">Nomor Kontak
                        (WhatsApp)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <input type="text" name="kontak_penanggung_jawab" value="{{ old('kontak_penanggung_jawab') }}"
                            required oninvalid="this.setCustomValidity('Isi bagian ini')"
                            oninput="this.setCustomValidity('')"
                            class="block w-full pl-11 pr-3 py-2.5 bg-white border border-blue-200 rounded-lg text-slate-900 focus:outline-none focus:bg-white focus:border-[#1e3a8a] focus:ring-1 focus:ring-[#1e3a8a] transition-colors text-sm placeholder-slate-400 shadow-sm"
                            placeholder="Contoh: 08123456789">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#1e3a8a] hover:bg-blue-900 text-white font-bold py-3.5 rounded-lg transition-colors tracking-wider shadow-md">
                    DAFTAR
                </button>

                <div class="mt-6 text-center text-sm text-slate-600 font-medium">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                        class="text-[#1e3a8a] hover:text-blue-700 font-bold transition-colors underline decoration-[#1e3a8a]/40 hover:decoration-blue-700">
                        Login di sini
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-6 mb-8 text-center w-full">
            <span
                class="inline-block bg-white px-5 py-2 rounded-full text-[12px] sm:text-[13px] text-emerald-900 font-bold tracking-wide border border-emerald-200 shadow-sm">
                Developed by Febrian Iradatul Rahman
            </span>
        </div>

    </div>

    <script>
        function toggleVisibility(inputId, openIconId, closedIconId) {
            const inputField = document.getElementById(inputId);
            const eyeOpen = document.getElementById(openIconId);
            const eyeClosed = document.getElementById(closedIconId);

            if (inputField.type === 'password') {
                inputField.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                inputField.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>

</html>