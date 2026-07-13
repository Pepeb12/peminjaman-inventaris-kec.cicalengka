<?php

namespace App\Http\Controllers\Umpeg;

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
        return view('umpeg.profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto_profil.image' => 'Berkas harus berupa gambar.',
            'foto_profil.max' => 'Ukuran foto maksimal 2MB.'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;
        $user->alamat = $request->alamat;

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $fotoPath = $request->file('foto_profil')->store('profil', 'public');
            $user->foto_profil = $fotoPath;
        }

        $user->save();

        return redirect()->route('umpeg.profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
