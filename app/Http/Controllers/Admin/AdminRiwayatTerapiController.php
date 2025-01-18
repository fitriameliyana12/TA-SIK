<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Antrian;
use App\Models\RekamMedis;
use App\Http\Controllers\Controller;
use App\Models\RiwayatTerapi;

class AdminRiwayatTerapiController extends Controller
{
    // Halaman Riwayat Terapi Pasien
    public function index()
    {
        $riwayat_terapi = Pasien::join('antrian', 'pasien.id_pasien', '=', 'antrian.id_pasien')
            ->select(
                'pasien.id_pasien',
                'pasien.no_rekam_medis',
                'pasien.nama',
                'pasien.alamat',
                Antrian::raw('MAX(antrian.tanggal_terapi) as tanggal_terapi_terakhir')
            )
            ->groupBy('pasien.id_pasien', 'pasien.no_rekam_medis', 'pasien.nama', 'pasien.alamat')
            ->get();

        return view('admin.riwayat.index', compact('riwayat_terapi'));
    }

    // Halaman Detail Riwayat Terapi Pasien
    public function detail($id_pasien)
    {
        $pasien = Pasien::findOrFail($id_pasien);
        // dd($pasien);
        $riwayat_detail = Antrian::where('antrian.id_pasien', $id_pasien)
            ->leftJoin('rekam_medis', 'antrian.id_antrian', '=', 'rekam_medis.id_antrian')
            ->select('antrian.tanggal_terapi', 'antrian.keluhan', 'rekam_medis.diagnosa', 'rekam_medis.penanganan', 'rekam_medis.evaluasi')
            ->orderBy('antrian.tanggal_terapi', 'desc')
            ->get();

        $jumlah_sesi = $riwayat_detail->count();

        return view('admin.riwayat.detail', compact('pasien', 'riwayat_detail', 'jumlah_sesi'));
    }
}
