<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fisioterapis\FisioterapisRequest;
use App\Models\Fisioterapis;
use App\Models\User;
use Illuminate\Http\Request;

class AdminFisioterapisController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai pencarian
        $search = $request->get('search');

        // Ambil data fisioterapis berdasarkan pencarian
        $fisioterapis = Fisioterapis::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('tanggal_lahir', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('jenis_kelamin', 'like', "%{$search}%")
                    ->orWhere('kehadiran', 'like', "%{$search}%");
            })
            ->get();

        // Kirim data ke view
        return view('admin.fisioterapis.index', compact('fisioterapis'));
    }

    public function create()
    {
        // Mengambil semua data user
        $users = User::all();  // Mengambil semua user untuk dropdown

        // Mengirim data 'users' ke view
        return view('admin.fisioterapis.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
            'id_user' => 'required|exists:user,id_user',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'kehadiran' => 'required|in:Hadir,Izin',
        ]);
    
        // Simpan data ke dalam database
        Fisioterapis::create([
            'nama' => $request->nama,
            'id_user' => $request->id_user,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kehadiran' => $request->kehadiran,
        ]);
    
        // Redirect dengan pesan sukses
        return redirect()->route('admin-fisioterapis.index')->with('success', 'Data fisioterapis berhasil ditambahkan.');
    }


    public function show($id)
    {
        $fisioterapis = Fisioterapis::with('user')->findOrFail($id); // Mengambil data fisioterapis beserta user yang terkait
        return view('admin.fisioterapis.show', compact('fisioterapis'));
    }

    public function edit(Fisioterapis $admin_fisioterapi)
    {
        // Menyediakan data untuk form edit
        $data = [
            'fisioterapis' => $admin_fisioterapi
        ];
        return view('admin.fisioterapis.edit', $data);
    }

    public function update(Request $request, Fisioterapis $admin_fisioterapi)
    {
        // Validasi data input
        $validatedData = $request->all();

        // Update data fisioterapis
        $admin_fisioterapi->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('admin-fisioterapis.index')->with('success', 'Data Fisioterapis berhasil diperbarui!');
    }

    public function destroy(Fisioterapis $admin_fisioterapi)
    {
        // Hapus data fisioterapis
        $admin_fisioterapi->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin-fisioterapis.index')->with('success', 'Data Fisioterapis berhasil dihapus!');
    }
}