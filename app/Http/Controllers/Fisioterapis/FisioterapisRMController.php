<?php

namespace App\Http\Controllers\Fisioterapis;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Antrian;
use App\Models\Fisioterapis;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class FisioterapisRMController extends Controller
{

    public function index(Request $request)
    {
        // Mendapatkan fisioterapis yang terkait dengan user yang sedang login
        $fisioterapis = auth()->user()->fisioterapis;

        // Cek apakah fisioterapis ditemukan
        if (!$fisioterapis) {
            return redirect()->route('home')->with('error', 'Fisioterapis tidak ditemukan');
        }

        // Mengambil semua antrian yang ditangani oleh fisioterapis ini
        $antrians = $fisioterapis->antrian;

        // Jika ada parameter pencarian
        if ($request->has('search')) {
            $antrians = $antrians->filter(function ($item) use ($request) {
                return strpos($item->pasien->nama_lengkap, $request->search) !== false;
            });
        }

        // Mengirimkan data antrian ke view
        return view('fisioterapis.rekam_medis.index', compact('antrians'));
    }

    public function show($id)
    {
        // Mengambil data antrian berdasarkan ID, dan memuat relasi terkait pasien, fisioterapis, dan user
        $antrian = Antrian::with(['pasien', 'fisioterapis', 'user', 'rekamMedis'])
            ->findOrFail($id);  // Menemukan antrian berdasarkan ID atau 404 jika tidak ditemukan
        
        // Kembalikan ke view dengan data antrian
        return view('fisioterapis.rekam_medis.show', compact('antrian'));
    }

    public function edit($id)
    {
        $antrian = Antrian::with(['pasien', 'fisioterapis', 'user', 'rekamMedis'])
            ->findOrFail($id);

        // dd($antrian);

        return view('fisioterapis.rekam_medis.edit', compact('antrian'));
    }

    public function update(Request $request, $id)
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'diagnosa'                 => 'required|string',
            'penanganan'               => 'required|string',
            'pemeriksaan_umum'         => 'required|string',
            'pemeriksaan_fisioterapis' => 'required|string',
            'tujuan_program'           => 'required|string',
            'intervensi'               => 'required|string',
            'evaluasi'                 => 'required|string'
        ]);

        $data = $request->only(['diagnosa', 'penanganan', 'pemeriksaan_umum', 'pemeriksaan_fisioterapis', 'tujuan_program', 'intervensi', 'evaluasi']);

        $antrian = Antrian::with(['pasien', 'fisioterapis', 'user', 'rekamMedis'])
            ->findOrFail($id);

        $pasien = Pasien::with(['user'])
            ->findOrFail($antrian->pasien->id_pasien);
        
        $data['id_pasien'] = $pasien->id_pasien;
        $data['id'] = $antrian->fisioterapis->id;
        $data['id_user'] = $pasien->user->id_user;
        $data['id_antrian'] = $id;

        if(!empty($request->id_rekam_medis)){
            // dd($data);
            RekamMedis::where('id_rekam_medis', $request->id_rekam_medis)->update($data);
        }else{
            // dd($data);
            RekamMedis::create($data);
        }

        return redirect()->route('fisioterapis.rekam_medis.index')->with('success', 'Data rekam medis pasien berhasil diperbarui!');
    }

    public function showByAntrian($id)
    {
        // Cari data antrian berdasarkan ID antrian (menggunakan id_antrian)
        $antrian = Antrian::findOrFail($id);
        
        // Ambil data pasien yang terkait dengan antrian ini
        $pasien = Pasien::findOrFail($antrian->id_pasien);
        
        // Ambil data fisioterapis yang menangani pasien berdasarkan id
        $fisioterapis = Fisioterapis::findOrFail($antrian->id);
        
        // Tampilkan view dengan data yang relevan
        return view('fisioterapis.rekam_medis.show', compact('pasien', 'antrian', 'fisioterapis'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'no_rekam_medis' => 'required',
            'nama' => 'required',
            'keluhan' => 'required',
            'jam_terapi' => 'required',
            'tanggal_terapi' => 'required|date',
        ]);

        Pasien::create($validatedData);

        return redirect()->route('fisioterapis.rekam_medis.index')->with('success', 'Data rekam medis berhasil ditambahkan!');
    }




}
