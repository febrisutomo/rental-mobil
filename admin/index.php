<?php
session_start();
require '../utility/function.php';
if ($_SESSION['login'] != 'admin') {
    header('Location:login.php');
}

$page = $_GET['page'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FS-Rental :: Admin</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../src/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../src/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../src/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../src/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- sweetalert2  -->
    <link rel="stylesheet" href="../src/plugins/sweetalert2/sweetalert2.min.css">
    <script src="../src/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- theme bootstrap for sweetalert2   -->
    <link rel="stylesheet" href="../src/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- jQuery UI  -->
    <link rel="stylesheet" href="../src/plugins/jquery-ui/jquery-ui.min.css">
    <!-- select2  -->
    <link rel="stylesheet" href="../src/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../src/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- jQuery  -->
    <script src="../src/plugins/jquery/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <span id="timestamp" class="nav-link" style="font-size: 20px;"></span>
                    <script>
                        // Function ini dijalankan ketika Halaman ini dibuka pada browser
                        $(function() {
                            setInterval(timestamp, 1000); //fungsi yang dijalan setiap detik, 1000 = 1 detik
                        });

                        //Fungi ajax untuk Menampilkan Jam dengan mengakses File ajax_timestamp.php
                        function timestamp() {
                            $.ajax({
                                url: '../utility/ajax_timestamp.php',
                                success: function(data) {
                                    $('#timestamp').html(data);
                                },
                            });
                        }
                    </script>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-primary text-bold" href="index.php">FEBRI SUTOMO RENTAL MOBIL</i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="../src/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-bold">
                    <h4>FS-RENTAL</h4>
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel pt-3 pb-3 d-flex">
                    <div class="image mb-auto mt-auto">
                        <img src="../src/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION['nama'] ?></a>
                        <!-- <span class=" badge badge-success"><?= $_SESSION['level'] ?></span> -->
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?= $page == '' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=data-mobil" class="nav-link <?= $page == 'data-mobil' ? 'active' : ''; ?>">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Data Mobil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=data-user" class="nav-link <?= $page == 'data-user' ? 'active' : ''; ?>">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Data User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=transaksi-rental" class="nav-link <?= $page == 'transaksi-rental' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-exchange-alt"></i>
                                <p>Transaksi Rental</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=log-rental" class="nav-link <?= $page == 'log-rental' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-history"></i>
                                <p>Log Rental</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link" onclick="return confirm('Apakah anda yakin ingin logout?')">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <?php
                            if (isset($_GET['page'])) {
                                if (strpbrk($_GET['page'], "-")) {
                                    $word = explode("-", $_GET['page']);
                                    $title = $word[0];
                                    $title .= " ";
                                    $title .= $word[1];
                                } else {
                                    $title = $_GET['page'];
                                }
                            }
                            ?>
                            <h1 class="m-0"><?= isset($_GET['page']) ? ucwords($title) : 'Dashboard'; ?></h1>
                        </div><!-- /.col -->
                        <?php if (isset($_GET['page'])) : ?>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active"><?= ucwords($title); ?></li>
                                </ol>
                            </div><!-- /.col -->
                        <?php endif; ?>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->

                    <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];

                        switch ($page) {
                            case 'data-mobil';
                                include './mobil/data-mobil.php';
                                break;
                            case 'tambah-mobil';
                                include './mobil/tambah-mobil.php';
                                break;
                            case 'ubah-mobil';
                                include './mobil/ubah-mobil.php';
                                break;
                            case 'data-user';
                                include './user/data-user.php';
                                break;
                            case 'tambah-user';
                                include './user/tambah-user.php';
                                break;
                            case 'ubah-user';
                                include './user/ubah-user.php';
                                break;
                            case 'transaksi-rental';
                                include './rental/data-rental.php';
                                break;
                            case 'tambah-rental';
                                include './rental/tambah-rental.php';
                                break;
                            case 'log-rental';
                                include './rental/log-rental.php';
                                break;
                            case 'error-404';
                                include '../404.php';
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
                        include './dashboard.php';
                    }

                    ?>

                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="#">FS-Rental</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->


    <!-- Bootstrap 4 -->
    <script src="../src/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../src/js/adminlte.min.js"></script>
    <!-- jQuery UI  -->
    <script src="../src/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <?php if (isset($_GET['page'])) : ?>
        <!-- DataTables  & Plugins -->
        <script src="../src/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../src/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../src/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../src/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="../src/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../src/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="../src/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="../src/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="../src/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <!-- jquery-validation -->
        <script src="../src/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="../src/plugins/jquery-validation/additional-methods.min.js"></script>
        <!-- bs-custom-file-input -->
        <script src="../src/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <script>
            $("#mobil").validate({
                rules: {
                    gambar: {
                        accept: "image/*",
                        maxsize: 1 * 1024 * 1024,
                    }
                },
                messages: {
                    gambar: {
                        accept: "Tipe file tidak diperbolehkan.",
                        maxsize: "Ukuran file tidak boleh lebih dari 1 MB."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $("#user").validate({
                rules: {
                    gambar: {
                        accept: "image/*",
                        maxsize: 1 * 1024 * 1024,
                    }
                },
                messages: {
                    gambar: {
                        accept: "Tipe file tidak diperbolehkan.",
                        maxsize: "Ukuran file tidak boleh lebih dari 1 MB."
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            bsCustomFileInput.init();
        </script>

        <?php if ($_GET['page'] != 'log-rental') : ?>
            <script>
                $(".table").DataTable({
                    responsive: false,
                    "scrollX": true,
                    // lengthChange: false, 
                    autoWidth: false,
                });
            </script>
        <?php elseif ($_GET['page'] == 'log-rental') : ?>
            <script>
                $("#tblog").DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    buttons: ["copy", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#tblog_wrapper .col-md-6:eq(0)');
            </script>
        <?php elseif ($_GET['page'] == 'tambah-rental') : ?>
            <!-- select2  -->
            <script src="../src/plugins/select2/js/select2.full.min.js"></script>
            <script>
                $('#id_mobil').select2({
                    theme: 'bootstrap4',
                });
                $('#id_user').select2({
                    theme: 'bootstrap4',
                });
            </script>
        <?php endif; ?>
    <?php else : ?>
        <!-- momentJS -->
        <script src="../src/plugins/moment/moment.min.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="../src/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
        <script>
            $('#calendar').datetimepicker({
                format: 'L',
                inline: true
            });
        </script>
    <?php endif; ?>
</body>

</html>