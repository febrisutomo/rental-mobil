<?php

if (!$_SESSION['login']) {
    header('Location:login.php');
}

function tambah($data)
{
    global $conn;

    $nama = htmlspecialchars($data['nama']);
    $nik = htmlspecialchars($data['nik']);
    $alamat = htmlspecialchars($data['alamat']);
    $email = htmlspecialchars($data['email']);
    $no_hp = htmlspecialchars($data['no_hp']);
    $password = htmlspecialchars($data['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);


    $gambar = upload('user');
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


<form id="user" action="" method="POST" enctype="multipart/form-data">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Masukkan Data User</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="nama" class="col-4">Nama Lengkap</label>
                <input type="text" class="form-control col-8" name="nama" id="nama" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="form-group row">
                <label for="nik" class="col-4">No KTP</label>
                <input type="text" class="form-control col-8" name="nik" id="nik" placeholder="Masukkan nomor KTP" required>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-4">Alamat</label>
                <input type="text" class="form-control col-8" name="alamat" id="alamat" placeholder="Masukkan alamat rumah" required>
            </div>
            <div class="form-group row">
                <label for="no_hp" class="col-4">Nomor Telepon</label>
                <input type="text" class="form-control col-8" name="no_hp" id="no_hp" placeholder="Masukkan nomor telepon" required>
            </div>
            <div class="form-group row">
                <label for="email" class="col-4">Email</label>
                <input type="email" class="form-control col-8" name="email" id="email" placeholder="Masukkan email" required>
            </div>
            <div class="form-group row">
                <label for="password" class="col-4">Password</label>
                <input type="password" class="form-control col-8" name="password" id="password" placeholder="Masukkan password" required>
            </div>
            <div class="form-group row">
                <label for="password2" class="col-4">Ulangi Password</label>
                <input type="password" class="form-control col-8" name="password2" id="password2" placeholder="Ulangi password" required>
            </div>
            <div class="form-group row">
                <label for="gambar" class="col-4">Foto KTP</label>
                <div class="custom-file col-8">
                    <input type="file" class="custom-file-input" name="gambar" id="gambar">
                    <label class="custom-file-label" for="gambar">Choose file</label>
                    <div class="text-primary text-sm">Tipe file yang diperbolehkan: jpg, jpeg, png, gif</div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="?page=data-user" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</form>

<?php
if (isset($_POST["submit"])) {
    $tambah = tambah($_POST);
    if ($tambah > 0) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'User berhasil ditambahkan!',
                showConfirmButton: false,
                timer: 1500,
            })
            .then(function() {
                window.location = '?page=data-user';
            });
        </script>
    ";
    } elseif ($tambah == "ukuran") {
        echo "
      <script>
          Swal.fire({
              icon: 'warning',
              title: 'Ukuran file terlalu besar!',
          })
      </script>
  ";
        exit;
    } elseif ($tambah == "tipe") {
        echo "
      <script>
          Swal.fire({
              icon: 'warning',
              title: 'Tipe file tidak diperbolehkan!',
          })
      </script>
  ";
        exit;
    } elseif ($tambah == "email") {
        echo "
      <script>
          Swal.fire({
              icon: 'warning',
              title: 'Email telah digunakan!',
          })
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
            </script>
        ";
    }
}

?>