<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #1e3a8a;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
            color: #334155;
            line-height: 1.6;
        }
        .otp-box {
            background-color: #f8fafc;
            border: 2px dashed #94a3b8;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
            font-size: 32px;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 5px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Inventaris Kecamatan Cicalengka</h1>
        </div>
        <div class="content">
            <p>Halo,</p>
            <p>Kami menerima permintaan untuk mereset kata sandi akun Anda. Gunakan kode OTP berikut untuk melanjutkan proses reset kata sandi:</p>
            
            <div class="otp-box">
                {{ $otp }}
            </div>
            
            <p>Kode ini hanya berlaku selama <strong>2 menit</strong>. Jangan berikan kode ini kepada siapa pun untuk alasan keamanan.</p>
            <p>Jika Anda tidak meminta reset kata sandi, Anda dapat mengabaikan email ini.</p>
            
            <p style="margin-top: 30px;">Terima kasih,<br><strong>Sistem Inventaris Kecamatan Cicalengka</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Inventaris Kecamatan Cicalengka. Hak Cipta Dilindungi.
        </div>
    </div>
</body>
</html>
