@extends('layouts.main')
@section('content')
<!-- Main Content -->
<div id="content">
  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <form class="form-inline">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </form>
    <ul class="navbar-nav ml-auto">
      <div class="topbar-divider d-none d-sm-block"></div>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
          <img class="img-profile rounded-circle" src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{ route('profile.show') }}">
            <i class="fas fa-user"></i> {{ __('Profile') }}
          </a>
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
    <h1 class="h3 mb-3 text-gray-800 font-weight-bold">Tambah Data Antrian Pasien</h1>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="font-weight-bold text-primary">Data Antrian Pasien</h5>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin-antrian.store') }}">
          @csrf
          <div class="form-group">
            <label for="nama">Nama</label>
            <select name="id_pasien" id="id_pasien" class="form-control">
              @foreach($pasien as $p)
                <option value="{{ $p->id_pasien }}">{{ $p->nama }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="id">Nama Fisioterapis</label>
            <select name="id" id="id" class="form-control">
              @foreach($fisioterapis as $f)
                <option value="{{ $f->id }}">{{ $f->nama }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="tanggal_terapi">Tanggal Terapi</label>
            <input type="date" name="tanggal_terapi" id="tanggal_terapi" class="form-control" min="{{ date('Y-m-d') }}" onchange="validateTanggalTerapi()">
          </div>

          <div class="form-group">
            <label for="jam_terapi">Jam Terapi</label>
            <select name="jam_terapi" id="jam_terapi" class="form-control">
              @foreach($jam_terapi as $jam)
                <option value="{{ $jam }}">{{ $jam }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <textarea name="keluhan" id="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="3" placeholder="Deskripsikan keluhan Anda">{{ old('keluhan') }}</textarea>
                @error('keluhan')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
              <option value="tertunda">Tertunda</option>
              <option value="disetujui">Disetujui</option>
              <option value="ditolak">Ditolak</option>
            </select>
          </div>

          <button type="submit" class="btn btn-info">Tambah</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    document.getElementById('tanggal_terapi').addEventListener('change', function() {
    let tanggalTerapi = new Date(this.value);
    let hari = tanggalTerapi.getDay(); // Mengambil hari dalam minggu (0 = Minggu, 1 = Senin, dst)
    
    // Menyesuaikan jam terapi berdasarkan hari
    let jamSelect = document.getElementById('jam_terapi');
    jamSelect.innerHTML = ''; // Kosongkan opsi jam sebelumnya
    
    // Menyusun daftar jam berdasarkan hari yang dipilih
    let jamOptions = [];
    
    if (hari >= 1 && hari <= 5) { // Senin - Jumat
        // Jam 09:00 - 11:00
        for (let i = 9; i <= 11; i++) {
            let hour = i < 10 ? '0' + i : i;
            jamOptions.push(hour + ':00');
        }
        
        // Jam 15:00 - 19:00
        for (let i = 15; i <= 19; i++) {
            let hour = i < 10 ? '0' + i : i;
            jamOptions.push(hour + ':00');
        }
    } else if (hari === 6) { // Sabtu
        // Jam 08:00 - 12:00
        for (let i = 8; i <= 12; i++) {
            let hour = i < 10 ? '0' + i : i;
            jamOptions.push(hour + ':00');
        }
    }
    
    // Masukkan jam yang tersedia ke dalam dropdown
    jamOptions.forEach(function(jam) {
        let option = document.createElement('option');
        option.value = jam;
        option.textContent = jam;
        jamSelect.appendChild(option);
    });
});

    // Validasi tanggal terapi (tidak boleh hari Minggu atau hari kemarin)
    function validateTanggalTerapi() {
        let tanggalTerapi = new Date(document.getElementById('tanggal_terapi').value);
        let hari = tanggalTerapi.getDay();
        let today = new Date();
        let yesterday = new Date(today);
        yesterday.setDate(today.getDate() - 1);
        
        if (hari === 0) {
            alert('Tanggal terapi tidak boleh hari Minggu');
            document.getElementById('tanggal_terapi').value = '';
        } else if (tanggalTerapi <= yesterday) {
            alert('Tanggal terapi tidak boleh sebelum hari ini');
            document.getElementById('tanggal_terapi').value = '';
        }
    }
</script>

@endsection
