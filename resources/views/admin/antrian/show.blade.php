@extends('layouts.main')

@section('content')
<!-- Main Content -->
<div id="content">
  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <form class="form-inline">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </form>
    <ul class="navbar-nav ml-auto">
      <div class="topbar-divider d-none d-sm-block"></div>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->username }}</span>
          <img class="img-profile rounded-circle" src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{ route('profile.show') }}">
            <i class="fas fa-user"></i> {{ __('Profile') }}
          </a>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <h1 class="h3 mb-3 text-gray-800 font-weight-bold">Detail Data Antrian Pasien</h1>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="font-weight-bold text-primary">Detail Data Antrian Pasien</h5>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tbody>
          <tr>
              <th>Nomer Rekam Medis Pasien</th>
              <td>{{ $antrian->pasien->no_rekam_medis }}</td>
            </tr>
            <tr>
              <th>Nama Pasien</th>
              <td>{{ $antrian->pasien->nama }}</td>
            </tr>
            <tr>
              <th>Jenis Kelamin</th>
              <td>{{ $antrian->pasien->jenis_kelamin }}</td>
            </tr>
            <tr>
              <th>Tanggal Lahir</th>
              <td>{{ \Carbon\Carbon::parse($antrian->pasien->tanggal_lahir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
              <th>Usia</th>
              <td>
                {{ \Carbon\Carbon::parse($antrian->pasien->tanggal_lahir)->age }} tahun
              </td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td>{{ $antrian->pasien->alamat }}</td>
            </tr>
            <tr>
              <th>Nomor Telepon</th>
              <td>{{ $antrian->pasien->user->telepon }}</td>
            </tr>
            <tr>
              <th>Nama Fisioterapis</th>
              <td>{{ $antrian->fisioterapis->nama }}</td>
            </tr>
            <tr>
              <th>Tanggal Terapi</th>
              <td>{{ $antrian->tanggal_terapi }}</td>
            </tr>
            <tr>
              <th>Jam Terapi</th>
              <td>{{ $antrian->jam_terapi }}</td>
            </tr>
          </tbody>
        </table>
        <a href="{{ route('admin-antrian.index') }}" class="btn btn-secondary mt-3">Kembali</a>
      </div>
    </div>
  </div>
</div>
@endsection
