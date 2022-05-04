<?php
$rents = select("CALL transaksiRental()");

function sewakan($id)
{
    $conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');
    $sql = "UPDATE tb_transaksi SET 
            status = 'disewakan'
            WHERE id_transaksi = $id";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function batalkan($id)
{
    $conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');
    $sql = "UPDATE tb_transaksi SET 
            status = 'dibatalkan'
            WHERE id_transaksi = $id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function kembalikan($id, $denda)
{
    $conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');
    $sql = "UPDATE tb_transaksi SET 
            status = 'dikembalikan',
            tgl_kembali = CURRENT_TIMESTAMP(),
            denda = $denda
            WHERE id_transaksi = $id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function cancel($id)
{
    $conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');
    $sql = "UPDATE tb_transaksi SET 
                    status = 'dibatalkan'
                    WHERE id_transaksi = $id";
    $result = mysqli_query($conn, $sql);
    return $result;
}


?>

<div class="card">
    <!-- <div class="card-header">
        <a href="?page=tambah-peminjaman" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Peminjaman</a>
    </div> -->
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Peminjam</th>
                    <th>Mobil</th>
                    <th>Tgl/Jam Pick up</th>
                    <th>Durasi</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rents as $rent) : ?>

                <!-- batal otomatis  -->
                <?php
                $now = date('d-m-Y H:i:s');
                $batas= date_create($rent['tgl_sewa']);
                $batas= date_add($batas, date_interval_create_from_date_string('1 hours'));
                $batas= date_format($batas, 'd-m-Y H:i:s');
                $batas = date('d-m-Y H:i:s', strtotime($batas));
                if( $now > $batas AND $rent['status'] == 'dibooking'){
                    batalkan($rent['id_transaksi']);
                }  
                ?>

                    <tr>
                        <td><?= $no; ?></td>
                        <td>TRX<?= $rent['id_transaksi']; ?></td>
                        <td><?= $rent['nama']; ?></td>
                        <td><?= $rent['nama_mobil']; ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($rent['tgl_sewa'])); ?></td>
                        <!-- <td><?= date('d/m/Y H:i:s', strtotime($rent['tgl_sewa'])); ?></td> -->
                        <td><?= $rent['durasi']; ?> Hari</td>
                        <td><?= rupiah($rent['total_harga']); ?></td>
                        <td class=" text-center">
                            <?php if ($rent['status'] == 'dibooking') : ?>
                                <div class="badge badge-warning">
                                    <?= $rent['status']; ?>
                                </div>
                            <?php elseif ($rent['status'] == 'disewakan') : ?>
                                <div class="badge badge-primary">
                                    <?= $rent['status']; ?>
                                </div>
                            <?php elseif ($rent['status'] == 'dibatalkan') : ?>
                                <div class="badge badge-danger">
                                    <?= $rent['status']; ?>
                                </div>
                            <?php else : ?>
                                <div class="badge badge-success">
                                    <?= $rent['status']; ?>
                                </div>
                            <?php endif; ?>
                        </td>

                        <!-- hitung denda  -->
                        <?php
                        $tgl_sewa = ($rent['tgl_sewa']);
                        $durasi =  $rent['durasi'];
                        $tgl_kembali= date('d-m-Y H:i:s', strtotime('+'.$durasi.' days', strtotime($tgl_sewa)));
                        $harga = $rent['total_harga'] / $rent['durasi'];
                        $awal  = date_create($tgl_kembali);

                        // $awal  = date_create('2021-05-22 19:00:00');
                        $akhir = date_create();
                        $diff  = date_diff($awal, $akhir);
                        $hari = $diff->format('%R%a');
                        $jam = $diff->h;
                        $jam = (int) $hari * 24 + $jam;
                        $denda = 0;
                        if ($jam > 0) {
                            $denda = $harga * 5 / 100 * $jam;
                        }

                        $batas1= date_create($rent['tgl_sewa']);
                        $batas1= date_add($batas1, date_interval_create_from_date_string('-1 hours'));
                        $batas1= date_format($batas1, 'd-m-Y H:i:s');
                          
                        ?>
                        <td>
                            <?php if ($rent['status'] != 'dibooking') : ?>
                            <?php else : ?>
                                <!-- <a href="?page=transaksi-rental&sewa=<?= $rent['id_transaksi']; ?>" class="btn btn-sm btn-primary" onclick="return confirm('Apakah anda yakin ingin menyewakan mobil ini?')"><i class="fa fa-car"></i> Sewakan</a> -->
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-sewakan<?= $rent['id_transaksi']; ?>" <?= $now >= $batas1 ? '': 'disabled'; ?>><i class="fa fa-car"></i> Sewakan</button>
                            <?php endif; ?>
                            <?php if ($rent['status'] != 'disewakan') : ?>
                            <?php else : ?>
                                <!-- <a href="?page=transaksi-rental&kembali=<?= $rent['id_transaksi']; ?>&d=<?= $denda; ?>" class="btn btn-sm btn-success" onclick="return confirm('Apakah anda yakin mobil ini sudah kembali? Denda = <?= rupiah($denda); ?>')"><i class="fa fa-home"></i> Kembalikan</a> -->
                                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-kembalikan<?= $rent['id_transaksi']; ?>"><i class="fa fa-home"></i> Kembalikan</button>
                            <?php endif; ?>

                            <div class="modal fade" id="modal-sewakan<?= $rent['id_transaksi']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Detail Rental</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-borderless text-left">
                                                <tbody>
                                                    <tr>
                                                        <td>ID Transaksi</td>
                                                        <td>: TRX<?= $rent['id_transaksi']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Peminjam</td>
                                                        <td>: <?= $rent['nama']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NIK</td>
                                                        <td>: <?= $rent['nik']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobil</td>
                                                        <td>: <?= $rent['nama_mobil']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tarif/hari</td>
                                                        <td>: <?= rupiah($harga); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tgl/Jam Rental</td>
                                                        <td>: <?= date('d/m/Y H:i', strtotime($rent['tgl_sewa'])) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Durasi</td>
                                                        <td>: <?= $rent['durasi']; ?> hari</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Harga</td>
                                                        <td>: <?= rupiah($rent['total_harga']); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <a href="?page=transaksi-rental&sewa=<?= $rent['id_transaksi']; ?>" type="button" class="btn btn-primary">Sewakan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal-kembalikan<?= $rent['id_transaksi']; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Detail Pengembalian</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-borderless text-left">
                                                <tbody>
                                                    <tr>
                                                        <td>ID Transaksi</td>
                                                        <td>: TRX<?= $rent['id_transaksi']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Peminjam</td>
                                                        <td>: <?= $rent['nama']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mobil</td>
                                                        <td>: <?= $rent['nama_mobil']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tarif/hari</td>
                                                        <td>: <?= rupiah($harga); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tgl/Jam Rental</td>
                                                        <td>: <?= date('d/m/Y H:i', strtotime($rent['tgl_sewa'])) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Durasi</td>
                                                        <td>: <?= $rent['durasi']; ?> hari</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tgl/Jam Kembali</td>
                                                        <td>: <?= date('d/m/Y H:i'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Terlambat</td>
                                                        <td>: <?= $jam . ' jam'; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Denda</td>
                                                        <td>: <?= rupiah($denda); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="mt-2 text-info text-right">*denda = 5% tarif x durasi terlambat (jam)</div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <a href="?page=transaksi-rental&kembali=<?= $rent['id_transaksi']; ?>&d=<?= $denda; ?>" type="button" class="btn btn-primary">Kembalikan</a>
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
    </div>
</div>

<?php
if (isset($_GET['sewa'])) {
    $id = $_GET['sewa'];
    $update = sewakan($id);
    if ($update) {
        echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Mobil berhasil disewakan!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=transaksi-rental';
                });
            </script>
        ";
    } else {
        echo "
            <script>
                Swal.fire({
                    icon: 'danger',
                    title: 'Mobil gagal disewakan!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=transaksi-rental';
                });
            </script>
        ";
    }
}
if (isset($_GET['kembali']) && isset($_GET['d'])) {
    $id = $_GET['kembali'];
    $denda = $_GET['d'];
    $update = kembalikan($id, $denda);
    if ($update) {
        echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Mobil berhasil dikembalikan!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=transaksi-rental';
                });
            </script>
        ";
    } else {
        echo "
            <script>
                Swal.fire({
                    icon: 'danger',
                    title: 'Mobil gagal dikembalikan!',
                    showConfirmButton: false,
                    timer: 1500,
                })
                .then(function() {
                    window.location = '?page=transaksi-rental';
                });
            </script>
        ";
    }
}


?>