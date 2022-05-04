<?php

function tambah($data)
{
    global $conn;

    $id_anggota = htmlspecialchars($data['id_anggota']);
    $id_buku = htmlspecialchars($data['id_buku']);
    $tgl_pinjam = date('Y-m-d', strtotime($data['tgl_pinjam']));
    $jatuh_tempo = date('Y-m-d', strtotime('+7 day'));
    $status= status($id_buku);
    
    if($status=='Dipinjam'){
        return $status;
    }
    else{
        $query = "INSERT INTO tb_peminjaman VALUES ('', $id_anggota, $id_buku, '$tgl_pinjam', '$jatuh_tempo', 0, 'Dipinjam', NULL, NULL)";
        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }
}

$books = select("SELECT * FROM tb_buku");
$members = select("SELECT * FROM tb_anggota");

?>


<form id="anggota" action="" method="POST" enctype="multipart/form-data">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Masukkan Data Peminjaman</h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="id_anggota">Peminjam</label>
                <select class="form-control select2bs4" name="id_anggota" id="id_anggota" data-placeholder="Pilih anggota" required>
                    <option hidden="" value=""></option>
                    <?php foreach($members as $member): ?>
                    <option value="<?= $member['id_anggota']; ?>"><?= 'AG'.$member['id_anggota'].' - '.$member['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_buku">Buku</label>
                <select class="form-control select2bs4" name="id_buku" id="id_buku" data-placeholder="Pilih buku" required>
                    <option hidden="" value=""></option>
                    <?php foreach($books as $book): ?>
                    <option value="<?= $book['id_buku']; ?>"><?= 'BK'.$book['id_buku'].' - '.$book['judul']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tgl_pinjam">Tanggal Pinjam</label>
                <input type="text" class="form-control" name="tgl_pinjam" id="tgl_pinjam" value="<?= date('d-m-Y'); ?>" readonly>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Apakah data yang anda masukkan sudah benar?')">Pinjamkan</button>
            <a href="?page=transaksi-buku" class="btn btn-secondary">Kembali</a>
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
                title: 'Data peminjaman berhasil ditambahkan!',
                showConfirmButton: false,
                timer: 1500,
            })
            .then(function() {
                window.location = '?page=transaksi-buku';
            });
        </script>
    ";
    }
    elseif($tambah == "Dipinjam"){
        echo "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Buku yang anda masukkan sedang dipinjam!',
                })
            </script>
        ";
    }
    else {
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Data peminjaman gagal ditambahkan!',
                })
            </script>
        ";
    }
}

?>