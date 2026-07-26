<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peminjam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordOtpMail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->with('error', 'Alamat email tidak terdaftar dalam sistem kami.');
        }

        // Cek apakah ada request OTP dalam 1 menit terakhir
        // Dihapus sesuai permintaan: langsung kode terkirim dan jangan harap tunggu beberapa saat
        // if ($user->otp_expires_at && Carbon::parse($user->otp_expires_at)->subMinutes(1) > now()) {
        //     return back()->with('error', 'Harap tunggu beberapa saat sebelum meminta OTP baru.');
        // }


        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(2);
        $user->save();

        try {
            // Kirim via Email
            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp));

            // Simpan id user ke session untuk tahap selanjutnya
            session(['reset_user_id' => $user->id]);
            return redirect()->route('password.verify')->with('success', 'Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem saat mengirim OTP: ' . $e->getMessage());
        }
    }

    public function showVerifyForm()
    {
        if (!session()->has('reset_user_id')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $userId = session('reset_user_id');
        if (!$userId) {
            return redirect()->route('password.request')->with('error', 'Sesi Anda telah berakhir, silakan ulangi.');
        }

        $user = User::find($userId);

        if (!$user || !$user->otp_code || $user->otp_code !== $request->otp) {
            return back()->with('error', 'Kode OTP tidak valid atau salah.');
        }

        if (Carbon::parse($user->otp_expires_at)->isPast()) {
            return back()->with('error', 'Kode OTP telah kadaluarsa. Silakan minta kode baru.');
        }

        // OTP valid, simpan penanda di session
        session(['otp_verified' => true]);
        return redirect()->route('password.reset');
    }

    public function showResetForm()
    {
        if (!session('otp_verified') || !session('reset_user_id')) {
            return redirect()->route('password.request')->with('error', 'Akses tidak sah.');
        }
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session('otp_verified') || !session('reset_user_id')) {
            return redirect()->route('password.request')->with('error', 'Akses tidak sah.');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::find(session('reset_user_id'));

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();
        }

        // Hapus session
        session()->forget(['reset_user_id', 'otp_verified']);

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login menggunakan password baru.');
    }
}
