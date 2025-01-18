<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'telepon' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $user->username = $request->username;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->nama_lengkap = $request->nama_lengkap;
        $user->alamat = $request->alamat;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->tanggal_lahir = $request->tanggal_lahir;
        $user->telepon = $request->telepon;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('profile_pictures', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    public function store(Request $request)
{
    // Validasi data
    $validated = $request->validate([
        'username' => 'required|unique:users,username',
        'password' => 'required|min:6',
        'nama_lengkap' => 'required',
        'alamat' => 'required',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'tanggal_lahir' => 'required|date',
        'telepon' => 'required|numeric',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Upload foto jika ada
    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('foto_profil', 'public');
    }

    // Simpan data ke tabel users
    $user = User::create([
        'username' => $validated['username'],
        'password' => bcrypt($validated['password']),
        'role' => 'pasien', // Default untuk pasien
    ]);

    // Simpan data ke tabel pasien
    Pasien::create([
        'user_id' => $user->id, // Relasi ke user
        'nama' => $validated['nama_lengkap'],
        'alamat' => $validated['alamat'],
        'jenis_kelamin' => $validated['jenis_kelamin'],
        'tanggal_lahir' => $validated['tanggal_lahir'],
        'telepon' => $validated['telepon'],
        'foto' => $fotoPath ?? null, // Jika ada foto
    ]);

    return redirect()->route('profile.index')->with('success', 'Profil berhasil disimpan!');
}

}

