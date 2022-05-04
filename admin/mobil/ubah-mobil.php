<?php

$id = $_GET['id'];
$car = select("SELECT * FROM tb_mobil WHERE id_mobil = $id")[0];

function ubah($id, $data)
{
    global $conn;
    global $car;

    $nama_mobil = htmlspecialchars($data['nama_mobil']);
    $id_jenis = htmlspecialchars($data['id_jenis']);
    $transmisi = htmlspecialchars($data['transmisi']);
    $jml_seat = htmlspecialchars($data['jml_seat']);
    $warna = htmlspecialchars($data['warna']);
    $gambar_lama = htmlspecialchars($data['gambar_lama']);
    $harga = htmlspecialchars($data['harga']);

    if (($_POST["nama_mobil"] == $car['nama_mobil']) and
        ($_POST["id_jenis"] == $car['id_jenis']) and
        ($_POST["transmisi"] == $car['transmisi']) and
        ($_POST["jml_seat"] == $car['jml_seat']) and
        ($_POST["warna"] == $car['warna']) and
        ($_POST["harga"] == $car['harga']) and
        empty($_FILES['gambar']['name'])
    ) {
        return "sama";
    } elseif (empty($_FILES['gambar']['name'])) {
        $gambar = $gambar_lama;
    } else {
        $gambar = upload('mobil');
        if ($gambar == "tipe") {
            return $gambar;
        } elseif ($gambar == "ukuran") {
            return $gambar;
        } else {
            if (file_exists('../src/img/mobil/' . $gambar_lama) and $gambar_lama != 'car.jpg') {
                unlink('../src/img/mobil/' . $gambar_lama);
            }
        }
    }

    $query = "UPDATE tb_mobil SET 
                nama_mobil='$nama_mobil', 
                id_jenis=$id_jenis, 
                jml_seat=$jml_seat, 
                warna='$warna',
                harga=$harga,
                transmisi='$transmisi',
                gambar='$gambar'
                WHERE id_mobil = $id
            ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}


?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Data Mobil</h3>
    </div>
    <div class="card-body">
        <!-- row  -->
        <div class="row">
            <!-- left column  -->
            <div class="col-md-6 m-auto">
                <!-- <div class="card"> -->
                <img class="container-fluid mb-3" src="../src/img/mobil/<?= $car['gambar']; ?>">
                <!-- </div> -->
            </div>
            <!-- right column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card">
                    <!-- form start -->
                    <form id="mobil" action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nama_mobil" class="col-4">Nama Mobil</label>
                                <input type="text" class="form-control col-8" name="nama_mobil" id="nama_mobil" placeholder="Masukkan Nama" value="<?= $car['nama_mobil']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label for="id_jenis" class="col-4">Jenis Mobil</label>
                                <select class="form-control col-8" name="id_jenis" id="id_jenis" required>
                                    <option hidden="" value="">--Pilih Jenis Mobil--</option>
                                    <option value="1" <?= $car['id_jenis'] == "1" ? 'selected' : ''; ?>>Sedan</option>
                                    <option value="2" <?= $car['id_jenis'] == "2" ? 'selected' : ''; ?>>SUV</option>
                                    <option value="3" <?= $car['id_jenis'] == "3" ? 'selected' : ''; ?>>MPV</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="transmisi" class="col-4">Transmisi</label>
                                <select class="form-control col-8" name="transmisi" id="transmisi" required>
                                    <option hidden="" value="">--Pilih Jenis Mobil--</option>
                                    <option value="Manual" <?= $car['transmisi'] == "Manual" ? 'selected' : ''; ?>>Manual</option>
                                    <option value="Otomatis" <?= $car['transmisi'] == "Otomatis" ? 'selected' : ''; ?>>Otomatis</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="jml_seat" class="col-4">Jumlah Seat</label>
                                <input type="number" class="form-control col-8" name="jml_seat" id="jml_seat" placeholder="Masukkan Jumlah Seat" value="<?= $car['jml_seat']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label for="warna" class="col-4">Warna</label>
                                <input type="text" class="form-control col-8" name="warna" id="warna" placeholder="Masukkan Warna" value="<?= $car['warna']; ?>" required>
                            </div>
                            <div class="form-group row">
                                <label for="harga" class="col-4">Tarif/hari</label>
                                <div class="input-group col-8 p-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" name="harga" id="harga" placeholder="Masukkan Tarif" value="<?= $car['harga']; ?>" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.000</span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="gambar_lama" value="<?= $car['gambar']; ?>">
                            <div class="form-group row">
                                <label for="gambar" class="col-4">Gambar Mobil</label>
                                <div class="custom-file col-8">
                                    <input type="file" class="custom-file-input" name="gambar" id="gambar">
                                    <label class="custom-file-label" for="gambar">Choose file</label>
                                    <div class="text-primary text-sm">Tipe file yang diperbolehkan: jpg, jpeg, png, gif</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                            <a href="?page=data-mobil" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- ./right column -->
        </div>
        <!-- ./row  -->
    </div>
</div>
<!-- ./main card  -->

<?php

if (isset($_POST["submit"])) {
    $ubah = ubah($id, $_POST);
    if ($ubah > 0) {
        echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Mobil berhasil diubah!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=data-mobil';
                });
            </script>
        ";
    } elseif ($ubah == "tipe") {
        echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Tipe file tidak diperbolehkan!',
                })
            </script>
        ";
    } elseif ($ubah == "ukuran") {
        echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran file terlalu besar!',
                })
            </script>
        ";
    } elseif ($ubah == "sama") {
        echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak ada perubahan data!',
                })
            </script>
        ";
    } else {
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Data gagal diubah!',
                })
            </script>
        ";
    }
}
?>