<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dokter\DokterRequest;
use App\Models\Dokter;
use Illuminate\Http\Request;

class AdminDokterController extends Controller
{
  public function index()
  {
    $dokter = Dokter::all();
    $data = [
      'dokters' => $dokter
    ];
    return view('admin.dokter.index', $data);
  }

  public function create()
  {
    return view('admin.dokter.create');
  }

  public function store(DokterRequest $request)
  {
    $validatedData = $request->all();
    $dokter = Dokter::create($validatedData);
    return redirect()->route('admin-dokter.index')->with('success', 'Berhasil Menambah Data Baru');
  }

  public function show(Dokter $admin_dokter)
  {
    //
  }

  public function edit(Dokter $admin_dokter)
  {
    $data = [
      'dokter' => $admin_dokter
    ];
    return view('admin.dokter.edit', $data);
  }

  public function update(Request $request, Dokter $admin_dokter)
  {
    $validatedData = $request->all();
    $admin_dokter->update($validatedData);
    return redirect()->route('admin-dokter.index')->with('success', 'Data Pasien berhasil diperbarui!');
  }

  public function destroy(Dokter $admin_dokter)
  {
    $admin_dokter->delete();
    return redirect()->route('admin-dokter.index');
  }
}
