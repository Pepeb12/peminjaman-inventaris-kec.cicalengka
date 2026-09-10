<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <title>Bukti Peminjaman - {{ $peminjaman->id_peminjaman }}</title>
 <style>
 @page { margin: 40px; }
 body { 
 font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
 font-size: 12px; 
 color: #333;
 line-height: 1.5;
 }
 .header {
 width: 100%;
 margin-bottom: 25px;
 }
 .header-table {
 width: 100%;
 border-bottom: 3px solid #000;
 margin-bottom: 2px;
 }
 .header-table td {
 border: none;
 padding: 0;
 vertical-align: middle;
 }
 .header-line {
 border-bottom: 1px solid #000;
 margin-bottom: 20px;
 }
 .header-text {
 text-align: center;
 }
 .header-text h2 { font-size: 18px; font-weight: normal; margin: 0; color: #000; letter-spacing: 0.5px;}
 .header-text h3 { font-size: 20px; font-weight: bold; margin: 0; color: #000; letter-spacing: 1px;}
 .header-text p { margin: 5px 0 0 0; font-size: 11px; color: #333; }
 .header-text p.email { margin: 2px 0 0 0; font-size: 10px; }
 
 .title { text-align: center; margin-bottom: 30px; }
 .title h4 { font-size: 16px; text-decoration: underline; margin: 0 0 5px 0; }
 .title p { margin: 0; font-weight: bold; font-size: 14px; }
 
 .info-table { width: 100%; margin-bottom: 30px; }
 .info-table td { padding: 5px; vertical-align: top; }
 .info-table .label { width: 150px; font-weight: bold; color: #555; }
 .info-table .colon { width: 10px; }
 
 .items-table { 
 width: 100%; 
 border-collapse: collapse; 
 margin-bottom: 40px; 
 }
 .items-table th, .items-table td { 
 border: 1px solid #cbd5e1; 
 padding: 10px; 
 text-align: left; 
 }
 .items-table th { 
 background-color: #f1f5f9; 
 color: #1e293b;
 font-weight: bold;
 text-transform: uppercase;
 font-size: 11px;
 }
 .items-table td.center { text-align: center; }
 
 .footer { width: 100%; margin-top: 50px; page-break-inside: avoid; }
 .footer td { text-align: center; width: 33%; padding: 0; vertical-align: bottom; }
 .ttd-box { display: inline-block; width: 100%; }
 .note { 
 margin-top: 40px; 
 padding: 15px; 
 background-color: #fff; 
 border: 1px solid #000; 
 font-size: 11px;
 color: #000;
 }
 </style>
</head>
<body>

 <div class="header">
 <table class="header-table">
 <tr>
 <td width="15%" style="text-align: center; padding-bottom: 10px;">
 @php
 $imagePath = public_path('img/logo rapih.jpg');
 $imageData = base64_encode(file_get_contents($imagePath));
 $src = 'data:image/jpeg;base64,'.$imageData;
 @endphp
 <img src="{{ $src }}" width="80"  alt="Logo">
 </td>
 <td width="70%" class="header-text" style="padding-bottom: 10px; text-align: center;">
 <h2>PEMERINTAH KABUPATEN BANDUNG</h2>
 <h3>KECAMATAN CICALENGKA</h3>
 <p>Jl. Raya Timur Cicalengka No. 344 Kabupaten Bandung Telp. 022 7949205</p>
 <p class="email">Gmail : kec.cicalengka@bandungkab.go.id</p>
 </td>
 <td width="15%"></td>
 </tr>
 </table>
 <div class="header-line"></div>
 </div>

 <div class="title">
 <h4>BUKTI PEMINJAMAN INVENTARIS</h4>
 <p>No. Resi: {{ $peminjaman->id_peminjaman }}</p>
 </div>

 <table class="info-table">
 <tr>
 <td class="label">Nama Instansi/Pemohon</td>
 <td class="colon">:</td>
 <td>{{ $peminjaman->peminjam->nama_instansi ?? $peminjaman->peminjam->jenis_peminjam }}</td>
 
 <td class="label">Tanggal Pinjam</td>
 <td class="colon">:</td>
 <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('j F Y') }}</td>
 </tr>
 <tr>
 <td class="label">Penanggung Jawab</td>
 <td class="colon">:</td>
 <td>{{ $peminjaman->peminjam->user->name ?? '-' }}</td>
 
 <td class="label">Tanggal Kembali</td>
 <td class="colon">:</td>
 <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->translatedFormat('j F Y') }}</td>
 </tr>
 <tr>
 <td class="label">Nomor WhatsApp</td>
 <td class="colon">:</td>
 <td>{{ $peminjaman->peminjam->kontak_penanggung_jawab ?? '-' }}</td>
 
 <td class="label">Status</td>
 <td class="colon">:</td>
 <td style="font-weight:bold; color: #15803d;">TELAH DISETUJUI</td>
 </tr>
 </table>

 <table class="items-table">
 <thead>
 <tr>
 <th width="5%" class="center">No</th>
 <th width="20%">Kode Barang</th>
 <th width="60%">Nama Barang</th>
 <th width="15%" class="center">Jumlah</th>
 </tr>
 </thead>
 <tbody>
 @foreach($peminjaman->detailPeminjaman as $index => $detail)
 <tr>
 <td class="center">{{ $index + 1 }}</td>
 <td>{{ $detail->kode_barang }}</td>
 <td>
 <strong>{{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}</strong>
 @if(isset($detail->barang->deskripsi))
     <div style="font-size: 11px; color:#555; margin-top: 2px;">Info: {{ $detail->barang->deskripsi }}</div>
 @endif
 </td>
 <td class="center"><strong>{{ $detail->jumlah }}</strong> Unit</td>
 </tr>
 @endforeach
 </tbody>
 </table>

 <table class="footer" style="width: 100%; margin-top: 50px; page-break-inside: avoid; text-align: center;">
 <tr>
 <td style="width: 50%; vertical-align: bottom;">
 <div class="ttd-box">
 <br>
 <strong>Peminjam,</strong><br>
 <br><br><br><br><br>
 <span style="text-decoration: underline; font-weight: bold;">( {{ $peminjaman->peminjam->user->name ?? '....................................' }} )</span>
 </div>
 </td>
 <td style="width: 50%; vertical-align: bottom;">
 <div class="ttd-box">
 Cicalengka, {{ strtolower(\Carbon\Carbon::now()->translatedFormat('l j F Y')) }}<br>
 Petugas Umum Kepegawaian,<br>
 <br><br><br><br><br>
 <span style="text-decoration: underline; font-weight: bold;">( Neni Runingdyah, S.kom )</span>
 </div>
 </td>
 </tr>
 </table>

 <div class="note">
 <strong>Catatan Penting:</strong>
 <ul style="margin: 5px 0 0 0; padding-left: 20px;">
 <li>Harap bawa lembar bukti ini saat mengambil fisik barang di Kecamatan.</li>
 <li>Barang yang dipinjam menjadi tanggung jawab penuh pihak peminjam.</li>
 <li>Segala bentuk kerusakan atau kehilangan wajib diganti atau diperbaiki oleh peminjam.</li>
 <li>Harap kembalikan barang tepat waktu sesuai tanggal rencana pengembalian.</li>
 </ul>
 </div>

</body>
</html>
