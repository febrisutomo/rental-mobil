<?php

$id = $_GET['id'];
$member = select("SELECT * FROM tb_anggota WHERE id_anggota = $id")[0];

function ubah($id, $data)
{
    global $conn;
    global $member;

    $nama = htmlspecialchars($data['nama']);
    $jenis_kelamin = htmlspecialchars($data['jenis_kelamin']);
    $no_hp = htmlspecialchars($data['no_hp']);

    if (($_POST["nama"] == $member['nama']) and
        ($_POST["jenis_kelamin"] == $member['jenis_kelamin']) and
        ($_POST["no_hp"] == $member['no_hp'])
    ) {
        return "sama";
    }

    $query = "UPDATE tb_anggota SET 
                nama='$nama', 
                jenis_kelamin='$jenis_kelamin', 
                no_hp='$no_hp'
                WHERE id_anggota = $id
            ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

?>


<form id="anggota" action="" method="POST" enctype="multipart/form-data">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ubah Data Anggota</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama Anggota</label>
                <input type="text" class="form-control" name="nama" id="nama" value="<?= $member['nama']; ?>" placeholder="Masukkan nama anggota" required>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                    <option hidden="" value="">--Pilih Jenis Kelamin--</option>
                    <option value="Laki-laki" <?= $member['jenis_kelamin'] == "Laki-laki" ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $member['jenis_kelamin'] == "Perempuan" ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="no_hp">Nomor Telepon</label>
                <input type="number" class="form-control" name="no_hp" id="no_hp" value="<?= $member['no_hp']; ?>" placeholder="Masukkan nomor telepon" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
            <a href="?page=data-anggota" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</form>

<?php

if (isset($_POST["submit"])) {
    $ubah = ubah($id, $_POST);
    if ($ubah > 0) {
        echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Buku berhasil diubah!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=data-anggota';
                });
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