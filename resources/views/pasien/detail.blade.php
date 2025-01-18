@extends('layouts.main')

@section('content')
<!-- Main Content -->
<div id="content">
  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <form class="form-inline">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </form>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
      <div class="topbar-divider d-none d-sm-block"></div>
      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->username }}</span>
          <img class="img-profile rounded-circle" src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <!-- Profile Link with Icon -->
        <a class="dropdown-item" href="{{ route('profile.show') }}">
          <i class="fas fa-user"></i> {{ __('Profile') }}
        </a>
        <!-- Logout Link with Icon -->
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
      </li>
    </ul>
  </nav>
  <!-- End of Topbar -->

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <h1 class="h3 mb-3 text-gray-800 font-weight-bold">Detail Terapi</h1>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="font-weight-bold text-primary">Detail Data Terapi Pasien</h5>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tbody>
            <!-- Informasi Pasien -->
            <tr>
              <th>Nama Pasien</th>
              <td>{{ $antrian->pasien->nama }}</td>
            </tr>
            <tr>
              <th>Jenis Kelamin</th>
              <td>{{ $antrian->pasien->jenis_kelamin }}</td>
            </tr>
            <tr>
              <th>Nomor Rekam Medis</th>
              <td>{{ $antrian->pasien->no_rekam_medis }}</td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td>{{ $antrian->pasien->alamat }}</td>
            </tr>
            <tr>
              <th>Tanggal Lahir</th>
              <td>{{ date('d-m-Y', strtotime($antrian->pasien->tanggal_lahir)) }}</td>
            </tr>

            <!-- Informasi Fisioterapis -->
            <tr>
              <th>Nama Fisioterapis</th>
              <td>{{ $antrian->fisioterapis->nama }}</td>
            </tr>

            <!-- Informasi Antrian -->
            <tr>
              <th>Keluhan</th>
              <td>{{ $antrian->keluhan }}</td>
            </tr>
            <tr>
              <th>Tanggal Terapi</th>
              <td>{{ date('d-m-Y', strtotime($antrian->tanggal_terapi)) }}</td>
            </tr>

            <!-- Detail Terapi -->
            @if ($antrian->rekamMedis)
              <tr>
                <th>Diagnosa</th>
                <td>{{ $antrian->rekamMedis->diagnosa ?? '' }}</td>
              </tr>
              <tr>
                <th>Penanganan</th>
                <td>{{ $antrian->rekamMedis->penanganan ?? '' }}</td>
              </tr>
              <tr>
                <th>Pemeriksaan Umum</th>
                <td>{{ $antrian->rekamMedis->pemeriksaan_umum ?? '' }}</td>
              </tr>
              <tr>
                <th>Pemeriksaan Fisioterapis</th>
                <td>{{ $antrian->rekamMedis->pemeriksaan_fisioterapis ?? '' }}</td>
              </tr>
              <tr>
                <th>Tujuan Program</th>
                <td>{{ $antrian->rekamMedis->tujuan_program ?? '' }}</td>
              </tr>
              <tr>
                <th>Intervensi</th>
                <td>{{ $antrian->rekamMedis->intervensi ?? '' }}</td>
              </tr>
              <tr>
                <th>Evaluasi</th>
                <td>{{ $antrian->rekamMedis->evaluasi ?? '' }}</td>
              </tr>
            @else
              <tr>
                <th>Diagnosa</th>
                <td rowspan="7" class="text-center" style="vertical-align: middle"><i>Menunggu hasil dari fisioterapi</i></td>
              </tr>
              <tr>
                <th>Penanganan</th>
              </tr>
              <tr>
                <th>Pemeriksaan Umum</th>
              </tr>
              <tr>
                <th>Pemeriksaan Fisioterapis</th>
              </tr>
              <tr>
                <th>Tujuan Program</th>
              </tr>
              <tr>
                <th>Intervensi</th>
              </tr>
              <tr>
                <th>Evaluasi</th>
              </tr>
            @endif
            
          </tbody>
        </table>
        <a href="{{ route('riwayat-terapi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
      </div>
    </div>
  </div>
</div>
@endsection
