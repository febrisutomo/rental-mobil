<?php
if ($_SESSION['login'] != 'user') {
    header('Location:index.php#login');
}
$koneksi = mysqli_connect('localhost', 'root', '', 'rental_mobil');
$id_user = $_SESSION['id'];
$profil = select("SELECT * FROM tb_user WHERE id_user = $id_user")[0];
$sql_active = mysqli_query($koneksi, "CALL userActiveRent($id_user)");
$active = mysqli_fetch_assoc($sql_active);
$rents = select("CALL userLogRent($id_user)");

function cancel($id)
{
    $conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');
    $sql = "UPDATE tb_transaksi SET 
                    status = 'dibatalkan'
                    WHERE id_transaksi = $id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function updateProfil($id, $data)
{
    $conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');
    global $profil;

    $nama = htmlspecialchars($data['nama']);
    $alamat = htmlspecialchars($data['alamat']);
    $nik = htmlspecialchars($data['nik']);
    $no_hp = htmlspecialchars($data['no_hp']);
    $email = htmlspecialchars($data['email']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $gambar_lama = $data['gambar_lama'];

    if (($_POST["nama"] == $profil['nama']) and
        ($_POST["alamat"] == $profil['alamat']) and
        ($_POST["nik"] == $profil['nik']) and
        ($_POST["no_hp"] == $profil['no_hp']) and
        ($_POST["email"] == $profil['email']) and
        ($_POST['password']) == "" and
        empty($_FILES['gambar']['name'])
    ) {
        return "sama";
    } elseif (empty($_FILES['gambar']['name'])) {
        $gambar = $gambar_lama;
    } else {
        $gambar = upload2('user');
        if ($gambar == "tipe") {
            return $gambar;
            exit;
        } elseif ($gambar == "ukuran") {
            return $gambar;
            exit;
        } else {
            if (file_exists('src/img/user/' . $gambar_lama)) {
                unlink('src/img/user/' . $gambar_lama);
            }
        }
    }

    if ($_POST['password'] == '') {
        $query = "UPDATE tb_user SET 
        nama='$nama', 
        alamat='$alamat', 
        nik='$nik', 
        no_hp='$no_hp',
        email='$email',
        foto ='$gambar'
        WHERE id_user = $id
    ";
    } else {
        $query = "UPDATE tb_user SET 
        nama='$nama', 
        alamat='$alamat', 
        nik='$nik', 
        no_hp='$no_hp',
        email='$email',
        password='$password',
        foto ='$gambar'
        WHERE id_user = $id
    ";
    }


    $cek = mysqli_query($conn, $query);
    if ($cek == true) {
        return 1;
    } else {
        return 0;
    }
}
?>
<section id="profil" class="mt-5">
    <div class="section-title">
        <h2>Profile</h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header font-weight-bold">Detail Akun</div>
                    <div class="card-body">
                        <table class="table table-borderless table-striped text-left">
                            <img class="container-fluid mb-3" src="src/img/user/<?= $profil['foto']; ?>">
                            <tbody>
                                <tr>
                                    <td>Nama</td>
                                    <td>: <?= $profil['nama']; ?></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>: <?= $profil['nik']; ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: <?= $profil['alamat']; ?></td>
                                </tr>
                                <tr>
                                    <td>Nomor HP</td>
                                    <td>: <?= $profil['no_hp']; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: <?= $profil['email']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#edit-profil"><i class="fa fa-edit"></i> Edit Account</button>
                        <a href="?page=profil&logout=true" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin logout?')"><i class="fa fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header font-weight-bold">Transaksi Berlangsung</div>
                    <div class="card-body">
                        <?php if (is_null($active)) : ?>
                            Anda sedang tidak melakukan booking atau rental!
                            <a href="index.php#cars"> Booking Sekarang</a>
                        <?php else : ?>
                            <table class="table table-borderless table-striped text-left">
                                <tbody>
                                    <tr>
                                        <td>ID Transaksi</td>
                                        <td>: TRX<?= $active['id_transaksi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl/Jam Pick up</td>
                                        <td>: <?= date('d/m/Y H:i', strtotime($active['tgl_sewa'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Mobil</td>
                                        <td>: <?= $active['nama_mobil']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Transmisi</td>
                                        <td>: <?= $active['transmisi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Warna Mobil</td>
                                        <td>: <?= $active['warna']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tarif</td>
                                        <td>: Rp<?= $active['harga']; ?>.000/hari</td>
                                    </tr>
                                    <tr>
                                        <td>Durasi</td>
                                        <td>: <?= $active['durasi']; ?> hari</td>
                                    </tr>
                                    <td>Total Harga</td>
                                    <td>: <?= rupiah($active['total_harga']); ?></td>
                                    </tr>
                                    </tr>
                                    <td>Status</td>
                                    <?php if ($active['status'] == 'dibooking') : ?>
                                        <td>
                                            : <span class="badge badge-warning">dibooking</span>
                                        </td>
                                    <?php elseif ($active['status'] == 'disewakan') : ?>
                                        <td>
                                            : <span class="badge badge-primary">disewa</span>
                                        </td>
                                    <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="?page=print&id=<?= $id_user; ?>" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Cetak</a>
                            <?php if ($active['status'] == 'disewakan') : ?>
                            <?php else : ?>
                                <a href="?page=profil&cancel=<?= $active['id_transaksi']; ?>" onclick="return confirm('Anda yakin ingin membatalkan booking?')" class="btn btn-danger" title="Batalkan">
                                    <i class="fa fa-ban"></i> Batalkan
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header font-weight-bold">Riwayat Transaksi</div>
                    <div class="card-body">
                        <?php if (empty($rents)) : ?>
                            Belum ada riwayat transaksi!
                        <?php else : ?>
                            <table class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <!-- <th>ID Transaksi</th> -->
                                        <th>Tgl Pick up</th>
                                        <th>Mobil</th>
                                        <th>Durasi</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($rents as $rent) : ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <!-- <td>TRX<?= $rent['id_transaksi']; ?></td> -->
                                            <td><?= date('d/m/Y', strtotime($rent['tgl_sewa'])); ?></td>
                                            <td><?= $rent['nama_mobil']; ?></td>
                                            <td><?= $rent['durasi']; ?> hari</td>
                                            <td><?= rupiah($rent['total_harga']); ?></td>
                                            <td class=" text-center">
                                                <?= date('d/m/Y', strtotime($rent['tgl_kembali'])) ?>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-detail<?= $rent['id_transaksi']; ?>" title="Detail">
                                                    <i class="fa fa-info-circle"></i>
                                                </button>
                                                <div class="modal fade" id="modal-detail<?= $rent['id_transaksi']; ?>" role="dialog">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Detail Transaksi</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body ">
                                                                <table class="table table-borderless text-left">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>ID Transaksi</td>
                                                                            <td>: TRX<?= $rent['id_transaksi']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Tgl/Jam Pick up</td>
                                                                            <td>: <?= date('d/m/Y H:i', strtotime($rent['tgl_sewa'])); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Nama Mobil</td>
                                                                            <td>: <?= $rent['nama_mobil']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Transmisi</td>
                                                                            <td>: <?= $rent['transmisi']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Tarif</td>
                                                                            <td>: <?= rupiah($rent['harga']); ?>/hari</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Durasi</td>
                                                                            <td>: <?= $rent['durasi']; ?> hari</td>
                                                                        </tr>
                                                                        <td>Total Harga</td>
                                                                        <td>: <?= rupiah($rent['total_harga']); ?>,-</td>
                                        </tr>
                                        <tr>
                                            <td>Tgl/Jam Kembali</td>
                                            <td>: <?= date('d/m/Y H:i', strtotime($rent['tgl_kembali'])); ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Denda</td>
                                            <td>: <?= rupiah($rent['denda']); ?></td>
                                        </tr>
                                </tbody>
                            </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-dark" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        </td>
        </tr>
        <?php $no++; ?>
    <?php endforeach; ?>
    </tbody>
    </table>
<?php endif; ?>
    </div>
    </div>
    </div>
</section>

<!-- modal edit profil  -->
<div class="modal fade" id="edit-profil" role="dialog">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="card">
                    <!-- form start -->
                    <form id="mobil" action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nama" class="col-4">Nama Lengkap</label>
                                <input type="text" class="form-control col-8" name="nama" id="nama" placeholder="Masukkan Nama" value="<?= $profil['nama']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label for="nik" class="col-4">NIK</label>
                                <input type="number" class="form-control col-8" name="nik" id="nik" placeholder="Masukkan NIK" value="<?= $profil['nik']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-4">Alamat</label>
                                <input type="text" class="form-control col-8" name="alamat" id="alamat" placeholder="Masukkan Alamat" value="<?= $profil['alamat']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label for="no_hp" class="col-4">Nomor HP</label>
                                <input type="text" class="form-control col-8" name="no_hp" id="no_hp" placeholder="Masukkan Alamat" value="<?= $profil['no_hp']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-4">Email</label>
                                <input type="email" class="form-control col-8" name="email" id="email" placeholder="Masukkan Alamat" value="<?= $profil['email']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-4">Ganti Password</label>
                                <input type="password" class="form-control col-8" name="password" id="password" placeholder="Masukkan Password Baru">
                            </div>
                            <input type="hidden" name="gambar_lama" id="gambar_lama" value="<?= $profil['foto']; ?>">
                            <div class="form-group row">
                                <label for="gambar" class="col-4">Ganti Foto KTP</label>
                                <div class="custom-file col-8">
                                    <input type="file" class="custom-file-input" name="gambar" id="gambar">
                                    <label class="custom-file-label" for="gambar">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="ubah" class="btn btn-primary">Simpan</button>
                            <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default ml-auto" data-dismiss="modal">Tutup</button>
                </div> -->
            </div>
        </div>
    </div>
</div>

<?php
// ubah profil alert
if (isset($_POST["ubah"])) {
    $ubah = updateProfil($id_user, $_POST);
    if ($ubah === 1) {
        echo "
          <script>
              Swal.fire({
                  icon: 'success',
                  title: 'Profil berhasil diperbarui!',
                  showConfirmButton: false,
                  timer: 1500,
              })
              .then(function() {
                  window.location = '?page=profil';
              });
          </script>
      ";
    } elseif ($ubah === "tipe") {
        echo "
          <script>
              Swal.fire({
                  icon: 'warning',
                  title: 'Tipe file tidak diperbolehkan!',
              })
          </script>
      ";
    } elseif ($ubah === "ukuran") {
        echo "
          <script>
              Swal.fire({
                  icon: 'warning',
                  title: 'Ukuran file terlalu besar!',
              })
          </script>
      ";
    } elseif ($ubah === "sama") {
        echo "
          <script>
              Swal.fire({
                  icon: 'warning',
                  title: 'Tidak ada perubahan data!',
              })
          </script>
      ";
    } elseif ($ubah === 0) {
        echo "
          <script>
              Swal.fire({
                  icon: 'error',
                  title: 'Data gagal diperbarui!',
              })
          </script>
      ";
    }
}


// cancel alert
if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    $sql = "UPDATE tb_transaksi SET 
            status = 'dibatalkan'
            WHERE id_transaksi = $id
            ";
    $koneksi = mysqli_connect('localhost', 'root', '', 'rental_mobil');
    mysqli_query($koneksi, $sql);
    $batalkan = mysqli_affected_rows($koneksi);
    if ($batalkan > 0) {
        echo "
          <script>
            Swal.fire({
                icon: 'success',
                title: 'Booking Berhasil Dibatalkan!',
                showConfirmButton: false,
                timer: 1500,
              })
              .then(function() {
                window.location.href = '?page=profil';
              });
          </script>
        ";
    } else {
        echo "
          <script>
            Swal.fire({
                icon: 'warning',
                title: 'Gagal dibatalkan',
                showConfirmButton: false,
                timer: 1500,
              })
          </script>
        ";
    }
}


// logout alert
if (isset($_GET['logout'])) {
    if ($_GET['logout'] == 'true') {
        session_destroy();
        echo
        "
          <script>
              Swal.fire({
                  icon: 'success',
                  title: 'Anda Berhasil Logout!',
                  showConfirmButton: false,
                  timer: 1500,
              })
              .then(function() {
                  window.location = 'index.php';
              });
          </script>
          ";
        exit;
    }
}

?>