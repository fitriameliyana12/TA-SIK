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
    </div>
  </nav>

  <div class="container-fluid">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Profil</h6>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required readonly>
          </div>
          <!-- Form untuk Edit Password -->
          <div class="mb-3">
              <label for="password" class="form-label">Password Baru</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru (minimal 6 karakter)">
          </div>

          <div class="mb-3">
              <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
          </div>

          <div class="mb-3">
              <label for="telepon" class="form-label">Telepon</label>
              <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $user->telepon) }}" required>
          </div>

          <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              @php
                  $nama = old('nama') ?? ($pasien!=null ? $pasien->nama : '');
              @endphp
              <input type="text" name="nama" id="nama" class="form-control" value="{{ $nama }}" required>
          </div>

          <div class="mb-3">
              <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
              @php
                  $tanggal_lahir = old('tanggal_lahir') ?? ($pasien!=null ? $pasien->tanggal_lahir : '');
              @endphp
              <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="{{ $tanggal_lahir }}" required>
          </div>

          <div class="mb-3">
              <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
              @php
                  $jenis_kelamin = old('jenis_kelamin') ?? ($pasien!=null ? $pasien->jenis_kelamin : '');
              @endphp
              <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                  <option value="Laki-Laki" {{ $jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                  <option value="Perempuan" {{ $jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
          </div>

          <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              @php
                  $alamat = old('alamat') ?? ($pasien!=null ? $pasien->alamat : '');
              @endphp
              <textarea name="alamat" id="alamat" class="form-control" required>{{ $alamat }}</textarea>
          </div>

          <div class="mb-3">
              <label for="foto" class="form-label">Foto</label>
              @php
                  $foto = $user->foto!=null ? $user->foto : '';
              @endphp
              @if (!empty($foto))
              <br><img src="{{ asset('storage/foto/' . $foto) }}" alt="Foto Profil" class="img-thumbnail mb-2" width="100">
              @endif
              <input type="file" name="foto" id="foto" class="form-control" accept=".png, .jpeg, .jpg">
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
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

