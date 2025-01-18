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
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->username }}</span>
          <img class="img-profile rounded-circle" src="{{ Auth::user()->foto ? asset('storage/foto/' . Auth::user()->foto) : asset('foto/default-profile.png') }}">
        </a>
        <!-- Dropdown - User Information -->
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

  </nav>
  <!-- End of Topbar -->

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Edit Akun User</h1>
    <p>Edit informasi akun user</p>

    <!-- Edit Form -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <form action="{{ route('admin-user.update', ['admin_user' => $user->id_user]) }}" method="POST">
          @csrf
          @method('PUT')
         
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{ $user->username }}" required>
          </div>

          <div class="form-group">
            <label for="password">Password (Kosongkan jika tidak ingin mengganti)</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>

          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
          </div>

          <div class="form-group">
            <label for="telepon">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Telepon" value="{{ $user->telepon }}" required>
          </div>

          <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control" id="role" required>
              <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="fisioterapis" {{ $user->role === 'fisioterapis' ? 'selected' : '' }}>Fisioterapis</option>
              <option value="pasien" {{ $user->role === 'pasien' ? 'selected' : '' }}>Pasien</option>
            </select>
          </div>

          <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto">
          </div>

          <button type="submit" class="btn btn-info">Update</button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

<!-- Validation Script -->
<script>
document.querySelector('form').addEventListener('submit', function (e) {
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm_password').value;

  if (password && password !== confirmPassword) {
    e.preventDefault();
    alert('Password dan Confirm Password tidak cocok!');
  }
});
</script>
