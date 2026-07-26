<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1e3a8a;
            font-size: 24px;
            margin: 0;
        }
        .content {
            color: #333333;
            line-height: 1.6;
            font-size: 16px;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            text-align: center;
            font-size: 14px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pemberitahuan Resmi</h1>
            <p style="color: #666; margin-top: 5px; font-size: 14px;">Inventaris Kecamatan Cicalengka</p>
        </div>
        
        <div class="content">
{{ $pesan }}
        </div>
        
        <div class="footer">
            <p>Pesan ini dihasilkan secara otomatis oleh Sistem Informasi Peminjaman Barang Inventaris Kecamatan Cicalengka. Mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
