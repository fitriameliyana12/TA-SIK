@extends('layouts.main')
@section('content')
<!-- Main Content -->
<div id="content">
  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
      <div class="topbar-divider d-none d-sm-block"></div>
      <!-- Nav Item - User Information -->
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
  <!-- End of Topbar -->

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <center><h1 class="h2 mb-2 text-gray-1000 font-weight-bold">Detail Riwayat Terapi Pasien</h1></center>
    <!-- Detail Information -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <table class="table table-borderless" width="100%">
          <tr>
            <th width="15%">Nomor Rekam Medis</th>
            <th width="2%">:</th>
            <td>{{ $pasien->no_rekam_medis }}</td>
          </tr>
          <tr>
            <th>Nama</th>
            <th>:</th>
            <td>{{ $pasien->nama }}</td>
          </tr>
          <tr>
            <th>Jumlah Sesi Terapi</th>
            <th>:</th>
            <td>{{ $jumlah_sesi }}</td>
          </tr>
        </table>
      </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Sesi Terapi</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Tanggal Terapi</th>
                <th>Keluhan</th>
                <th>Diagnosa</th>
                <th>Penanganan</th>
                <th>Evaluasi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($riwayat_detail as $detail)
              <tr>
                <td>{{ date('d-m-Y', strtotime($detail->tanggal_terapi)) }}</td>
                <td>{{ $detail->keluhan ?? '-' }}</td>
                <td>{{ $detail->diagnosa ?? '-' }}</td>
                <td>{{ $detail->penanganan ?? '-' }}</td>
                <td>{{ $detail->evaluasi ?? '-' }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Back Button -->
    <div class="text-center">
      <a href="{{ route('admin.riwayat.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <!-- SweetAlert2 Script untuk Notifikasi Sukses -->
    @if(session('success'))
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        Swal.fire({
          title: 'Berhasil!',
          text: '{{ session('success') }}',
          icon: 'success',
          confirmButtonText: 'OK'
        });
      </script>
    @endif
  </div>
  <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
@endsection

<!-- Pastikan Bootstrap dan jQuery sudah dimuat dengan benar -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->
