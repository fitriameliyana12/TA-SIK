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
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
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
    <h1 class="h3 mb-3 text-gray-800 font-weight-bold">Detail Data Pasien</h1>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="font-weight-bold text-primary">Detail Data Pasien</h5>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th>No.Rekam Medis</th>
              <td>{{ $pasien->no_rekam_medis }}</td>
            </tr>
            <tr>
              <th>Username</th>
              <td>{{ $pasien->user->username }}</td>
            </tr>
            <tr>
              <th>Role</th>
              <td>{{ $pasien->user->role }}</td>
            </tr>
            <tr>
            <tr>
              <th>Nama Pasien</th>
              <td>{{ $pasien->nama }}</td>
            </tr>
            <tr>
              <th>Tanggal Lahir</th>
              <td>{{ $pasien->tanggal_lahir }}</td>
            </tr>
            <tr>
              <th>Jenis Kelamin</th>
              <td>{{ $pasien->jenis_kelamin }}</td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td>{{ $pasien->alamat }}</td>
            </tr>
            <!-- Menampilkan Data User -->
              <th>Telepon (User)</th>
              <td>{{ $pasien->user->telepon }}</td>
            </tr>
            <tr>
              <th>Foto</th>
              <td>
                <img src="{{ asset('storage/' . $pasien->user->foto) }}" alt="Foto User" class="img-thumbnail" style="width: 150px;">
              </td>
            </tr>
          </tbody>
        </table>
        <a href="{{ route('admin-pasien.index') }}" class="btn btn-secondary mt-3">Kembali</a>
      </div>
    </div>
  </div>
</div>
@endsection
