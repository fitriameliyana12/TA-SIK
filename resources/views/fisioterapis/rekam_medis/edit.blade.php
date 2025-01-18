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
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Rekam Medis Pasien</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('fisioterapis.rekam_medis.update', $antrian->id_antrian) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_rekam_medis" value="{{ $antrian->rekamMedis!=null ? $antrian->rekamMedis->id_rekam_medis : '' }}">
                <div class="row">
                    <div class="col-6">
                        <table class="table table-borderless" width="100%">
                            <tbody>
                                <tr>
                                    <th width="30%">No Rekam Medis</th>
                                    <th width="2%">:</th>
                                    <td>{{ $antrian->pasien->no_rekam_medis }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Pasien</th>
                                    <th>:</th>
                                    <td>{{ $antrian->pasien->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <th>:</th>
                                    <td>{{ $antrian->pasien->jenis_kelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <td>{{ $antrian->pasien->alamat }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <table class="table table-borderless" width="100%">
                            <tbody>
                                <tr>
                                    <th width="30%">Tanggal Lahir</th>
                                    <th width="2%">:</th>
                                    <td>{{ date('d-m-Y', strtotime($antrian->pasien->tanggal_lahir)) }}</td>
                                </tr>
                                <tr>
                                    <th>Keluhan</th>
                                    <th>:</th>
                                    <td>{{ $antrian->keluhan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Terapi</th>
                                    <th>:</th>
                                    <td>{{ date('d-m-Y', strtotime($antrian->tanggal_terapi)) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="diagnosa" class="form-label">Diagnosa</label>
                            @php
                                $diagnosa = old('diagnosa') ?? ($antrian->rekamMedis!=null ? $antrian->rekamMedis->diagnosa : '');
                            @endphp
                            <input type="text" name="diagnosa" id="diagnosa" class="form-control" value="{{ $diagnosa }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="penanganan" class="form-label">Penanganan</label>
                            @php
                                $penanganan = old('penanganan') ?? ($antrian->rekamMedis!=null ? $antrian->rekamMedis->penanganan : '');
                            @endphp
                            <input type="text" name="penanganan" id="penanganan" class="form-control" value="{{ $penanganan }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="pemeriksaan_umum" class="form-label">Pemeriksaan Umum</label>
                            @php
                                $pemeriksaan_umum = old('pemeriksaan_umum') ?? ($antrian->rekamMedis!=null ? $antrian->rekamMedis->pemeriksaan_umum : '');
                            @endphp
                            <input type="text" name="pemeriksaan_umum" id="pemeriksaan_umum" class="form-control" value="{{ $pemeriksaan_umum }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="pemeriksaan_fisioterapis" class="form-label">Pemeriksaan Fisioterapis</label>
                            @php
                                $pemeriksaan_fisioterapis = old('pemeriksaan_fisioterapis') ?? ($antrian->rekamMedis!=null ? $antrian->rekamMedis->pemeriksaan_fisioterapis : '');
                            @endphp
                            <input type="text" name="pemeriksaan_fisioterapis" id="pemeriksaan_fisioterapis" class="form-control" value="{{ $pemeriksaan_fisioterapis }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="tujuan_program" class="form-label">Tujuan Program</label>
                            @php
                                $tujuan_program = old('tujuan_program') ?? ($antrian->rekamMedis!=null ? $antrian->rekamMedis->tujuan_program : '');
                            @endphp
                            <input type="text" name="tujuan_program" id="tujuan_program" class="form-control" value="{{ $tujuan_program }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="intervensi" class="form-label">Intervensi</label>
                            @php
                                $intervensi = old('intervensi') ?? ($antrian->rekamMedis!=null ? $antrian->rekamMedis->intervensi : '');
                            @endphp
                            <input type="text" name="intervensi" id="intervensi" class="form-control" value="{{ $intervensi }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="evaluasi" class="form-label">Evaluasi</label>
                            @php
                                $evaluasi = old('evaluasi') ?? ($antrian->rekamMedis!=null ? $antrian->rekamMedis->evaluasi : '');
                            @endphp
                            <input type="text" name="evaluasi" id="evaluasi" class="form-control" value="{{ $evaluasi }}" required>
                        </div>
                    </div>
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

