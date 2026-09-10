<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang Kecamatan</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('img/logo rapih.jpg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Latar Belakang Utama Batik */
        .bg-utama-batik {
            background-image: url("{{ asset('img/bg-batik kiri.png') }}");
        }

        /* Scrollbar kustom agar lebih rapi */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(30, 58, 138, 0.2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(30, 58, 138, 0.5);
        }
    </style>
</head>

<body class="bg-utama-batik bg-cover bg-center bg-no-repeat bg-fixed h-[100dvh] w-full overflow-hidden flex">

    <div class="flex flex-1 overflow-hidden bg-blue-50 relative w-full">

        <div id="mobile-overlay" class="fixed inset-0 bg-slate-900/60 z-40 hidden md:hidden " onclick="toggleSidebar()">
        </div>

        <!-- Sidebar Gradient (Biru Tua - Hijau) -->
        <aside id="sidebar"
            class="absolute md:relative z-50 w-64 md:w-72 h-full bg-[#1e3a8a] text-white flex flex-col transition-transform duration-300 transform -translate-x-full md:translate-x-0 shrink-0 overflow-hidden">

            <div class="flex flex-col items-center justify-center py-8 border-b border-slate-200 relative">
                <button onclick="toggleSidebar()"
                    class="absolute top-4 right-4 md:hidden text-white/50 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div
                    class="w-16 h-16 bg-white rounded-full flex items-center justify-center border-2 border-blue-200 p-1.5 overflow-hidden shadow-lg mb-4 mt-2">
                    <img src="{{ asset('img/logo rapih.jpg') }}"
                        onerror="this.src='https://ui-avatars.com/api/?name=PI&background=1e3a8a&color=fff'" alt="Logo"
                        class="w-full h-full object-contain">
                </div>
                <h2 class="text-xl font-extrabold text-white text-center leading-tight">PEMINJAMAN<br>INVENTARIS</h2>
                <span class="mt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-blue-200 text-center">KECAMATAN
                    CICALENGKA</span>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                @if(auth()->check() && auth()->user()->role === 'umpeg')
                    <!-- MENU ADMIN / UMPEG -->
                    <a href="{{ route('umpeg.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('umpeg.dashboard') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <svg class="w-5 h-5 {{ request()->routeIs('umpeg.dashboard') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard Utama
                    </a>

                    <a href="{{ route('umpeg.barang.index') }}"
                        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('umpeg.barang.*') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <svg class="w-5 h-5 {{ request()->routeIs('umpeg.barang.*') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        Master Barang
                    </a>

                    <a href="{{ route('umpeg.peminjaman.index') }}"
                        class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('umpeg.peminjaman.*') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('umpeg.peminjaman.*') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                            Kelola Peminjaman
                        </div>
                        @php
                            $pendingCount = \App\Models\Peminjaman::whereIn('status', ['Menunggu Proses', 'Menunggu Cetak Bukti'])->count();
                         @endphp
                        @if($pendingCount > 0)
                            <span class="bg-rose-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-sm">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('umpeg.peminjam.index') }}"
                        class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('umpeg.peminjam.*') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('umpeg.peminjam.*') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Manajemen Peminjam
                        </div>
                        @php
                            $newPeminjamCount = \App\Models\Peminjam::where('status_akun', 'Menunggu')->count();
                         @endphp
                        @if($newPeminjamCount > 0)
                            <span class="bg-rose-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full shadow-sm">
                                {{ $newPeminjamCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('umpeg.laporan.index') }}"
                        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('umpeg.laporan.*') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <svg class="w-5 h-5 {{ request()->routeIs('umpeg.laporan.*') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Cetak Laporan
                    </a>


                @elseif(auth()->check() && auth()->user()->role === 'peminjam')
                    <!-- MENU PEMINJAM -->
                    <a href="{{ route('peminjam.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.dashboard') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <svg class="w-5 h-5 {{ request()->routeIs('peminjam.dashboard') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('peminjam.katalog.index') }}"
                        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.katalog.*') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <svg class="w-5 h-5 {{ request()->routeIs('peminjam.katalog.*') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        Katalog Barang
                    </a>

                    <a href="{{ route('peminjam.pengajuan.create') }}"
                        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.pengajuan.*') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <svg class="w-5 h-5 {{ request()->routeIs('peminjam.pengajuan.*') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Pengajuan
                    </a>

                    <a href="{{ route('peminjam.riwayat.index') }}"
                        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.riwayat.*') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <svg class="w-5 h-5 {{ request()->routeIs('peminjam.riwayat.*') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Peminjaman
                    </a>

                    <a href="{{ route('peminjam.profil.index') }}"
                        class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('peminjam.profil.*') ? 'bg-white shadow-md font-bold text-[#1e3a8a] border border-slate-200' : 'text-blue-50 hover:bg-white hover:text-[#1e3a8a] font-medium' }} rounded-xl text-sm transition-all relative z-10">
                        <svg class="w-5 h-5 {{ request()->routeIs('peminjam.profil.*') ? 'text-[#1e3a8a]' : 'opacity-80' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profil
                    </a>
                @endif
            </nav>

            <div class="p-4 border-t border-slate-200 text-center bg-black/20 relative z-10">
                <p class="text-[10px] text-blue-200 font-bold uppercase tracking-widest opacity-80">Developed By</p>
                <p class="text-xs font-bold text-white mt-0.5">Febrian Iradatul Rahman</p>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-full overflow-hidden w-full relative">

            <header
                class="h-16 shrink-0 border-b border-slate-200 bg-white flex items-center justify-between px-4 sm:px-8">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()"
                        class="md:hidden p-2 bg-white rounded-lg text-[#1e3a8a] hover:bg-white focus:outline-none shadow-sm transition-colors border border-transparent hover:border-blue-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="block">
                        <span
                            class="text-[10px] sm:text-xs font-bold text-[#1e3a8a] uppercase tracking-wider bg-white px-2 sm:px-4 py-1.5 rounded-full border border-slate-200 shadow-sm flex items-center gap-1 sm:gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span
                                class="hidden sm:inline">{{ strtolower(\Carbon\Carbon::now()->translatedFormat('l j F Y')) }}</span>
                            <span class="sm:hidden">{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</span>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-extrabold text-slate-900 leading-none">
                            {{ auth()->user()->role === 'umpeg' ? 'NENI RUNINGDIYAH, S.KOM' : (auth()->user()->name ?? 'Pengguna') }}
                        </p>
                        @if(auth()->user()->role === 'umpeg')
                            <p class="text-[10px] text-slate-600 font-bold mt-1">
                                Umum Kepegawaian
                            </p>
                        @endif
                        <p class="text-[10px] text-[#1e3a8a] font-bold uppercase tracking-widest mt-1">
                            {{ auth()->user()->role === 'umpeg' ? 'NIP. 19810924 201004 2 001' : 'Peminjam' }}
                        </p>
                    </div>
                    @if(auth()->user()->role === 'umpeg')
                        <div class="w-10 h-10 rounded-full bg-slate-800 border-2 border-slate-200 flex items-center justify-center text-white font-bold shadow-md overflow-hidden cursor-pointer hover:opacity-90 transition-opacity"
                            data-role="umpeg" data-name="NENI RUNINGDIYAH, S. KOM" data-jabatan="Umum Kepegawaian"
                            data-nip="NIP. 19810924 201004 2 001"
                            onclick="handleProfileClick(this, '{{ asset('img/admin.jpg') }}')">
                            <img src="{{ asset('img/admin.jpg') }}" class="w-full h-full object-cover"
                                onerror="this.src='{{ asset('img/logo rapih.jpg') }}'">
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-full bg-slate-800 border-2 border-slate-200 flex items-center justify-center text-white font-bold shadow-md overflow-hidden cursor-pointer hover:opacity-90 transition-opacity"
                            data-role="peminjam" data-name="{{ auth()->user()->name ?? 'Pengguna' }}"
                            data-instansi="{{ auth()->user()->peminjam->nama_instansi ?? 'Peminjam' }}"
                            data-wa="{{ auth()->user()->peminjam->kontak_penanggung_jawab ?? '-' }}"
                            data-alamat="{{ auth()->user()->alamat ?? '-' }}"
                            data-url="{{ route('peminjam.profil.index') }}"
                            onclick="handleProfileClick(this, '{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : '' }}')">
                            @if(auth()->user()->foto_profil)
                                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                                    class="w-full h-full object-cover">
                            @else
                                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                            @endif
                        </div>
                    @endif
                    <form action="{{ route('logout') }}" method="POST"
                        class="ml-1 sm:border-l sm:border-slate-300 sm:pl-3">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-rose-100/80 text-rose-600 rounded-lg hover:bg-rose-500 hover:text-white transition-colors shadow-sm border border-rose-200 text-xs sm:text-sm font-bold"
                            title="Logout">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            @php
                $isFullPage = request()->routeIs('umpeg.barang.index', 'umpeg.barang.create', 'umpeg.barang.edit', 'umpeg.peminjaman.index', 'umpeg.peminjam.index', 'umpeg.laporan.index', 'peminjam.dashboard', 'peminjam.katalog.*', 'peminjam.pengajuan.*', 'peminjam.riwayat.*', 'peminjam.profil.*');
            @endphp
            <div class="flex-1 overflow-y-auto {{ $isFullPage ? '' : 'p-4 sm:p-6 lg:p-8 space-y-6' }}">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Global Image Modal -->
    <div id="globalImageModal"
        class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-opacity duration-300 opacity-0"
        onclick="closeImageModal()">
        <button onclick="closeImageModal()"
            class="absolute top-4 right-4 text-white hover:text-rose-400 bg-slate-800/50 hover:bg-slate-800 p-2 rounded-full transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="globalImageModalSrc" src="" alt="Enlarged Photo"
            class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl scale-95 transition-transform duration-300"
            onclick="event.stopPropagation()">
    </div>

    <script>
        function confirmSubmit(event, message) {
            event.preventDefault();
            const form = event.target.tagName === 'FORM' ? event.target : event.target.closest('form');
            if (!form) return;
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1e3a8a',
                cancelButtonColor: '#e11d48',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-slate-200',
                    confirmButton: 'rounded-xl font-bold px-6 py-2 bg-[#1e3a8a] text-white hover:bg-blue-800 transition-colors',
                    cancelButton: 'rounded-xl font-bold px-6 py-2 bg-rose-500 text-white hover:bg-rose-600 transition-colors',
                    actions: 'gap-3'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openImageModal(src) {
            const modal = document.getElementById('globalImageModal');
            const img = document.getElementById('globalImageModalSrc');

            const swalContainer = document.querySelector('.swal2-container');
            if (swalContainer) {
                swalContainer.style.opacity = '0';
                swalContainer.style.pointerEvents = 'none';
            }

            img.src = src;
            modal.classList.remove('hidden');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            img.classList.remove('scale-95');
            img.classList.add('scale-100');
        }

        function closeImageModal() {
            const modal = document.getElementById('globalImageModal');
            const img = document.getElementById('globalImageModalSrc');
            modal.classList.add('opacity-0');
            img.classList.remove('scale-100');
            img.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                img.src = '';

                const swalContainer = document.querySelector('.swal2-container');
                if (swalContainer) {
                    swalContainer.style.opacity = '1';
                    swalContainer.style.pointerEvents = 'auto';
                }
            }, 300);
        }

        function handleProfileClick(el, photoUrl) {
            let role = el.dataset.role;
            let name = el.dataset.name;
            let url = el.dataset.url;
            let finalPhotoUrl = photoUrl ? photoUrl : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(name) + '&background=1e3a8a&color=fff&size=128';

            let confirmBtn = role === 'peminjam' ? 'Profil Lengkap' : 'Tutup';
            let showCancel = role === 'peminjam';

            let htmlContent = '';
            if (role === 'umpeg') {
                htmlContent = `
                    <div class="text-center mt-2">
                        <p class="text-sm font-bold text-[#1e3a8a]">${el.dataset.jabatan}</p>
                        <p class="text-xs text-slate-600 font-medium mt-1">${el.dataset.nip}</p>
                    </div>
                `;
            } else {
                htmlContent = `
                    <div class="text-left mt-4 bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-inner space-y-3">
                        <div>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">Instansi</p>
                            <p class="text-sm font-semibold text-slate-800 leading-tight">${el.dataset.instansi}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">No. WhatsApp</p>
                            <p class="text-sm font-semibold text-slate-800 leading-tight">${el.dataset.wa}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">Alamat</p>
                            <p class="text-sm font-semibold text-slate-800 leading-tight">${el.dataset.alamat}</p>
                        </div>
                    </div>
                `;
            }

            Swal.fire({
                title: name,
                html: htmlContent,
                imageUrl: finalPhotoUrl,
                imageWidth: 90,
                imageHeight: 90,
                imageAlt: 'Foto Profil',
                showCancelButton: showCancel,
                confirmButtonText: confirmBtn,
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#1e3a8a',
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    image: 'rounded-full object-cover border-4 border-slate-100 shadow-sm mx-auto mb-1 cursor-pointer hover:scale-105 transition-transform',
                    confirmButton: 'rounded-xl font-bold px-4 py-2 bg-[#1e3a8a] text-white hover:bg-blue-800',
                    cancelButton: 'rounded-xl font-bold px-4 py-2 bg-slate-200 text-slate-700 hover:bg-slate-300'
                },
                buttonsStyling: false,
                didOpen: () => {
                    const img = Swal.getImage();
                    if (img) {
                        img.onclick = () => {
                            openImageModal(finalPhotoUrl);
                        };
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && role === 'peminjam' && url) {
                    window.location.href = url;
                }
            });
        }
    </script>
</body>

</html>