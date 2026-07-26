<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Inventaris</title>
    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 15px;
            color: #333;
            line-height: 1.6;
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

        .header-text h2 {
            font-size: 22px;
            font-weight: normal;
            margin: 0;
            color: #000;
            letter-spacing: 0.5px;
        }

        .header-text h3 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #000;
            letter-spacing: 1px;
        }

        .header-text p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #333;
        }

        .header-text p.email {
            margin: 2px 0 0 0;
            font-size: 13px;
        }

        .title-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .title-section h3 {
            margin: 0 0 5px 0;
            font-size: 20px;
            text-decoration: underline;
        }

        .title-section p {
            margin: 0;
            font-style: italic;
            color: #666;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 10px 8px;
            text-align: left;
            vertical-align: top;
        }

        .table th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
            text-transform: uppercase;
        }

        .table td {
            font-size: 14px;
        }

        .table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        .text-center {
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            background-color: #dcfce7;
            color: #166534;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
        }

        .footer-ttd {
            width: 100%;
            margin-top: 60px;
            page-break-inside: avoid;
            text-align: center;
        }

        .footer-ttd td {
            border: none;
            text-align: center;
            width: 50%;
            padding: 0;
            vertical-align: bottom;
        }

        .ttd-box {
            display: inline-block;
            width: 200px;
        }

        ul.barang-list {
            margin: 0;
            padding-left: 18px;
        }

        ul.barang-list li {
            margin-bottom: 3px;
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
                        $src = 'data:image/jpeg;base64,' . $imageData;
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

    <div class="title-section">
        <h3>LAPORAN PEMINJAMAN INVENTARIS</h3>
        <p>Periode:
            @if($bulan && $tahun) Bulan {{ str_pad($bulan, 2, '0', STR_PAD_LEFT) }} Tahun {{ $tahun }}
            @elseif($tahun) Tahun {{ $tahun }}
            @else Semua Waktu
            @endif
        </p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="14%">ID Transaksi</th>
                <th width="15%">Tanggal Pinjam</th>
                <th width="15%">Tanggal Kembali</th>
                <th width="22%">Peminjam</th>
                <th width="30%">Rincian Barang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center font-bold">{{ $trx->id }}</td>
                    <td class="text-center">
                        {{ strtolower(\Carbon\Carbon::parse($trx->tgl_pinjam)->translatedFormat('l j F Y H:i')) }}</td>
                    <td class="text-center">
                        {{ strtolower(\Carbon\Carbon::parse($trx->tgl_kembali)->translatedFormat('l j F Y H:i')) }}</td>
                    <td>
                        <strong>{{ $trx->peminjam->user->name ?? '-' }}</strong><br>
                        <span style="font-size: 12px; color: #333;">Instansi:
                            {{ $trx->peminjam->nama_instansi ?? $trx->peminjam->jenis_peminjam }}</span><br>
                        <span style="font-size: 12px; color: #333;">Alamat:
                            {{ $trx->peminjam->user->alamat ?? '-' }}</span>
                    </td>
                    <td>
                        <ul class="barang-list">
                            @foreach($trx->detailPeminjaman as $detail)
                                <li>
                                    <strong>{{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}</strong>
                                    <span style="color:#333;">({{ $detail->jumlah }} unit)</span>
                                    @if(isset($detail->barang->deskripsi))
                                        <div style="font-size: 12px; color:#555; margin-top: 2px;">Info: {{ $detail->barang->deskripsi }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 30px;">Tidak ada data transaksi selesai pada periode
                        yang dipilih.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="footer-ttd">
        <tr>
            <td style="vertical-align: bottom;">
                <div class="ttd-box">
                    Mengetahui,<br>
                    <strong>Umum Kepegawaian</strong>
                    <br><br><br><br><br>
                    <span style="text-decoration: underline; font-weight: bold; font-size: 14px;">NENI RUNINGDIYAH, S.KOM</span><br>
                    <span style="font-size: 13px; visibility: hidden;">Spacer</span>
                </div>
            </td>
            <td style="vertical-align: bottom;">
                <div class="ttd-box">
                    Cicalengka, {{ strtolower(\Carbon\Carbon::now()->translatedFormat('j F Y')) }}<br>
                    <strong>CAMAT CICALENGKA</strong><br>
                    <div style="margin: 5px 0;">
                        @php
                            $qrPath = public_path('img/qr-camat.png');
                            if(file_exists($qrPath)) {
                                $qrData = base64_encode(file_get_contents($qrPath));
                                $qrSrc = 'data:image/png;base64,' . $qrData;
                            } else {
                                $qrSrc = '';
                            }
                        @endphp
                        @if($qrSrc)
                            <img src="{{ $qrSrc }}" width="75" alt="QR TTD">
                        @else
                            <br><br><br><br>
                        @endif
                    </div>
                    <span style="text-decoration: underline; font-weight: bold; font-size: 14px;">CUCU HIDAYAT, S.H., M.M.</span><br>
                    <span style="font-size: 13px; color: #333;">NIP. 197107311998111001</span>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>