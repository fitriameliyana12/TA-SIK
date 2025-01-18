<?php

namespace App\Http\Controllers\Fisioterapis;

use App\Http\Controllers\Controller;
use App\Models\Fisioterapis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FisioterapisProfileController extends Controller
{
    /**
     * Menampilkan halaman profil fisioterapis.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Ambil data pasien yang terhubung dengan user
        $fisioterapis = auth()->user()->fisioterapis;

        // Kirim data pasien ke view
        return view('fisioterapis.profile.index', compact('fisioterapis'));
    }

    /**
     * Menampilkan halaman edit profil fisioterapis.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
{
    // Ambil data pengguna yang sedang login
    $user = auth()->user();
    
    // Ambil data pasien yang terhubung dengan user
    $fisioterapis = $user->fisioterapis;

    // Jika pasien tidak ditemukan
    if (!$fisioterapis) {
        return redirect()->route('dashboard')->with('error', 'Data pasien tidak ditemukan');
    }

    return view('fisioterapis.profile.edit-profile', compact('user', 'fisioterapis'));
}

    /**
     * Mengupdate data profil fisioterapis.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
{
    // Ambil user yang sedang login
    $user = auth()->user();

    // Validasi input
    $request->validate([
        'username' => 'required|string|max:255',
        'telepon' => 'required|string|max:15',
        'nama' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
        'alamat' => 'required|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'password' => 'nullable|string|min:6|confirmed', // Validasi password
    ]);

    // Update data user
    $user->update([
        'username' => $request->username,
        'telepon' => $request->telepon,
    ]);

    // Update password jika ada
    if ($request->filled('password')) {
        $user->update([
            'password' => bcrypt($request->password), // Hash password baru
        ]);
    }

    // Update data pasien
    $fisioterapis = $user->fisioterapis;
    $data = $request->only(['nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat']);

    if ($request->hasFile('foto')) {
        if(File::exists(public_path('storage/foto/'.$user->foto)))
        {
            File::delete(public_path('storage/foto/'.$user->foto));
        }
        $foto = $request->file('foto');
        $filename = time() . '.' . $foto->getClientOriginalExtension();

        $upload = Storage::disk('foto');
        $upload->put($filename, File::get($foto));

        $user->update([
            'foto' => $filename
        ]);
    }

    $fisioterapis->update($data);

    return redirect()->route('fisioterapis.profile.show')->with('success', 'Profil berhasil diperbarui!');
}


}
