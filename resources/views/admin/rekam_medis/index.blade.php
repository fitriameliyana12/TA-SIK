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
          <form method="GET" action="{{ route('admin-rekam-medis.index') }}" class="form-inline">
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
                    <th>JK</th>
                    <th>Usia</th>
                    <th>Keluhan</th>
                    <th>Diagnosa</th>
                    <th>Penanganan</th>
                    <th>Tanggal Terapi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($data as $key => $row)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $row->pasien->no_rekam_medis }}</td>
                        <td>{{ $row->pasien->nama }}</td>
                        <td>{{ $row->pasien->jenis_kelamin }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->pasien->tanggal_lahir)->age }}</td>
                        <td>{{ $row->antrian->keluhan }}</td>
                        <td>{{ $row->diagnosa }}</td>
                        <td>{{ $row->penanganan }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->antrian->tanggal_terapi)) }}</td>
                        <td class="text-center">
                          <a href="{{ route('admin-rekam-medis.show', $row->id_rekam_medis) }}" class="btn btn-sm btn-success"> <i class="fas fa-eye"></i></a>
                          <!-- Formulir Penghapusan -->
                          <form id="delete-form-{{ $row->id_rekam_medis }}" action="{{ route('admin-rekam-medis.destroy', $row->id_rekam_medis) }}" method="post" style="display: inline-block;">
                              @method('delete')
                              @csrf
                              <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $row->id_rekam_medis }})">
                                  <i class="fas fa-trash"></i>
                              </button>
                          </form>
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
