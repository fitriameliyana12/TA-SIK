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
            <img class="img-profile rounded-circle" src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <!-- Profile Link with Icon -->
          <a class="dropdown-item" href="{{ route('profileadm.show') }}">
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
  <div class="container-fluid flex-grow-1">
    @if (Auth::user()->role == 'admin')
      <h1 class="h3 mb-0 text-gray-800">Welcome to Admin Dashboard</h1>
      <p>Here you can manage users, view reports, and perform administrative tasks.</p>
      <!-- Additional content for the admin dashboard -->
    @else
      <p>Access denied. You do not have permission to view this page.</p>
    @endif
  </div>
<!-- End of Main Content -->
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
