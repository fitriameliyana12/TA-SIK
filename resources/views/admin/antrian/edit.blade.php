@extends('layouts.main')

@section('content')
<!-- Main Content -->
<div id="content">

  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <form class="form-inline">
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </form>

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
    <h1 class="h3 mb-3 text-gray-800 font-weight-bold">Edit Data Antrian</h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="font-weight-bold text-primary">Form Edit Data Antrian</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('admin-antrian.update', $antrian->id_antrian) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="form-group">
            <label for="id_pasien">Nama Pasien:</label>
            <select name="id_pasien" id="id_pasien" class="form-control" required>
              @foreach ($pasien as $p)
                <option value="{{ $p->id_pasien }}" {{ $antrian->id_pasien == $p->id_pasien ? 'selected' : '' }}>
                  {{ $p->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="tanggal_terapi">Tanggal Terapi:</label>
            <input type="date" name="tanggal_terapi" id="tanggal_terapi" class="form-control" value="{{ $antrian->tanggal_terapi }}" required>
          </div>

          <div class="form-group">
            <label for="jam_terapi">Jam Terapi:</label>
            <input type="time" name="jam_terapi" id="jam_terapi" class="form-control" value="{{ $antrian->jam_terapi }}" required>
          </div>

          <div class="form-group">
            <label for="id">Fisioterapis:</label>
            <select name="id" id="id" class="form-control" required>
              @foreach($fisioterapis as $f)
                <option value="{{ $f->id }}" {{ $antrian->id == $f->id ? 'selected' : '' }}>
                  {{ $f->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Fungsi untuk mengupdate jam terapi berdasarkan tanggal yang dipilih
  function updateJamTerapi() {
    let tanggalTerapi = new Date(document.getElementById('tanggal_terapi').value);
    let hari = tanggalTerapi.getDay(); // 0 = Minggu, 1 = Senin, dst
    let jamSelect = document.getElementById('jam_terapi');
    jamSelect.innerHTML = ''; // Kosongkan opsi jam sebelumnya

    let jamOptions = [];
    if (hari === 0) { // Hari Minggu
      alert('Hari Minggu Klinik Tutup');
      document.getElementById('tanggal_terapi').value = ''; // Kosongkan tanggal
      return;
    } else if (hari >= 1 && hari <= 5) { // Senin - Jumat
      for (let i = 9; i <= 11; i++) {
        jamOptions.push(`${i < 10 ? '0' + i : i}:00`);
      }
      for (let i = 15; i <= 19; i++) {
        jamOptions.push(`${i < 10 ? '0' + i : i}:00`);
      }
    } else if (hari === 6) { // Sabtu
      for (let i = 8; i <= 12; i++) {
        jamOptions.push(`${i < 10 ? '0' + i : i}:00`);
      }
    }

    jamOptions.forEach(jam => {
      let option = document.createElement('option');
      option.value = jam;
      option.textContent = jam;
      jamSelect.appendChild(option);
    });
  }

  document.getElementById('tanggal_terapi').addEventListener('change', updateJamTerapi);
</script>

@endsection
