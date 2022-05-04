<?php

function tambah($data)
{
    global $conn;

    $nama_mobil = htmlspecialchars($data['nama_mobil']);
    $id_jenis = htmlspecialchars($data['id_jenis']);
    $transmisi = htmlspecialchars($data['transmisi']);
    $jml_seat = htmlspecialchars($data['jml_seat']);
    $warna = htmlspecialchars($data['warna']);
    $harga = htmlspecialchars($data['harga']);

    if (empty($_FILES['gambar']['name'])) {
        $gambar = 'car.png';
    } else {
        $gambar = upload('mobil');
        if ($gambar == "tipe") {
            return $gambar;
        } elseif ($gambar == "ukuran") {
            return $gambar;
        }
    }
    $query = "INSERT INTO tb_mobil (nama_mobil, id_jenis, transmisi, jml_seat, warna, gambar, harga) VALUES('$nama_mobil', $id_jenis, '$transmisi', $jml_seat, '$warna', '$gambar', $harga)";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

?>

<form id="mobil" action="" method="POST" enctype="multipart/form-data">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Masukkan Data Mobil</h3>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label for="nama_mobil" class="col-4">Nama Mobil</label>
                <input type="text" class="form-control col-8" name="nama_mobil" id="nama_mobil" placeholder="Masukkan Nama" required>
            </div>
            <div class="form-group row">
                <label for="id_jenis" class="col-4">Jenis Mobil</label>
                <select class="form-control col-8" name="id_jenis" id="id_jenis" required>
                    <option hidden="" value="">--Pilih Jenis Mobil--</option>
                    <option value="1">Sedan</option>
                    <option value="2">SUV</option>
                    <option value="3">MPV</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="transmisi" class="col-4">Transmisi</label>
                <select class="form-control col-8" name="transmisi" id="transmisi" required>
                    <option hidden="" value="">--Pilih Transmisi--</option>
                    <option value="Manual">Manual</option>
                    <option value="Otomatis">Otomatis</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="jml_seat" class="col-4">Jumlah Seat</label>
                <input type="number" class="form-control col-8" name="jml_seat" id="jml_seat" placeholder="Masukkan Jumlah Seat" required>
            </div>
            <div class="form-group row">
                <label for="warna" class="col-4">Warna</label>
                <input type="text" class="form-control col-8" name="warna" id="warna" placeholder="Masukkan Warna Mobil" required>
            </div>
            <div class="form-group row">
                <label for="harga" class="col-4">Tarif/hari</label>
                <div class="input-group col-8 p-0">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="number" class="form-control" name="harga" id="harga" placeholder="Masukkan Tarif" required>
                    <div class="input-group-append">
                        <span class="input-group-text">.000</span>
                    </div>
                </div>
            </div>
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
            <div class="float-right">
                <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                <a href="?page=data-mobil" class="btn btn-secondary">Kembali</a>
            </div>
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
                title: 'Mobil berhasil ditambahkan!',
                showConfirmButton: false,
                timer: 1500,
            })
            .then(function() {
                window.location = '?page=data-mobil';
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
    } else {
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Mobil gagal ditambahkan!',
                })
            </script>
        ";
    }
}

?>