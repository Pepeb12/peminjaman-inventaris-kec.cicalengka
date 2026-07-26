<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peminjam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek jika peminjam belum disetujui
            if ($user->role === 'peminjam' && $user->peminjam && !$user->peminjam->is_verified) {
                $status = $user->peminjam->status_akun;
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                if ($status === 'Ditolak') {
                    return back()->withErrors(['email' => 'Akun Anda telah ditolak oleh admin'])->onlyInput('email');
                }
                
                return back()->withErrors(['email' => 'Akun Anda belum disetujui oleh Umum Kepegawaian, harap tunggu proses verifikasi'])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Cek role dan arahkan ke dashboard yang sesuai
            if ($user->role === 'umpeg') {
                return redirect()->intended('/umpeg/dashboard');
            }
            
            return redirect()->intended('/peminjam/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Cek jika NIK dan No WA sama sudah terdaftar
        $existing = \App\Models\Peminjam::where('nik', $request->nik)
            ->where('kontak_penanggung_jawab', $request->kontak_penanggung_jawab)
            ->first();

        if ($existing) {
            return back()->withErrors(['nik' => 'Akun dengan NIK dan No WA ini sudah pernah didaftarkan'])->withInput();
        }

        $messages = [
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK telah digunakan',
            'password.confirmed' => 'Password tidak sesuai',
            'password.regex' => 'Password harus mengandung kombinasi huruf besar, huruf kecil, dan angka',
            'email.unique' => 'Email telah digunakan'
        ];

        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nik' => 'required|string|size:16|unique:peminjams,nik',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'jenis_peminjam' => 'required|string',
            'nama_instansi' => 'nullable|string|max:255',
            'kontak_penanggung_jawab' => 'required|string|max:20',
            'alamat' => 'required|string',
        ], $messages);

        // Insert ke 2 tabel menggunakan Database Transaction
        $data = DB::transaction(function () use ($request) {
            $formattedName = ucwords(strtolower($request->name));

            $user = User::create([
                'name' => $formattedName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'peminjam', // Paksa set role peminjam saat register publik
                'alamat' => $request->alamat,
            ]);

            $peminjam = Peminjam::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'jenis_peminjam' => $request->jenis_peminjam,
                'nama_instansi' => $request->nama_instansi,
                'kontak_penanggung_jawab' => $request->kontak_penanggung_jawab,
            ]);

            return ['user' => $user, 'peminjam' => $peminjam];
        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda sedang menunggu ACC Umum Kepegawaian');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}