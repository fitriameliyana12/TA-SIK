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
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Fisioterapis</h1>
    <p>Edit Data Fisioterapis</p>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <form action="{{ route('admin-fisioterapis.update', ['admin_fisioterapi' => $fisioterapis->id]) }}" method="POST">
          @csrf
          @method('PUT')
         
          <div class="form-group">
            <label for="nama">Nama Fisioterapis</label>
            <input type="text" class="form-control" id="nama" name="nama"
              placeholder="Nama Fisioterapis" value="{{ $fisioterapis->nama }}" required>
          </div>
          <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
              value="{{ $fisioterapis->tanggal_lahir }}" required>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" class="form-control" id="alamat" rows="3" required>{{ $fisioterapis->alamat }}</textarea>
          </div>

          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
              <option value="Laki-Laki" {{($fisioterapis->jenis_kelamin === 'Laki-Laki') ? 'selected' : ''}}>Laki-laki</option>
              <option value="Perempuan" {{($fisioterapis->jenis_kelamin === 'Perempuan') ? 'selected' : ''}}>Perempuan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="kehadiran">Kehadiran</label>
            <select name="kehadiran" class="form-control" id="kehadiran" required>
              <option value="Hadir" {{($fisioterapis->kehadiran === 'Hadir') ? 'selected' : ''}}>Hadir</option>
              <option value="Izin" {{($fisioterapis->kehadiran === 'Izin') ? 'selected' : ''}}>Izin</option>
            </select>
          </div>

          <button type="submit" class="btn btn-info">Update</button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
