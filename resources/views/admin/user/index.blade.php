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
    <!-- Page Heading -->
    <center><h1 class="h2 mb-2 text-gray-1000 font-weight-bold">Data Akun User</h1></center>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <!-- <h5 class="font-weight-bold text-primary">Data Akun User -->
        <span>
            <a href="{{ route('admin-user.create') }}" class="btn btn-success btn-sm">
              + Tambah
            </a>
        </span>
        <!-- Form Pencarian di sebelah tombol -->
        <span class="float-right">
            <form method="GET" action="{{ route('admin-user.index') }}" class="form-inline">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary btn-sm ml-2">Cari</button>
            </form>
        </span>
        </h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
            <th>No. </th>
            <th>Username</th>
            <th>No. Telepon</th>
            <th>Role User</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $index => $user)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $user->username }}</td>
          <td>
            <a href="https://wa.me/{{ ltrim($user->telepon, '0') }}" target="_blank">
                {{ $user->telepon }}
            </a>
          </td>
          <td>{{ $user->role }}</td>
          <td>
                  <a href="{{ route('admin-user.show', $user->id_user) }}" class="btn btn-sm btn-success" style="display: inline-block;">
                      <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin-user.edit', $user->id_user) }}" class="btn btn-sm btn-warning" style="display: inline-block;">
                    <i class="fas fa-edit"></i>
                  </a>
                  <!-- Formulir Penghapusan -->
                  <form id="delete-form-{{ $user->id_user }}" action="{{ route('admin-user.destroy', $user->id_user) }}" method="post" style="display: inline-block;">
                      @method('delete')
                      @csrf
                      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $user->id_user }})">
                          <i class="fas fa-trash"></i>
                      </button>
                    </form>
            </td>
        </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
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
          })
      </script>
    @endif

    <!-- Script untuk SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  </div>
  <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
@endsection

<!-- Pastikan Bootstrap dan jQuery sudah dimuat dengan benar -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->

<script>
  $(document).ready(function() {
    // Inisialisasi dropdown, tetapi ini tidak diperlukan dengan bootstrap.bundle.min.js
    // $('.dropdown-toggle').dropdown();
  });
</script>