<?php
session_start();
require 'utility/function.php';

$cars = select("SELECT * FROM tb_mobil WHERE status_mobil ='tersedia' ");

function login($data)
{
  global $conn;
  $email = $data['email'];
  $password = $data['password'];

  $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email'");
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row['password'])) {
      session_start();
      $_SESSION['login'] = 'user';
      $_SESSION['id'] = $row['id_user'];
      $_SESSION['nama'] = $row['nama'];
      $_SESSION['email'] = $row['email'];
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function register($data)
{
  global $conn;

  $nama = htmlspecialchars($data['nama']);
  $nik = htmlspecialchars($data['nik']);
  $alamat = htmlspecialchars($data['alamat']);
  $email = htmlspecialchars($data['email']);
  $no_hp = htmlspecialchars($data['no_hp']);
  $password = htmlspecialchars($data['password']);
  $password = password_hash($password, PASSWORD_DEFAULT);


  $gambar = upload2('user');
  if ($gambar == "tipe" or $gambar == "ukuran") {
    return $gambar;
  }

  $result = mysqli_query($conn, "SELECT email FROM tb_user WHERE email = '$email'");
  if (mysqli_fetch_assoc($result)) {
    return "email";
    exit;
  }

  $query = "INSERT INTO tb_user VALUES (NULL, '$nama', '$alamat', '$nik', '$gambar', '$no_hp', '$email', '$password')";
  mysqli_query($conn, $query);

  return mysqli_affected_rows($conn);
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS -->
  <link rel="stylesheet" href="src/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="src/plugins/boxicons/css/boxicons.min.css">
  <link rel="stylesheet" href="src/plugins/owl.carousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="src/plugins/aos/aos.css">
  <link rel="stylesheet" href="src/plugins/sweetalert2/sweetalert2.min.css">
  <link rel="stylesheet" href="src/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="src/plugins/fontawesome-free/css/all.min.css">
  <script src="src/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="src/plugins/jquery/jquery1.js"></script>
  <link rel="stylesheet" href="src/plugins/jquery-ui/jquery-ui.min.css">
  <script src="src/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- <script src="src\plugins\jquery\jquery.min.js"></script> -->




  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css"
    integrity="sha256-H8c0yAkzdmZ1/anJofhnKJ3ljR5t3IViHho361BqIro=" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
    integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
    crossorigin="anonymous" /> -->

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="src/css/style.css">

  <title>FS-Rental :: Rental Mobil</title>
</head>

<body>
  <!-- navigation bar  -->
  <nav class="navbar navbar-expand-md fixed-top">
    <div class="container">
      <a class="navbar-brand text-primary font-weight-bold" href="index.php">FS-Rental</a>
      <div class="navbar-btn" data-toggle="collapse" data-target="#navbarCollapse">
        <i id="nav-icon" class="bx bx-menu"></i>
      </div>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav m-auto">
          <li class="nav-item">
            <a class="nav-link active" href="index.php#hero">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#cars">Cars</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php#contact">Contact</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <?php if (isset($_SESSION['login']) && $_SESSION['login'] == 'user') : ?>
              <a class="nav-link btn btn-primary" href="?page=profil"><i class="bx bx-user-circle d-inline-block" style="font-size: 24px; vertical-align:middle"></i> <?= $_SESSION['nama'] ?></a>
            <?php else : ?>
              <a class="nav-link btn btn-primary" href="#" data-toggle="modal" data-target="#modal-login">Sign in</a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <?php
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    switch ($page) {
      case 'rental';
        include 'rental.php';
        break;
      case 'profil';
        include 'profil.php';
        break;
      case 'print';
        include 'print.php';
        break;
      case 'error-404';
        include '404.php';
        break;
      default:
        echo "
                    <script>
                        window.location.href = 'index.php?page=error-404';
                    </script>
                ";
        break;
    }
  } else {
    include './homepage.php';
  }
  ?>



  <!-- footer  -->
  <footer id="footer">
    <div class="container">
      <div class="social-links">
        <a href="http://twitter.com/febrisoetomo" target="_blank"><i class="bx bxl-twitter"></i></a>
        <a href="http://facebook.com/febrisoetomo" target="_blank"><i class="bx bxl-facebook"></i></a>
        <a href="http://instagram.com/febrisutomo" target="_blank"><i class="bx bxl-instagram"></i></a>
        <a href="http://t.me/skylark28" target="_blank"><i class="bx bxl-telegram"></i></a>
        <a href="#"><i class="bx bxl-discord"></i></a>
      </div>
      <div class="copyright">
        &copy; 2021 <strong><span>Febri Sutomo</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer>

  <!-- Vendor Js File -->
  <script src="src/plugins/jquery.easing/jquery.easing.min.js"></script>
  <script src="src/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="src/plugins/typed.js/typed.min.js"></script>
  <script src="src/plugins/owl.carousel/owl.carousel.min.js"></script>
  <script src="src/plugins/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="src/plugins/aos/aos.js"></script>
  <script src="src/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>


  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"
    integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ=="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.bundle.min.js"
    integrity="sha512-iceXjjbmB2rwoX93Ka6HAHP+B76IY1z0o3h+N1PeDtRSsyeetU3/0QKJqGyPJcX63zysNehggFwMC/bi7dvMig=="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.5/typed.min.js"
    integrity="sha512-1KbKusm/hAtkX5FScVR5G36wodIMnVd/aP04af06iyQTkD17szAMGNmxfNH+tEuFp3Og/P5G32L1qEC47CZbUQ=="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"
    integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew=="
    crossorigin="anonymous"></script> -->

  <!-- Template Main JS File -->
  <script src="src/js/main.js"></script>

  <!-- login modal  -->
  <div class="modal fade" id="modal-login" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header border-bottom-0">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-title text-center">
            <h4>Login</h4>
          </div>
          <div class="d-flex flex-column text-center">
            <form action="" method="post">
              <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your email address..." required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Your password..." required>
              </div>
              <button type="submit" class="btn btn-primary btn-block btn-round" name="login">Login</button>
            </form>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <div class="signup-section">Not a member yet? <a href="#" class="text-primary" id="register"> Sign Up</a>.</div>
        </div>
      </div>
    </div>
  </div>

  <!-- register modal  -->
  <div class="modal fade" id="modal-register" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header border-bottom-0">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-title text-center">
            <h4>Register</h4>
          </div>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="nama">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-group">
                  <label for="nik">No KTP</label>
                  <input type="text" class="form-control" name="nik" id="nik" placeholder="Masukkan nomor KTP" required>
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat rumah" required>
                </div>
                <div class="form-group">
                  <label for="no_hp">Nomor Telepon</label>
                  <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="Masukkan nomor telepon" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan email" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password" required>
                </div>
                <div class="form-group">
                  <label for="password2">Ulangi Password</label>
                  <input type="password" class="form-control" name="password2" id="password2" placeholder="Ulangi password" required>
                </div>
                <div class="form-group">
                  <label for="gambar">Foto KTP</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="gambar" id="gambar">
                    <label class="custom-file-label" for="gambar">Choose file</label>
                    <div class="text-primary text-sm">File yg diizinkan : jpg, jpeg, png, gif</div>
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-round" name="register">Register</button>
          </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <div class="signup-section">Already have an account? <a href="#" id="login" class="text-primary"> Sign in</a>.</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    bsCustomFileInput.init();
  </script>

  <!-- sudah punya akun -->
  <script>
    $("#register").click(function() {
      $('#modal-login').modal('hide');
      $('#modal-register').modal('show');
    });
    $("#login").click(function() {
      $('#modal-register').modal('hide');
      $('#modal-login').modal('show');

    });
  </script>

  <!-- login dulu  -->
  <script>
    if (window.location.hash == "#login") {
      $("#modal-login").modal("show");
    }
  </script>

  <!-- melebihi batas  -->
  <!-- <script>
    function melebihiBatas() {
      Swal.fire({
          icon: 'warning',
          title: 'Melebihi Batas Sewa !',
          text: 'Batalkan pesanan atau kembalikan mobil yang sedang dirental!'
          // showConfirmButton: false,
          // timer: 1500,
        })
        .then(function() {
            window.location.href = '?page=profil';
          });
    };
  </script> -->

</html>

<!-- login  -->
<?php
if (isset($_POST['login'])) {
  if (login($_POST)) {
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
  } else {
    echo "
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: 'Email atau password salah!',
        showConfirmButton: false,
        timer: 1500,
      });
    </script>
  ";
  }
}

// register 
if (isset($_POST["register"])) {
  $register = register($_POST);
  if ($register > 0) {
    echo "
      <script>
          Swal.fire({
              icon: 'success',
              title: 'Register Berhasil!',
              text: 'Silahkan Login',
              showConfirmButton: false,
              timer: 1500,
          })
          .then(function() {
            $('#modal-login').modal('show');
          });
      </script>
  ";
  } elseif ($register == "ukuran") {
    echo "
      <script>
          Swal.fire({
              icon: 'warning',
              title: 'Ukuran file terlalu besar!',
          })
          .then(function() {
            $('#modal-register').modal('show');
          });
      </script>
  ";
    exit;
  } elseif ($register == "tipe") {
    echo "
      <script>
          Swal.fire({
              icon: 'warning',
              title: 'Tipe file tidak diperbolehkan!',
          })
          .then(function() {
            $('#modal-register').modal('show');
          });
      </script>
  ";
    exit;
  } elseif ($register == "email") {
    echo "
      <script>
          Swal.fire({
              icon: 'warning',
              title: 'Email telah digunakan!',
          })
          .then(function() {
            $('#modal-register').modal('show');
          });
      </script>
  ";
    exit;
  } else {
    echo "
          <script>
              Swal.fire({
                  icon: 'error',
                  title: 'User gagal ditambahkan!',
              })
              .then(function() {
                $('#modal-register').modal('show');
              });
          </script>
      ";
  }
}


?>