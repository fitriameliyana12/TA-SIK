<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Antrian\AntrianRequest;
use App\Models\Antrian;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Fisioterapis;
use Carbon\Carbon;

class AdminAntrianController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai pencarian
        $search = $request->get('search');

        //Ambil data antrian dengan relasi dan pencarian
        $antrian = Antrian::with(['pasien', 'fisioterapis'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pasien', function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                          ->orWhere('jenis_kelamin', 'like', "%{$search}%")
                          ->orWhereRaw(
                              "TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) = ?",
                              [$search]
                          );
                })
                ->orWhereHas('fisioterapis', function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%");
                })
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('keluhan', 'like', "%{$search}%")
                ->orWhere('tanggal_terapi', 'like', "%{$search}%")
                ->orWhere('jam_terapi', 'like', "%{$search}%");
            })
            ->get();

        // Kirim data ke view
        return view('admin.antrian.index', compact('antrian'));
    }

    public function create()
    {
        // Mengambil data pasien dan fisioterapis
        $pasien = Pasien::all();
        $fisioterapis = Fisioterapis::all();
        // Jika ingin mengirim jam terapi default atau logika lainnya, lakukan disini
        // Menentukan jam terapi (misalnya, jam 08:00 hingga 19:00)
        $jam_terapi = [
        '08:00', '09:00', '10:00', '11:00', '12:00',
        '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'];

        // Mengirim data ke view
        return view('admin.antrian.create', compact('pasien', 'fisioterapis', 'jam_terapi'));
    }


  public function store(Request $request)
  {
        $validatedData = $request->validate([
            'id_pasien' => 'required|exists:pasien,id_pasien',
            'id' => 'required|exists:fisioterapis,id',
            'tanggal_terapi' => 'required|date',
            'jam_terapi' => 'required',
            'keluhan' => 'required|string',
            'status' => 'required|in:disetujui,ditolak,tertunda',
        ]);
    
        // Menyimpan data ke tabel antrian
        Antrian::create([
            'id_pasien' => $validatedData['id_pasien'],
            'id' => $validatedData['id'],
            'tanggal_terapi' => $validatedData['tanggal_terapi'],
            'jam_terapi' => $validatedData['jam_terapi'],
            'keluhan' => $validatedData['keluhan'],
            'status' => $validatedData['status'],
        ]);
    
        return redirect()->route('admin-antrian.index')->with('success', 'Data antrian berhasil ditambahkan!');
 
    
  }
  

public function getJamTerapi(Request $request)
{
    // Mendapatkan tanggal terapi dari input
    $tanggal_terapi = Carbon::parse($request->tanggal_terapi);
    $hari = $tanggal_terapi->format('l');
    $jam_terapi = [];

    // Mengatur jam terapi sesuai dengan hari
    switch ($hari) {
        case 'Monday':
        case 'Tuesday':
        case 'Wednesday':
        case 'Thursday':
        case 'Friday':
            $jam_terapi = array_merge(
                ['09:00', '10:00', '11:00'],
                ['15:00', '16:00', '17:00', '18:00', '19:00']
            );
            break;
        case 'Saturday':
            $jam_terapi = ['08:00', '09:00', '10:00', '11:00', '12:00'];
            break;
        default:
            $jam_terapi = [];
            break;
    }

    return response()->json($jam_terapi);
}


    public function show(Antrian $admin_antrian)
    {
        return view('admin.antrian.show', ['antrian' => $admin_antrian]);
    }

    public function edit($id_antrian)
    {
        // Ambil data antrian berdasarkan ID
        $antrian = Antrian::findOrFail($id_antrian);

        // Ambil semua data pasien untuk dropdown
        $pasien = Pasien::all();

        // Ambil semua data fisioterapis untuk dropdown
        $fisioterapis = Fisioterapis::all();

        // Kirim data ke view
        return view('admin.antrian.edit', compact('antrian', 'pasien', 'fisioterapis'));
    }


    public function update(Request $request, $id_antrian)
    {
        // Validasi data input
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'tanggal_terapi' => 'required|date',
            'jam_terapi' => 'required',
            'id' => 'required|exists:fisioterapis,id',
        ]);

        // Update data di database
        $antrian = Antrian::findOrFail($id_antrian);
        $antrian->id_pasien = $request->id_pasien; // Menggunakan id_pasien
        $antrian->tanggal_terapi = $request->tanggal_terapi;
        $antrian->jam_terapi = $request->jam_terapi;
        $antrian->id = $request->id; // ID fisioterapis
        $antrian->save();


        return redirect()->route('admin-antrian.index')->with('success', 'Data antrian berhasil diupdate.');
    }


    public function destroy(Antrian $admin_antrian)
    {
        $admin_antrian->delete();
        return redirect()->route('admin-antrian.index')->with('success', 'Data Pasien berhasil dihapus!');
    }
}