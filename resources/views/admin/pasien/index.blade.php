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
    <center><h1 class="h2 mb-2 text-gray-1000 font-weight-bold">Data Pasien</h1></center>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
      <h5 class="font-weight-bold text-primary">
          <span>
            <a href="{{ route('admin-pasien.create') }}" class="btn btn-success btn-sm">
              + Tambah
            </a>
            <!-- <a href="{{ route('admin-pasien.create') }}" class="btn btn-primary btn-sm">
              PDF
            </a>
            <a href="{{ route('admin-pasien.create') }}" class="btn btn-warning btn-sm">
              EXCEL
            </a> -->
          </span>
          <!-- Form Pencarian di sebelah tombol -->
          <span class="float-right">
            <form method="GET" action="{{ route('admin-pasien.index') }}" class="form-inline">
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
                <th>No</th>
                <th>No.Rekam Medis</th>
                <th>Nama Pasien</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pasien as $index => $pasien)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pasien->no_rekam_medis }}</td>
                <td>{{ $pasien->nama }}</td>
                <td>{{ $pasien->tanggal_lahir }}</td>
                <td>{{ $pasien->jenis_kelamin }}</td>
                <td>{{ $pasien->alamat }}</td>
                <td>
                @if($pasien->user && $pasien->user->telepon) <!-- Menambahkan pengecekan apakah telepon tersedia -->
                    <a href="https://wa.me/{{ ltrim($pasien->user->telepon, '0') }}" target="_blank">
                        {{ $pasien->user->telepon }}
                    </a>
                @else
                    Tidak ada nomor telepon
                @endif
            </td>
                <td>
                  <!-- Tombol untuk melihat detail -->
                  <a href="{{ route('admin-pasien.show', $pasien->id_pasien) }}" class="btn btn-sm btn-success" style="display: inline-block;">
                      <i class="fas fa-eye"></i>
                  </a>
                  <a href="{{ route('admin-pasien.edit', $pasien->id_pasien) }}" class="btn btn-sm btn-warning" style="display: inline-block;">
                    <i class="fas fa-edit"></i>
                  </a>
                  <!-- Formulir Penghapusan -->
                  <form id="delete-form-{{ $pasien->id_pasien }}" action="{{ route('admin-pasien.destroy', $pasien->id_pasien) }}" method="post" style="display: inline-block;">
                      @method('delete')
                      @csrf
                      <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $pasien->id_pasien }})">
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