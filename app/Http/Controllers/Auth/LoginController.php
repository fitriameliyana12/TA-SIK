<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Mencari user berdasarkan username
    $user = User::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        // Jika password cocok, login user
        Auth::login($user);

        // Redirect berdasarkan role
        $role = $user->role; // Ambil role dari user yang sedang login
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'pasien') {
            return redirect()->route('pasien.dashboard');
        } elseif ($role === 'fisioterapis') {
            return redirect()->route('fisioterapis.dashboard');
        }

        return redirect()->route('home'); // Jika role tidak ditemukan
    }

    // Jika gagal login
    return back()->withErrors(['login_error' => 'Username atau password salah']);
}

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
