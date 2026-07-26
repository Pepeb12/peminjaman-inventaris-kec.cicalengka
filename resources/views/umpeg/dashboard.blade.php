@extends('layouts.app')

@section('content')


<!-- STATISTIK UTAMA -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
 <div class="bg-white border border-slate-300 p-5 rounded-sm transition-all relative overflow-hidden group">
 <div class="flex justify-between items-start relative z-10">
 <div>
 <p class="text-blue-800 font-bold text-[10px] uppercase tracking-widest mb-1">Total Barang</p>
 <h2 class="text-3xl font-extrabold text-slate-900">{{ $totalBarang ?? 0 }}</h2>
 </div>
 <div class="p-2 bg-blue-50 rounded-md text-blue-600 border border-blue-100">
 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
 </div>
 </div>
 </div>
 
 <div class="bg-white border border-slate-300 p-5 rounded-sm transition-all relative overflow-hidden group">
 <div class="flex justify-between items-start relative z-10">
 <div>
 <p class="text-amber-700 font-bold text-[10px] uppercase tracking-widest mb-1">Menunggu Validasi</p>
 <h2 class="text-3xl font-extrabold text-slate-900">{{ $menunggu ?? 0 }}</h2>
 </div>
 <div class="p-2 bg-amber-50 rounded-md text-amber-600 border border-amber-100">
 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
 </div>
 </div>
 </div>

 <div class="bg-white border border-slate-300 p-5 rounded-sm transition-all relative overflow-hidden group">
 <div class="flex justify-between items-start relative z-10">
 <div>
 <p class="text-indigo-700 font-bold text-[10px] uppercase tracking-widest mb-1">Sedang Dipinjam</p>
 <h2 class="text-3xl font-extrabold text-slate-900">{{ $dipinjam ?? 0 }}</h2>
 </div>
 <div class="p-2 bg-indigo-50 rounded-md text-indigo-600 border border-indigo-100">
 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
 </div>
 </div>
 </div>

 <div class="bg-white border border-slate-300 p-5 rounded-sm transition-all relative overflow-hidden group">
 <div class="flex justify-between items-start relative z-10">
 <div>
 <p class="text-emerald-700 font-bold text-[10px] uppercase tracking-widest mb-1">Total Peminjam</p>
 <h2 class="text-3xl font-extrabold text-slate-900">{{ $totalPeminjam ?? 0 }}</h2>
 </div>
 <div class="p-2 bg-emerald-50 rounded-md text-emerald-600 border border-emerald-100">
 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
 </div>
 </div>
 </div>
</div>

<div class="mb-8">
 <!-- GRAFIK PEMINJAMAN -->
 <div class="bg-white border border-slate-300 rounded-sm p-6 mb-6">
 <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-4">Tren Peminjaman (6 Bulan Terakhir)</h3>
 <div class="relative h-[300px] w-full">
 <canvas id="peminjamanChart"></canvas>
 </div>
 </div>

 <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
 <!-- STATISTIK STATUS -->
 <div class="bg-white border border-slate-300 rounded-sm p-6">
 <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-4">Breakdown Status</h3>
 <div class="space-y-4">
 <div class="flex justify-between items-center">
 <div class="flex items-center gap-2">
 <div class="w-3 h-3 rounded-full bg-amber-500"></div>
 <span class="text-sm text-slate-600 font-medium">Menunggu</span>
 </div>
 <span class="text-sm font-bold text-slate-900">{{ $statusBreakdown['Menunggu'] ?? 0 }}</span>
 </div>
 <div class="flex justify-between items-center">
 <div class="flex items-center gap-2">
 <div class="w-3 h-3 rounded-full bg-indigo-500"></div>
 <span class="text-sm text-slate-600 font-medium">Dipinjam</span>
 </div>
 <span class="text-sm font-bold text-slate-900">{{ $statusBreakdown['Dipinjam'] ?? 0 }}</span>
 </div>
 <div class="flex justify-between items-center">
 <div class="flex items-center gap-2">
 <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
 <span class="text-sm text-slate-600 font-medium">Selesai</span>
 </div>
 <span class="text-sm font-bold text-slate-900">{{ $statusBreakdown['Selesai'] ?? 0 }}</span>
 </div>
 <div class="flex justify-between items-center">
 <div class="flex items-center gap-2">
 <div class="w-3 h-3 rounded-full bg-rose-500"></div>
 <span class="text-sm text-slate-600 font-medium">Ditolak</span>
 </div>
 <span class="text-sm font-bold text-slate-900">{{ $statusBreakdown['Ditolak'] ?? 0 }}</span>
 </div>
 </div>
 </div>

 <!-- BARANG PALING SERING DIPINJAM -->
 <div class="bg-white border border-slate-300 rounded-sm p-6">
 <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide mb-4">Barang Paling Sering Dipinjam</h3>
 <div class="space-y-3">
 @forelse($topBarang as $tb)
 <div class="bg-slate-50 border border-slate-200 p-3 rounded-sm flex justify-between items-center">
 <p class="text-xs font-bold text-slate-900 line-clamp-1">{{ $tb->nama_barang }}</p>
 <p class="text-[10px] text-slate-600 font-bold bg-white px-2 py-1 rounded border border-slate-200 shrink-0">{{ $tb->total_dipinjam }} Unit</p>
 </div>
 @empty
 <p class="text-xs text-slate-500 text-center py-4">Belum ada data barang dipinjam.</p>
 @endforelse
 </div>
 </div>
 </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
 document.addEventListener('DOMContentLoaded', function() {
 const ctx = document.getElementById('peminjamanChart').getContext('2d');
 
 // Gradient for chart line
 let gradient = ctx.createLinearGradient(0, 0, 0, 400);
  gradient.addColorStop(0, 'rgba(37, 99, 235, 0.5)'); // Blue 600 transparent
  gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)'); // Blue transparent

 new Chart(ctx, {
 type: 'line',
 data: {
 labels: {!! json_encode($chartBulan ?? []) !!},
 datasets: [{
 label: 'Total Peminjaman',
 data: {!! json_encode($chartData ?? []) !!},
 borderColor: '#2563eb',
 backgroundColor: gradient,
 borderWidth: 3,
 pointBackgroundColor: '#60a5fa',
 pointBorderColor: '#fff',
 pointBorderWidth: 2,
 pointRadius: 5,
 pointHoverRadius: 7,
 fill: true,
 tension: 0.4
 }]
 },
 options: {
 responsive: true,
 maintainAspectRatio: false,
 plugins: {
 legend: {
 display: false
 },
 tooltip: {
 backgroundColor: 'rgba(15, 23, 42, 0.9)',
 titleFont: { size: 13, family: 'Inter' },
 bodyFont: { size: 12, family: 'Inter' },
 padding: 10,
 cornerRadius: 8,
 displayColors: false,
 }
 },
 scales: {
 y: {
 beginAtZero: true,
 ticks: {
 stepSize: 1,
 font: { family: 'Inter', size: 11 },
 color: '#64748b'
 },
 grid: {
 color: 'rgba(226, 232, 240, 0.5)',
 drawBorder: false,
 }
 },
 x: {
 ticks: {
 font: { family: 'Inter', size: 11 },
 color: '#64748b'
 },
 grid: {
 display: false,
 drawBorder: false,
 }
 }
 },
 interaction: {
 intersect: false,
 mode: 'index',
 },
 }
 });
 });
</script>
@endsection