@extends('layouts.main')
@section('content')
<!-- Main Content -->
<div id="content">
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->username }}</span>
          <img class="img-profile rounded-circle" src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}">
        </a>
      </li>
    </ul>
  </nav>

  <div class="container-fluid">
    <h1 class="h3 mb-3 text-gray-800 font-weight-bold">Detail Rekam Medis Pasien</h1>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="font-weight-bold text-primary">Detail Data Rekam Medis</h5>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th>No Rekam Medis</th>
              <td>{{ $detail->pasien->no_rekam_medis }}</td>
            </tr>
            <tr>
              <th>Nama Pasien</th>
              <td>{{ $detail->pasien->nama }}</td>
            </tr>
            <tr>
              <th>Jenis Kelamin</th>
              <td>{{ $detail->pasien->jenis_kelamin }}</td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td>{{ $detail->pasien->alamat }}</td>
            </tr>
            <tr>
              <th>Tanggal Lahir</th>
              <td>{{ date('d-m-Y', strtotime($detail->pasien->tanggal_lahir)) }}</td>
            </tr>
            <tr>
              <th>Nama Fisioterapis</th>
              <td>{{ $detail->fisioterapis->nama }}</td>
            </tr>
            <tr>
              <th>Keluhan</th>
              <td>{{ $detail->antrian->keluhan }}</td>
            </tr>
            <tr>
              <th>Tanggal Terapi</th>
              <td>{{ date('d-m-Y', strtotime($detail->antrian->tanggal_terapi)) }}</td>
            </tr>
            <tr>
              <th>Diagnosa</th>
              <td>{{ $detail->diagnosa ?? '' }}</td>
            </tr>
            <tr>
              <th>Penanganan</th>
              <td>{{ $detail->penanganan ?? '' }}</td>
            </tr>
            <tr>
              <th>Pemeriksaan Umum</th>
              <td>{{ $detail->pemeriksaan_umum ?? '' }}</td>
            </tr>
            <tr>
              <th>Pemeriksaan Fisioterapis</th>
              <td>{{ $detail->pemeriksaan_fisioterapis ?? '' }}</td>
            </tr>
            <tr>
              <th>Tujuan Program</th>
              <td>{{ $detail->tujuan_program ?? '' }}</td>
            </tr>
            <tr>
              <th>Intervensi</th>
              <td>{{ $detail->intervensi ?? '' }}</td>
            </tr>
            <tr>
              <th>Evaluasi</th>
              <td>{{ $detail->evaluasi ?? '' }}</td>
            </tr>
          </tbody>
        </table>
        <a href="{{ route('admin-rekam-medis.index') }}" class="btn btn-secondary mt-3">Kembali</a>
      </div>
    </div>
  </div>
</div>
@endsection
