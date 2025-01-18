@extends('layouts.main')

@section('content')
<!-- Main Content -->
<div id="content" class="d-flex flex-column min-vh-100">
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow w-100">
    <!-- Sidebar Toggle (Topbar) -->
    <form class="form-inline">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </form>
   <!-- Topbar Navbar -->
<div class="container-fluid px-0"> <!-- Remove padding/margin from container -->
  <ul class="navbar-nav ml-auto w-100 d-flex justify-content-between">
    <div class="topbar-divider d-none d-sm-block"></div>
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-black-50 big">{{ Auth::user()->username }}</span>
        <img class="img-profile rounded-circle" 
             src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}" 
             alt="Profile Picture">
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <!-- Profile Link with Icon -->
        <a class="dropdown-item" href="{{ route('fisioterapis.profile.show') }}">
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
    </div>
  </nav>
  <!-- End of Topbar -->
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <h1 class="h3 mb-3 text-gray-800 font-weight-bold">Profil Pengguna</h1>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="font-weight-bold text-primary">Detail Profil Anda</h5>
      </div>
      <div class="card-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th>Password</th>
              <td>******</td>
            </tr>
            <tr>
              <th>Username</th>
              <td>{{ Auth::user()->username }}</td>
            </tr>
            <tr>
                <th>Foto Profil</th>
                <td>
                    @if (Auth::user()->foto != null)
                        <!-- Menampilkan foto profil jika ada -->
                        <img src="{{ asset('storage/foto/' . Auth::user()->foto) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                    @else
                        <!-- Menampilkan foto default jika tidak ada foto profil -->
                        <img src="{{ asset('foto/default-profile.PNG') }}" alt="Foto Default" class="img-thumbnail" width="150">
                    @endif
                </td>
            </tr>
            <tr>
              <th>Nomor Telepon</th>
              <td>{{ Auth::user()->telepon }}</td>
            </tr>
            <tr>
              <th>Nama Lengkap</th>
              <td>{{ $fisioterapis->nama }}</td>
            </tr>
            <tr>
              <th>Tanggal Lahir</th>
              <td>{{ \Carbon\Carbon::parse($fisioterapis->tanggal_lahir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
              <th>Jenis Kelamin</th>
              <td>{{ $fisioterapis->jenis_kelamin == 'Laki-Laki' ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
              <th>Alamat</th>
              <td>{{ $fisioterapis->alamat }}</td>
            </tr>
          </tbody>
        </table>
        <a href="{{ route('fisioterapis.profile.edit') }}" class="btn btn-warning mt-3">Edit Profile</a>
        <a href="{{ route('fisioterapis.dashboard') }}" class="btn btn-secondary mt-3">Kembali</a>
      </div>
    </div>
  </div>
</div>
@endsection

<!-- SweetAlert2 Script untuk Notifikasi Sukses -->
@if(session('success'))
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    })
  </script>
@endif

<!-- Script untuk konfirmasi Hapus -->
<script>
  function confirmDelete(id) {
      Swal.fire({
          title: 'Apakah Yakin Ingin Menghapus?',
          text: "Data yang dihapus tidak dapat dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, Hapus!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              document.getElementById('delete-form-' + id).submit();
          }
      });
  }
</script>

<!-- Pastikan Bootstrap dan jQuery sudah dimuat dengan benar -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->

<script>
  $(document).ready(function() {
    // Inisialisasi dropdown, tetapi ini tidak diperlukan dengan bootstrap.bundle.min.js
    // $('.dropdown-toggle').dropdown();
  });
</script>
