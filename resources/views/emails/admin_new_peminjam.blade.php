<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Peminjam Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #0056b3;">Pendaftaran Akun Peminjam Baru</h2>
        
        <p>Halo Admin,</p>
        <p>Terdapat pendaftaran akun baru pada sistem inventaris dengan rincian sebagai berikut:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Nama Lengkap</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $user->name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>NIK</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $peminjam->nik }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Email</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $user->email }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Jenis Peminjam</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $peminjam->jenis_peminjam }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Instansi/Asal</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $peminjam->nama_instansi ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border-bottom: 1px solid #eee;"><strong>Kontak Penanggung Jawab</strong></td>
                <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $peminjam->kontak_penanggung_jawab }}</td>
            </tr>
        </table>
        
        <p>Silakan login ke dashboard sistem untuk meninjau dan memutuskan apakah akun ini disetujui atau tidak.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('umpeg.peminjam.index') }}" style="background-color: #0056b3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Ke Halaman Persetujuan</a>
        </div>
        
        <p style="font-size: 12px; color: #777; margin-top: 30px; text-align: center;">
            Email ini dikirim secara otomatis oleh Sistem Inventaris Kecamatan Cicalengka.
        </p>
    </div>
</body>
</html>
