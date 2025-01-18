<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="d-flex align-items-center" style="min-height: 100vh; background: linear-gradient(to bottom, #d3d3d3, #007bff);">

  <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card o-hidden border-0 shadow-lg my-5" style="max-width: 500px; width: 100%; padding: 20px;">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5" style="padding-top: 10px;"> <!-- Mengurangi padding atas untuk mendekatkan ke form -->
              <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4" style="font-size: 1.8rem;">Halaman Register</h1>
              <img src="img/logo1.jpg" alt="Logo" style="width: 120px; height: auto; margin-bottom: 30px;">
              </div>
              <form action="{{ route('register') }}" method="POST" class="user" enctype="multipart/form-data">
                @csrf

                <!-- Username -->
                <div class="form-group">
                <label for="username">Username :</label>  
                  <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror"
                    name="username" id="username" placeholder="Username" value="{{ old('username') }}">
                  @error('username')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <!-- Password -->
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <label for="password">Password :</label>  
                    <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                      id="exampleInputPassword" name="password" placeholder="Password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                  <label for="password_confirmation">Ulangi Password :</label>  
                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword"
                      name="password_confirmation" placeholder="Repeat Password">
                  </div>
                </div>

                <!-- No.Telepon -->
                <div class="form-group">
                <label for="tanggal_lahir">No. Telepon Aktif :</label>
                  <input type="number" class="form-control form-control-user @error('telepon') is-invalid @enderror"
                    name="telepon" id="telepon" placeholder="+62" value="{{ old('telepon') }}">
                  @error('telepon')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-user btn-block" style="font-size: 18px;">
                  {{ __('Register') }}
                </button>

                <hr>
              </form>
              <div class="text-center">
                <a class="small" href="{{ route('login') }}"  style="font-size: 16px;">Sudah Punya Akun? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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