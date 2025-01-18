@extends('layouts.main')

@section('content')
<!-- Main Content -->
<div id="content" class="d-flex flex-column min-vh-100">
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow w-100">
    <form class="form-inline">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </form>
    <div class="container-fluid px-0">
      <ul class="navbar-nav ml-auto w-100 d-flex justify-content-between">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-black-50 big">{{ Auth::user()->username }}</span>
            <img class="img-profile rounded-circle" src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}">
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ route('profile.show') }}">
              <i class="fas fa-user"></i> {{ __('Profile') }}
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
        <h6 class="m-0 font-weight-bold text-primary">Ambil Antrian Terapi</h6>
      </div>
      <div class="card-body">
        @if(session('success'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
          </div>
        @elseif(session('error'))
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('error') }}
          </div>
        @endif
        <form action="{{ route('proses.terapi') }}" method="POST">
          @csrf
          <!-- @method('PUT') -->

          <div class="row">
            <!-- Nama Field -->
            <div class="col-md-6 mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" value="{{ Auth::user()->pasien->nama }}" readonly>
            </div>

            <!-- Usia Field -->
            <div class="col-md-6 mb-3">
                <label for="usia" class="form-label">Usia</label>
                @php
                    $usia = null;
                    if(Auth::user()->pasien && Auth::user()->pasien->tanggal_lahir) {
                        $usia = \Carbon\Carbon::parse(Auth::user()->pasien->tanggal_lahir)->age;
                    }
                @endphp
                <input type="number" class="form-control" id="usia" name="usia" 
                    value="{{ $usia }}" readonly>
            </div>
          
            <!-- Tanggal Terapi Field -->
            <div class="col-md-6 mb-3">
                <label for="tanggal_terapi" class="form-label">Tanggal Terapi</label>
                <input type="date" class="form-control" id="tanggal_terapi" name="tanggal_terapi" required>
            </div>

            <!-- Jam Terapi Field -->
            <div class="col-md-6 mb-3">
            <label for="jam_terapi" class="form-label">Jam Terapi</label>
            <select class="form-control" id="jam_terapi" name="jam_terapi" required>
                <option value="">Pilih Jam</option>
            </select>
            </div>
          </div>

          <div class="row">
            <!-- Keluhan Field -->
            <div class="col-md-6 mb-3">
              <label for="keluhan" class="form-label">Keluhan</label>
              <textarea class="form-control" id="keluhan" name="keluhan" rows="3" required></textarea>
            </div>

            <!-- Nama Fisioterapis Field -->
            <div class="col-md-6 mb-3">
              <label for="id_fisioterapis" class="form-label">Nama Fisioterapis</label>
              <select name="id_fisioterapis" class="form-select" required>
                <option value="">Pilih Fisioterapis</option>
                @foreach($fisioterapis as $fisioterapis)
                    <option value="{{ $fisioterapis->id }}">{{ $fisioterapis->nama }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Ambil Jam</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tanggalTerapi = document.getElementById('tanggal_terapi');
    const jamTerapi = document.getElementById('jam_terapi');

    // Atur batas minimal tanggal (H+1)
    const today = new Date();
    const minDate = new Date(today);
    minDate.setDate(today.getDate() + 1);

    tanggalTerapi.min = minDate.toISOString().split('T')[0];

    tanggalTerapi.addEventListener('change', function () {
      const selectedDate = new Date(this.value);
      const dayOfWeek = selectedDate.getDay(); // 0: Minggu, 1: Senin, ..., 6: Sabtu

      // Validasi agar hari Minggu tidak dapat dipilih
      if (dayOfWeek === 0) {
        alert('Klinik tutup pada hari Minggu. Pilih hari lain.');
        this.value = '';
        jamTerapi.innerHTML = '<option value="">Pilih Jam</option>';
        return;
      }

      // Atur jam terapi sesuai hari yang dipilih
      const hours = [];
      if (dayOfWeek >= 1 && dayOfWeek <= 5) { // Senin-Jumat
        for (let hour = 8; hour <= 19; hour++) {
          if (hour < 12 || hour >= 15) { // Kecuali jam istirahat 12.00-14.59
            hours.push(`${hour}:00`);
          }
        }
      } else if (dayOfWeek === 6) { // Sabtu
        for (let hour = 8; hour <= 12; hour++) {
          hours.push(`${hour}:00`);
        }
      }

      // Update opsi jam terapi
      jamTerapi.innerHTML = '<option value="">Pilih Jam</option>';
      hours.forEach(hour => {
        const option = document.createElement('option');
        option.value = hour; // Gunakan hanya jam, tanpa format 'hour:00 - hour+1:00'
        option.textContent = `${hour} - ${parseInt(hour) + 1}:00`; // Menampilkan format 'hour:00 - hour+1:00'
        jamTerapi.appendChild(option);
      });
    });
  });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function() {
    // Inisialisasi dropdown
  });
</script>


@endsection



