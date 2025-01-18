<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Method untuk mengarahkan ke halaman dashboard utama
    public function index()
{
    $role = Auth::user()->role;

    switch ($role) {
        case 'admin':
            return view('admin.dashboard');
        case 'pasien':
            return view('pasien.dashboard');
        case 'fisioterapis':
            return view('fisioterapis.dashboard');
        default:
            return redirect()->route('login');
    }
}

    // Method untuk dashboard admin
    public function admin()
    {
        return view('admin.dashboard'); // Tampilkan view dashboard admin
    }

    // Method untuk dashboard pasien
    public function pasien()
    {
        return view('pasien.dashboard'); // Tampilkan view dashboard pasien
    }

    // Method untuk dashboard fisioterapis
    public function fisioterapis()
    {
        return view('fisioterapis.dashboard'); // Tampilkan view dashboard fisioterapis
    }
}

