<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Anda</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-w-md mx-auto p-4 border rounded shadow-sm bg-gray-50">
        <h2 style="color: #064e3b;">Reset Password</h2>
        <p>Anda menerima email ini karena ada permintaan untuk mereset kata sandi akun Anda.</p>
        <p>Gunakan kode OTP berikut untuk memverifikasi permintaan Anda:</p>
        
        <div style="text-align: center; margin: 20px 0;">
            <span style="font-size: 24px; font-weight: bold; background: #e2e8f0; padding: 10px 20px; border-radius: 8px; letter-spacing: 4px;">{{ $otpCode }}</span>
        </div>
        
        <p>Kode ini hanya berlaku selama <strong>15 menit</strong>.</p>
        <p style="font-size: 12px; color: #777;">Jika Anda tidak merasa meminta reset password, abaikan email ini. Akun Anda tetap aman.</p>
    </div>
</body>
</html>
