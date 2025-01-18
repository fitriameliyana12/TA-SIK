@extends('layouts.main')
@section('content')
<div id="content">
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <form class="form-inline">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </form>
    <ul class="navbar-nav ml-auto">
      <div class="topbar-divider d-none d-sm-block"></div>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->username }}</span>
          <img class="img-profile rounded-circle" src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}">
        </a>
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

  <div class="container-fluid">
    <center><h1 class="h2 mb-2 text-gray-1000 font-weight-bold">Data Rekam Medis Pasien</h1></center>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">

          <!-- Form Pencarian -->
          <form method="GET" action="{{ route('fisioterapis.rekam_medis.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-sm ml-2">Cari</button>
          </form>
        </div>
      </div>


      <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Rekam Medis</th>
                    <th>Nama Lengkap</th>
                    <th>Keluhan</th>
                    <th>Jam Terapi</th>
                    <th>Tanggal Terapi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($antrians as $key => $antrian)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $antrian->pasien->no_rekam_medis }}</td>
                        <td>{{ $antrian->pasien->nama }}</td>
                        <td>{{ $antrian->keluhan }}</td>
                        <td>{{ $antrian->jam_terapi }}</td>
                        <td>{{ $antrian->tanggal_terapi }}</td>
                        <td class="text-center">
                          <a href="{{ route('fisioterapis.rekam_medis.show', $antrian->id_antrian) }}" class="btn btn-sm btn-success"> <i class="fas fa-eye"></i></a>
                          <a href="{{ route('fisioterapis.rekam_medis.edit', $antrian->id_antrian) }}" class="btn btn-sm btn-warning"> <i class="fas fa-edit"></i></a>
                          {{-- <a href="#" 
                            class="btn btn-sm btn-success" 
                            data-toggle="modal" 
                            data-target="#detailModal" 
                            data-norekammedis="{{ $antrian->pasien->no_rekam_medis }}" 
                            data-nama="{{ $antrian->pasien->nama }}" 
                            data-keluhan="{{ $antrian->keluhan }}" 
                            data-jamterapi="{{ $antrian->jam_terapi }}" 
                            data-tanggalterapi="{{ $antrian->tanggal_terapi }}">
                            <i class="fas fa-eye"></i>
                          </a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
      </div>
    </div>

<!-- Modal for Viewing Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Rekam Medis</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>Nomor Rekam Medis:</strong> <span id="detailNoRekamMedis"></span></p>
        <p><strong>Nama Lengkap:</strong> <span id="detailNama"></span></p>
        <p><strong>Keluhan:</strong> <span id="detailKeluhan"></span></p>
        <p><strong>Jam Terapi:</strong> <span id="detailJamTerapi"></span></p>
        <p><strong>Tanggal Terapi:</strong> <span id="detailTanggalTerapi"></span></p>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Adding Rekam Medis -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('fisioterapis.rekam_medis.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Tambah Rekam Medis</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="noRekamMedis">Nomor Rekam Medis</label>
            <input type="text" class="form-control" id="noRekamMedis" name="no_rekam_medis" required>
          </div>
          <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
          </div>
          <div class="form-group">
            <label for="keluhan">Keluhan</label>
            <textarea class="form-control" id="keluhan" name="keluhan" required></textarea>
          </div>
          <div class="form-group">
            <label for="jamTerapi">Jam Terapi</label>
            <input type="time" class="form-control" id="jamTerapi" name="jam_terapi" required>
          </div>
          <div class="form-group">
            <label for="tanggalTerapi">Tanggal Terapi</label>
            <input type="date" class="form-control" id="tanggalTerapi" name="tanggal_terapi" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>



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
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
