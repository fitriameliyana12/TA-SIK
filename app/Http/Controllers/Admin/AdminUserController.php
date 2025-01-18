<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
  public function index(Request $request)
    {
      // Ambil nilai pencarian
    $search = $request->get('search');

    // Ambil data user berdasarkan pencarian
    $user = User::query()
        ->when($search, function ($query) use ($search) {
          $query->where('username', 'like', "%{$search}%")
                ->orWhere('telepon', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%");
        })
        ->get();

    // Kirim data ke view
    return view('admin.user.index', compact('user'));
    }
  

  public function create()
  {
    return view('admin.user.create');
  }

  // Method untuk menyimpan data user baru
  public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'username' => 'required|string|max:255|unique:user',
        'password' => 'required|string|min:8|confirmed', // Menggunakan aturan 'confirmed' untuk password
        'telepon' => 'required|string|max:15',
        'role' => 'required|string|in:admin,fisioterapis,pasien',
    ]);

    // Jika validasi berhasil, simpan data pengguna baru
    $user = new User();
    $user->username = $request->username;
    $user->password = bcrypt($request->password); // Simpan password yang telah di-hash
    $user->telepon = $request->telepon;
    $user->role = $request->role;

    // Simpan foto jika ada
    if ($request->hasFile('foto')) {
        $user->foto = $request->file('foto')->store('photos');
    } else {
        $user->foto = null; // Set null jika tidak ada foto
    }

    $user->save();

    return redirect()->route('admin-user.index')->with('success', 'User created successfully');
}


  public function show(User $admin_user)
  {
    $data = [
      'user' => $admin_user
    ];
    return view('admin.user.show', $data);
  }

  public function edit(User $admin_user)
  {
    $data = [
      'user' => $admin_user
    ];
    return view('admin.user.edit', $data);
  }

  public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8', // Nullable jika tidak ingin mengubah password
            'role' => 'required|in:admin,fisioterapis,pasien',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cari data user berdasarkan ID
        $user = User::findOrFail($id);

        // Ambil password lama jika field password tidak diisi
        $password = $request->filled('password') 
            ? bcrypt($request->input('password')) // Hash password baru
            : $user->password; // Gunakan password lama

        // Update data user
        $user->update([
            'username' => $request->input('username'),
            'password' => $password,
            'role' => $request->input('role'),
            'foto' => $request->file('foto') 
                ? $request->file('foto')->store('images') // Simpan foto baru jika diupload
                : $user->foto, // Gunakan foto lama jika tidak ada upload
        ]);

        // Redirect ke halaman admin-user dengan pesan sukses
        return redirect()->route('admin-user.index')->with('success', 'User updated successfully.');
    }
 
   public function destroy(User $admin_user)
   {
     $admin_user->delete();
     return redirect()->route('admin-user.index')->with('success', 'Data User berhasil dihapus!');
   }
 }