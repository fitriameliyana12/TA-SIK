<?php
namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Antrian;
use App\Http\Requests\Pasien\PasienRequest;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\Pasien;

class RiwayatTerapiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
    
        // Ambil data pasien terkait
        $pasien = $user->pasien;
    
        // Pastikan pasien ada
        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan.');
        }
    
        // Ambil ID pasien
        $pasienId = $pasien->id_pasien;
    
        // Ambil data riwayat terapi berdasarkan ID pasien dan pencarian
        $search = $request->input('search'); // Ambil input pencarian dari form
        $riwayatTerapi = Antrian::where('id_pasien', $pasienId)
            ->when($search, function ($query, $search) {
                return $query->where('keluhan', 'like', '%' . $search . '%')
                             ->orWhereHas('pasien', function ($q) use ($search) {
                                 $q->where('nama', 'like', '%' . $search . '%');
                             });
            })
            ->get();
    
        return view('pasien.riwayat', compact('riwayatTerapi'));
    }
    

    public function unduhTiketAntrian($id)
{
    // Ambil data antrian berdasarkan ID
    $antrian = Antrian::findOrFail($id);

    // Generate PDF
    $pdf = PDF::loadView('pasien.tiket-antrian', compact('antrian'));

    // Unduh tiket sebagai file PDF
    return $pdf->download('tiket-antrian-' . $antrian->id . '.pdf');
}

// public function search(Request $request)
//     {
//         // Ambil nilai pencarian
//         $search = $request->get('search');

//         // Ambil data riwayat berdasarkan pencarian
//         $riwayats = Riwayat::query()
//             ->when($search, function ($query) use ($search) {
//                 $query->whereHas('pasien', function ($query) use ($search) {
//                     $query->where('nama', 'like', "%{$search}%");
//                 })
//                 ->orWhere('keluhan', 'like', "%{$search}%")
//                 ->orWhere('tanggal_terapi', 'like', "%{$search}%")
//                 ->orWhere('jam_terapi', 'like', "%{$search}%");
//             })
//             ->get();

//         // Kembalikan ke view dengan data riwayat
//         return view('pasien.riwayat', compact('riwayatTerapi'));
//     }
}
