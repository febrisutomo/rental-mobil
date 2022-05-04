<?php

$query = "CALL logRental()";
$rents = select($query);

// $rents = select("SELECT * FROM tb_peminjaman ORDER BY tgl_pinjam DESC");

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM tb_peminjaman WHERE id_peminjaman = $id");
    return mysqli_affected_rows($conn);
}

function kembali($id)
{
    global $conn;
    $query = "UPDATE tb_peminjaman SET 
                status = 'Kembali', 
                tgl_kembali = CURDATE()
                WHERE id_peminjaman = $id
            ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
?>

<div class="card">
    <div class="card-body">
        <table id="tblog" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Tgl Sewa</th>
                    <th>Peminjam</th>
                    <th>Mobil</th>
                    <th>Durasi</th>
                    <th>Total Harga</th>
                    <th>Tgl Kembali</th>
                    <th>Denda</th>
                    <!-- <th>Aksi</th> -->
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rents as $rent) : ?>
                    <tr>
                        <td><?= $no; ?></td>
                        <td>TRX<?= $rent['id_transaksi']; ?></td>
                        <td><?= date('d/m/Y', strtotime($rent['tgl_sewa'])); ?></td>
                        <td><?= $rent['nama']; ?></td>
                        <td><?= $rent['nama_mobil']; ?></td>
                        <!-- <td><?= date('d/m/Y H:i:s', strtotime($rent['tgl_sewa'])); ?></td> -->
                        <td><?= $rent['durasi']; ?> Hari</td>
                        <td><?= rupiah($rent['total_harga']); ?></td>
                        <td>
                            <?= $rent['status'] == 'dibatalkan' ? 'dibatalkan' : ''; ?>
                            <?= isset($rent['tgl_kembali']) ? date('d/m/Y', strtotime($rent['tgl_kembali'])) : ''; ?>
                        </td>
                        <td><?= rupiah($rent['denda']); ?>,-</td>
                    </tr>
                    <?php $no++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
