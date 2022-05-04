<?php

$members = select("SELECT * FROM tb_user");

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_user WHERE id_user = $id");
    return mysqli_affected_rows($conn);
}

?>

<div class="card">
    <div class="card-header">
        <!-- <h3 class="card-title">Tabel Daftar Anggota</h3> -->
        <a href="?page=tambah-user" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tbuser" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Id User</th>
                    <th>Nama</th>
                    <th>Nomor KTP</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($members as $member) : ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td>USR<?= $member['id_user']; ?></td>
                        <td><?= $member['nama']; ?></td>
                        <td><?= $member['nik']; ?></td>
                        <td><?= $member['alamat']; ?></td>
                        <td><?= $member['no_hp']; ?></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-detail<?= $member['id_user']; ?>" title="Detail">
                                <i class="fa fa-info-circle"></i>
                            </button>
                            <div class="modal fade" id="modal-detail<?= $member['id_user']; ?>" role="dialog">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Detail User</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body row">
                                            <div class="col-md-6 m-auto">
                                                <img class="container-fluid mb-3" src="../src/img/user/<?= $member['foto']; ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless text-left">
                                                    <tbody>
                                                        <tr>
                                                            <td>Id User</td>
                                                            <td>: USR<?= $member['id_user']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama User</td>
                                                            <td>: <?= $member['nama']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nomor KTP</td>
                                                            <td>: <?= $member['nik']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alamat</td>
                                                            <td>: <?= $member['alamat']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nomor HP</td>
                                                            <td>: <?= $member['no_hp']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>: <?= $member['email']; ?></td>
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
                            <a class="btn btn-danger btn-sm" href="?page=data-user&delete=<?= $member['id_user']; ?>" title="Hapus" onclick="return confirm('Apakah anda yakin ingin menghapus user <?= 'AG' . $member['id_user'] . ' - ' . $member['nama']; ?>?')">
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
                    title: 'User berhasil dihapus!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=data-user';
                });
            </script>
        ";
    } else {
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Data gagal dihapus!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=data-user';
                });
            </script>
        ";
    }
}

?>