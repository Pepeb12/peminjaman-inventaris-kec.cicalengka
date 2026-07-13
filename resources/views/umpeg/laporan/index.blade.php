@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 uppercase tracking-tight">Cetak Laporan</h2>
            <p class="text-sm text-slate-500 mt-1">Unduh laporan transaksi peminjaman dalam format PDF atau CSV.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden max-w-2xl">
        <div class="p-6 border-b border-slate-200 bg-white">
            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Filter & Download Laporan
            </h3>
        </div>

        <div class="p-6">
            @if($errors->any())
                <div class="bg-rose-50 text-rose-600 px-4 py-3 rounded-xl mb-4 text-sm font-medium border border-rose-100">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('umpeg.laporan.cetak') }}" method="POST" target="_blank" id="formLaporan">
                @csrf

                <div class="space-y-5 mb-8">
                    <div>
                        <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Bulan Transaksi
                            (Opsional)</label>
                        <select name="bulan"
                            class="w-full bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm appearance-none">
                            <option value="">-- Semua Bulan --</option>
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $bulan)
                                <option value="{{ $index + 1 }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 text-xs font-bold uppercase tracking-wide mb-1.5">Tahun Transaksi
                            (Opsional)</label>
                        <input type="number" name="tahun" value="{{ date('Y') }}" min="2000"
                            class="w-full bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 shadow-sm">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 border-t border-slate-100 pt-6">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-md flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Unduh PDF
                    </button>
                    <button type="button" onclick="downloadCsv()"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-md flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Unduh CSV (Excel)
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function downloadCsv() {
            const form = document.getElementById('formLaporan');
            const originalAction = form.action;
            const originalMethod = form.method;
            const originalTarget = form.target;

            // Ubah form action ke CSV (GET request)
            form.action = "{{ route('umpeg.laporan.exportCsv') }}";
            form.method = "GET";
            form.target = "_self";

            form.submit();

            // Kembalikan form ke kondisi semula setelah delay sebentar
            setTimeout(() => {
                form.action = originalAction;
                form.method = originalMethod;
                form.target = originalTarget;
            }, 100);
        }
    </script>
@endsection