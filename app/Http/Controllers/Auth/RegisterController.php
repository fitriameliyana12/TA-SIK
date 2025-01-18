<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:user'], // Perbaiki nama tabel jadi 'user'
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telepon' => ['required', 'string', 'max:15'],
        ]);
    }

    protected function create(array $data)
    {
        Log::info('Data yang diterima:', $data);

        return User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'telepon' => $data['telepon'],
            'role' => 'pasien',
        ]);
    }

    protected function registered(\Illuminate\Http\Request $request, $user)
    {
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login.');
    }
}
