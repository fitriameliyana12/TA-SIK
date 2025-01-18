<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login Page</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="d-flex align-items-center" style="min-height: 100vh; background: linear-gradient(to bottom, #d3d3d3, #007bff);">
  <div class="container d-flex justify-content-center align-items-center">
    <!-- Outer Row -->
    <div class="col-xl-6 col-lg-8 col-md-6">
      <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-12">
              <div class="p-4">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4" style="font-size: 1.8rem;">Halaman Login</h1>
                  <img src="img/logo1.jpg" alt="Logo" style="width: 120px; height: auto; margin-bottom: 30px;">
                </div>

                <!-- Display global error messages -->
                @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form class="user" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <input type="text" class="form-control @error('username') is-invalid @enderror"
               name="username" value="{{ old('username') }}" required autocomplete="username"
               placeholder="Username" style="border-radius: 7px; font-size: 1rem; padding: 1.3rem;">
        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <input type="password" class="form-control @error('password') is-invalid @enderror"
               name="password" required autocomplete="current-password" placeholder="Password"
               style="border-radius: 7px; font-size: 1rem; padding: 1.3rem;">
    </div>
    <div class="form-group">
        <div class="custom-control custom-checkbox small">
            <input type="checkbox" name="remember" class="custom-control-input" id="customCheck"
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="custom-control-label" for="customCheck" style="font-size: 1rem;">Remember Me</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block"
            style="font-size: 1.2rem; padding: 0.75rem;">
        Login
    </button>
    <hr>
</form>
<div class="text-center">
    <a class="small" href="{{ route('register') }}" style="font-size: 1.1rem;">Belum Punya Akun? Register</a>
</div>


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
