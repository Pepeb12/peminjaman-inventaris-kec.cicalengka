<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peminjam = $user->peminjam;
        
        return view('peminjam.profil.index', compact('user', 'peminjam'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'nama_instansi' => 'required|string|max:255',
            'jenis_peminjam' => 'required|string|max:100',
            'kontak_penanggung_jawab' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'foto_profil.required' => 'Upload foto profil bersifat wajib.',
            'foto_profil.image' => 'Berkas harus berupa gambar.',
            'foto_profil.max' => 'Ukuran foto maksimal 2MB.'
        ]);

        $user = Auth::user();
        
        // Update data user (Penanggung Jawab & Alamat)
        $user->name = ucwords(strtolower($request->name));
        if ($request->has('alamat')) {
            $user->alamat = $request->alamat;
        }

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $fotoPath = $request->file('foto_profil')->store('profil', 'public');
            $user->foto_profil = $fotoPath;
        }
        $user->save();

        // Update data profil peminjam
        if ($user->peminjam) {
            $user->peminjam->update([
                'nama_instansi' => $request->nama_instansi,
                'jenis_peminjam' => $request->jenis_peminjam,
                'kontak_penanggung_jawab' => $request->kontak_penanggung_jawab,
            ]);
        }

        return back()->with('success', 'Profil instansi dan kontak berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error_password', 'Password saat ini tidak sesuai.');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success_password', 'Password berhasil diubah.');
    }
}
