<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Pasien; // Model Pasien
// use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class PasienController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
{
    $user = User::all();  // Ambil semua data user
    $data = [
        'users' => $user
    ];
    return view('pasien.dashboard', $data);  // Kirim data ke view
}

  public function showRiwayatTerapi()
  {
      // Mengambil data riwayat terapi pasien yang sedang login
      $riwayatTerapi = Antrian::where('id_pasien', Auth::user()->pasien->id_pasien)->get();


      // Mengirim data riwayat terapi ke view
      return view('riwayat-terapi', compact('riwayatTerapi'));
  }

  // Method untuk menampilkan antrian pasien
  public function antrian()
  {
    $antrian = Antrian::where('pasien_id', Auth::user()->pasien->id_pasien)->get();
    return view('pasien.antrian', compact('antrian'));
  }

    public function show()
    {
        // Ambil data pasien yang terhubung dengan user
        $pasien = auth()->user()->pasien;

        // Kirim data pasien ke view
        return view('pasien.profile', compact('pasien'));
    }


    public function edit()
{
    // Ambil data pengguna yang sedang login
    $user = auth()->user();
    
    // Ambil data pasien yang terhubung dengan user
    $pasien = $user->pasien;

    // // Jika pasien tidak ditemukan
    // if (!$pasien) {
    //     return redirect()->route('dashboard')->with('error', 'Data pasien tidak ditemukan');
    // }

    return view('pasien.edit-profile', compact('user', 'pasien'));
}

public function editProfile()
{
    $user = Auth::user(); // Mengambil data pengguna yang sedang login
    $pasien = $user->pasien; // Mengambil data pasien terkait dengan user

    return view('pasien.edit-profile', compact('user', 'pasien'));
}

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
        'telepon' => $request->telepon
    ]);

    // Update password jika ada
    if ($request->filled('password')) {
        $user->update([
            'password' => bcrypt($request->password), // Hash password baru
        ]);
    }
    
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

    // Update data pasien
    $pasien = $user->pasien;
    $data = $request->only(['nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat']);

    if($pasien){
        $pasien->update($data);
    }else{
        $row = DB::table('pasien')->selectRaw("max(no_rekam_medis) as kodeTerbesar")->first();
        $no_rekam_medis = $row->kodeTerbesar;

        $urutan = (int) substr($no_rekam_medis, 4, 4);
        $urutan++;
        
        $no_rekam_medis = "KFG-" . sprintf("%04s", $urutan);

        $data['no_rekam_medis'] = $no_rekam_medis;
        $data['id_user'] = $user->id_user;
        Pasien::create($data);
    }

    return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
}


}



