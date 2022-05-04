<?php
require '../utility/function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../src/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../src/css/adminlte.min.css">
  <!-- sweetalert2  -->
  <link rel="stylesheet" href="../src/plugins/sweetalert2/sweetalert2.min.css">
  <!-- theme bootstrap for sweetalert2   -->
  <link rel="stylesheet" href="../src/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../src/index2.html" class="h1"><b>Register</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Register a new account</p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password2" id="password2" placeholder="Konfirmasi Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <button type="submit" name="btn-register" class="btn btn-primary btn-block">Register</button>
        </form>
        <a href="login.php" class="text-center">I already have an account</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="../src/plugins/jquery/jquery.min.js"></script>
  <!-- jquery-validation -->
  <script src="../src/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../src/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- sweetalert2  -->
  <script src="../src/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      $('form').validate({
        rules: {
          nama: {
            required: true,
          },
          username: {
            required: true,
          },
          password: {
            required: true,
            minlength: 3
          },
          password2: {
            required: true,
            equalTo: "#password"
          },
        },
        messages: {
          nama: {
            required: "Mohon masukkan nama lengkap anda.",
          },
          username: {
            required: "Mohon masukkan username.",
          },
          password: {
            required: "Mohon masukkan password.",
            minlength: "Password minimal 3 karakter."
          },
          password2: {
            required: "Mohon konfirmasi password.",
            equalTo: "Konfirmasi password tidak sesuai."
          },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.input-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
</body>

</html>

<?php

if (isset($_POST['btn-register'])) {
  $nama = htmlspecialchars($_POST['nama']);
  $username = htmlspecialchars(strtolower($_POST['username']));
  // $password = htmlspecialchars($_POST['password']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // cek apakah username sudah terdaftar
  $result = mysqli_query($conn, "SELECT username FROM tb_admin WHERE username = '$username'");
  if (mysqli_fetch_assoc($result)) {
    echo "
      <script>
        Swal.fire({
          icon: 'warning',
          title: 'Registrasi Gagal',
          text: 'Username telah terdaftar!',
        });
      </script>
    ";
    exit;
  }

  // enkripsi password 
  $password = password_hash($password, PASSWORD_DEFAULT);

  $cek = mysqli_query($conn, "INSERT INTO tb_admin VALUES(NULL, '$nama', '$username', '$password')");

  if ($cek) {
    echo "
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil',
        text: 'Silahkan Login!',
      })
      .then(function() {
        window.location.href = 'login.php';
      });
    </script>
  ";
  } else {
    echo "
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Registrasi Gagal',
        text: 'Silahkan Registrasi Ulang!',
      })
    </script>
  ";
  }
}

?>