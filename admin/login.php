<?php
require '../utility/function.php';

function login($data){
  global $conn;
  $username = $data['username'];
  $password = $data['password'];

  $result = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$username'");
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
      session_start();
      $_SESSION['login'] = 'admin';
      $_SESSION['nama'] = $row['nama'];
      $_SESSION['username'] = $row['username'];
      return true;
    }
    else{
      return false;
    }
  }
  else{
    return false;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../src/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../src/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../src/css/adminlte.min.css">
  <!-- sweetalert2  -->
  <link rel="stylesheet" href="../src/plugins/sweetalert2/sweetalert2.min.css">
  <!-- theme bootstrap for sweetalert2   -->
  <link rel="stylesheet" href="../src/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="index2.html" class="h1"><b>Admin Login</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block" name="submit">Login</button>
        </form>

        <!-- <p class="mb-0">
          <a href="register.php" class="text-center">Register a new account</a>
        </p> -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../src/plugins/jquery/jquery.min.js"></script>
  <!-- sweetalert2  -->
  <script src="../src/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- jquery-validation -->
  <script src="../src/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../src/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      $('form').validate({
        rules: {
          username: {
            required: true
          },
          password: {
            required: true
          }
        },
        messages: {
          username: {
            required: "Email tidak boleh kosong!"
          },
          password: {
            required: "Password tidak boleh kosong!"
          }
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
if(isset($_POST['submit'])) {
  if(login($_POST)){
    echo "
      <script>
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil!',
            showConfirmButton: false,
            timer: 1500,
          })
          .then(function() {
            window.location.href = 'index.php';
          });
      </script>
    ";
    exit;
  }
  else{
    echo "
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: 'Username atau password salah!',
        showConfirmButton: false,
        timer: 1500,
      });
    </script>
  ";
  }
}
?>