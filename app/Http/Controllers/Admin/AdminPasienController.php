<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pasien\PasienRequest;
use App\Models\Pasien;
use App\Models\User; // Tambahkan import model User
use Illuminate\Http\Request;

class AdminPasienController extends Controller
{
    public function index(Request $request)
    {
      // Ambil nilai pencarian
    $search = $request->get('search');

    // Ambil data pasien berdasarkan pencarian
    $pasien = Pasien::query()
        ->when($search, function ($query) use ($search) {
          $query->where('no_rekam_medis', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%")
                ->orWhere('tanggal_lahir', 'like', "%{$search}%")
                ->orWhere('jenis_kelamin', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%");
        })
        ->get();

    // Ambil telepon dari tabel user yang terkait dengan pasien
    foreach ($pasien as $p) {
        $p->telepon_user = $p->user ? $p->user->telepon : null; // Menambahkan telepon dari tabel user
    }

    // Kirim data ke view
    return view('admin.pasien.index', compact('pasien'));
    }

    public function create()
{
    // Mengambil semua data user
    $users = User::all();  // Mengambil semua user untuk dropdown

    // Mengirim data 'users' ke view
    return view('admin.pasien.create', compact('users'));
}

    public function store(PasienRequest $request)
    {
      // Menambahkan data pasien dengan data user yang sudah dipilih
    $validatedData = $request->all();
    
    // Pastikan data 'id_user' sudah ada
    if ($request->has('id_user')) {
        $validatedData['id_user'] = $request->id_user;
    }

    // Simpan data pasien
    $pasien = Pasien::create($validatedData);

    return redirect()->route('admin-pasien.index')->with('success', 'Berhasil Menambah Data Baru');
    }

    public function show($id)
    {
      $pasien = Pasien::with('user')->findOrFail($id); // Mengambil data pasien beserta user yang terkait
      return view('admin.pasien.show', compact('pasien'));
    }

    public function edit(Pasien $admin_pasien)
    {
        $data = [
            'pasien' => $admin_pasien
        ];
        return view('admin.pasien.edit', $data);
    }

    public function update(Request $request, Pasien $admin_pasien)
    {
        $validatedData = $request->all();
        $admin_pasien->update($validatedData);
        return redirect()->route('admin-pasien.index')->with('success', 'Data Pasien berhasil diperbarui!');
    }

    public function destroy(Pasien $admin_pasien)
    {
        $admin_pasien->delete();
        return redirect()->route('admin-pasien.index')->with('success', 'Data Pasien berhasil dihapus!');
    }
}
