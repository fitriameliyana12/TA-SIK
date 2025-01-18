<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Pasien; // Menambahkan import model Pasien
use App\Models\Fisioterapis; // Menambahkan import model Fisioterapis
use Carbon\Carbon; // Import Carbon untuk menghitung usia
use Illuminate\Support\Facades\Log;

class AntrianController extends Controller
{
    // Menampilkan form untuk mengambil antrian
    public function create()
    {
        // Mendapatkan data user yang sedang login
        $user = Auth::user();

        // Ambil semua data fisioterapis
        $fisioterapis = Fisioterapis::all();

        // Ambil data pasien berdasarkan user yang sedang login
        $pasien = Pasien::where('id_user', $user->id_user)->first();

        // Jika pasien tidak ditemukan
        if (!$pasien) {
            return redirect()->route('profile.show')->with('error', 'Data pasien tidak ditemukan');
        }

        return view('pasien.ambil-antrian', compact('user', 'fisioterapis', 'pasien'));
    }

    // Menyimpan antrian ke database
    public function store(Request $request)
    {
        // Validasi inputan dari form
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'tanggal_terapi' => 'required|date',
            'jam_terapi' => 'required|string',
            'id_fisioterapis' => 'required|exists:fisioterapis,id', // Validasi ID fisioterapis
            'keluhan' => 'nullable|string', // Keluhan opsional
        ]);
        // Jika validasi gagal, kembalikan dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Debugging: Cek data request
        Log::info('Data Request:', $request->all());
        
        // Ambil data pasien yang sedang login
        $user = Auth::user();
        // dd($user);
        $pasien = Pasien::where('id_user', $user->id_user)->first();

        // dd($pasien);
    

        // Cek jika pasien ditemukan
        if (!$pasien) {
            return redirect()->route('dashboard')->with('error', 'Data pasien tidak ditemukan.');
        }

        // Menghitung usia pasien
        // $usia = \Carbon\Carbon::parse($pasien->tanggal_lahir)->age;

        // Debugging: Cek data yang akan disimpan
        Log::info('Data yang akan disimpan:', [
            'id_pasien'       => $pasien->id_pasien,
            'id' => $request->id_fisioterapis,
            'usia'            => $request->usia,
            'keluhan'         => $request->keluhan,
            'tanggal_terapi'  => $request->tanggal_terapi,
            'jam_terapi'      => $request->jam_terapi,
        ]);

        try {
            // Simpan data antrian ke tabel antrian
            $cek = Antrian::whereRaw("tanggal_terapi='".$request->tanggal_terapi."' AND jam_terapi='".$request->jam_terapi."' AND id='".$request->id_fisioterapis."'")->first();
            if($cek){
                return redirect()->route('antrian.create')->with('error', 'Mohon jadwal fisioterapis yang Anda pilih sudah digunakan oleh pasien lain !');
            }else{
                Antrian::create([
                    'id_pasien'       => $pasien->id_pasien, // Ambil ID pasien yang sedang login
                    'id' => $request->id_fisioterapis, // ID Fisioterapis dari request
                    'usia'            => $request->usia, // Usia pasien
                    'keluhan'         => $request->keluhan, // Keluhan pasien
                    'tanggal_terapi'  => $request->tanggal_terapi, // Tanggal terapi
                    'jam_terapi'      => $request->jam_terapi, // Jam terapi
                    'status'          => 'tertunda', // Status default
                ]);

                return redirect()->route('riwayat-terapi.index')->with('success', 'Data berhasil disimpan');
            }
        } catch (\Exception $e) {
            // Jika terjadi error, log error dan beri feedback
            Log::error('Error saat menyimpan antrian: ' . $e->getMessage());
            return redirect()->route('antrian.create')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detail($id)
    {
        // Mengambil data antrian berdasarkan ID, dan memuat relasi terkait pasien, fisioterapis, dan user
        $antrian = Antrian::with(['pasien', 'fisioterapis', 'user', 'rekamMedis'])
            ->findOrFail($id);  // Menemukan antrian berdasarkan ID atau 404 jika tidak ditemukan

        // Kembalikan ke view dengan data antrian
        return view('pasien.detail', compact('antrian'));
    }

}
