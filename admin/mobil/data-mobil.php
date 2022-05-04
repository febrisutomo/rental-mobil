<?php
$cars = select("SELECT * FROM tb_mobil");

function hapus($id)
{
    global $conn;
    $gambar = select("SELECT * FROM tb_mobil WHERE id_mobil = $id")[0]['gambar'];

    $gambar2 = $gambar;

    mysqli_query($conn, "DELETE FROM tb_mobil WHERE id_mobil = $id");

    if (mysqli_affected_rows($conn) > 0 && file_exists('../src/img/mobil/' . $gambar2) && $gambar2 != 'car.png') {
        unlink('../src/img/mobil/' . $gambar2);
    }

    return mysqli_affected_rows($conn);
}
?>

<div class="card">
    <div class="card-header">
        <!-- <h3 class="card-title">Tabel Daftar mobil</h3> -->
        <a href="?page=tambah-mobil" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Mobil</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tbmobil" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <!-- <th>Gambar</th> -->
                    <th>Nama Mobil</th>
                    <th>Transmisi</th>
                    <th>Tarif/hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($cars as $car) : ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <!-- <td><img src="../src/img/mobil/<?= $car['gambar']; ?>" width="150px"></td> -->
                        <td><?= $car['nama_mobil']; ?></td>
                        <td><?= $car['transmisi']; ?></td>
                        <td><?= rupiah($car['harga']); ?></td>
                        <td>
                            <?php if ($car['status_mobil'] == 'dibooking') : ?>
                                <div class="badge badge-warning">
                                    Dibooking
                                </div>
                            <?php elseif ($car['status_mobil'] == 'disewa') : ?>
                                <div class="badge badge-primary">
                                    Dipinjam
                                </div>
                            <?php else : ?>
                                <div class="badge badge-success">
                                    Tersedia
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-detail<?= $car['id_mobil']; ?>" title="Detail">
                                <i class="fa fa-info-circle"></i>
                            </button>
                            <div class="modal fade" id="modal-detail<?= $car['id_mobil']; ?>" role="dialog">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Detail Mobil</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body row">
                                            <div class="col-md-6 m-auto">
                                                <img class="container-fluid mb-3" src="../src/img/mobil/<?= $car['gambar']; ?>">
                                            </div>
                                            <div class="col-md-6">
                                            <table class="table table-borderless text-left">
                                                <tbody>
                                                    <tr>
                                                        <td>ID Mobil</td>
                                                        <td>: CAR<?= $car['id_mobil']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Mobil</td>
                                                        <td>: <?= $car['nama_mobil']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis</td>
                                                        <td>: 
                                                            <?= $car['id_jenis'] == "1" ? 'Sedan' : ''; ?>
                                                            <?= $car['id_jenis'] == "2" ? 'SUV' : ''; ?>
                                                            <?= $car['id_jenis'] == "3" ? 'MPV' : ''; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Transmisi</td>
                                                        <td>: 
                                                            <?= $car['transmisi'] == "Manual" ? 'Manual' : ''; ?>
                                                            <?= $car['transmisi'] == "Otomatis" ? 'Otomatis' : ''; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumlah Seat</td>
                                                        <td>: <?= $car['jml_seat']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Warna Mobil</td>
                                                        <td>: <?= $car['warna']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tarif</td>
                                                        <td>: <?= rupiah($car['harga']); ?>/hari</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default ml-auto" data-dismiss="modal">Tutup</button>
                                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-primary btn-sm" href="?page=ubah-mobil&id=<?= $car['id_mobil']; ?>" title="Ubah">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="?page=data-mobil&delete=<?= $car['id_mobil']; ?>" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus mobil <?= $car['nama_mobil']; ?>?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php

if (isset($_GET['delete'])) {
    $hapus = hapus($_GET['delete']);
    if ($hapus > 0) {
        echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'mobil berhasil dihapus!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=data-mobil';
                });
            </script>
        ";
    } else {
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Data gagal dihapus!',
                })
                .then(function() {
                    window.location = '?page=data-mobil';
                });
            </script>
        ";
    }
}
?>