<?php
$print_id = $_GET['id'];
$active = select("CALL userActiveRent($print_id)")[0];
?>
<div class="m-auto pt-3">
    <div class="card">
        <div class="card-header font-weight-bold text-center">
        <h3 class="text-primary">FS-Rental</h3>
        Bukti Booking
        </div>
        <div class="card-body">
            <table class="table table-borderless table-striped text-left">
                <tbody>
                    <tr>
                        <td>ID Transaksi</td>
                        <td>: TRX<?= $active['id_transaksi']; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Penyewa</td>
                        <td>: <?= $active['nama']; ?></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>: TRX<?= $active['nik']; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: <?= $active['alamat']; ?></td>
                    </tr>
                    <tr>
                        <td>No HP</td>
                        <td>: <?= $active['no_hp']; ?></td>
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
                        <td>Tarif</td>
                        <td>: Rp<?= $active['harga']; ?>.000/hari</td>
                    </tr>
                    <tr>
                        <td>Durasi</td>
                        <td>: <?= $active['durasi']; ?> hari</td>
                    </tr>
                    <td>Total Bayar</td>
                    <td>: Rp<?= $active['total_harga']; ?>.000,-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", window.print());
    $("nav").hide();
</script>