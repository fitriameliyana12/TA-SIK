<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Antrian;
use App\Models\Fisioterapis;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class AdminRMController extends Controller
{

    public function index(Request $request)
    {
        $data = RekamMedis::all();

        // Jika ada parameter pencarian
        if ($request->has('search')) {
            $data = $data->filter(function ($item) use ($request) {
                return strpos($item->pasien->nama, $request->search) !== false;
            });
        }

        // dd($data);

        // Mengirimkan data antrian ke view
        return view('admin.rekam_medis.index', compact('data'));
    }

    public function show($id)
    {
        // Mengambil data antrian berdasarkan ID, dan memuat relasi terkait pasien, fisioterapis, dan user
        $detail = RekamMedis::with(['pasien', 'fisioterapis', 'user', 'antrian'])
            ->findOrFail($id);  // Menemukan antrian berdasarkan ID atau 404 jika tidak ditemukan
        
        // Kembalikan ke view dengan data antrian
        return view('admin.rekam_medis.show', compact('detail'));
    }

    public function destroy($id)
    {
        RekamMedis::find($id)->delete();
        return redirect()->route('admin-rekam-medis.index')->with('success', 'Data rekam medis berhasil dihapus!');
    }
}
