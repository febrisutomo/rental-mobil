<?php
require '../../utility/function.php';
$id = $_POST['id'];

$koneksi = mysqli_connect('localhost', 'root', '', 'rental_mobil');
if(isset($_GET['action'])){
    $action = $_GET['action'];
    if($action == 'disewakan' OR $action == 'dibatalkan'){
        $sql = "UPDATE tb_transaksi SET 
                    status = '$action'
                    WHERE id_transaksi = $id
                ";
    }
    elseif($action == 'dikembalikan'){
        $rent = select("SELECT * FROM tb_transaksi WHERE id_transaksi=$id")[0];
        $harga = $rent['harga'];
        $sql = "UPDATE tb_transaksi SET 
                    status = '$action',
                    tgl_kembali = CURRENT_TIMESTAMP(),
                    denda = $harga
                    WHERE id_transaksi = $id
                ";
    }
    $result = mysqli_query($conn, $sql);
        if($result){
            $output['status'] = 'success';
            $output['message'] = 'Mobil berhasil '.$action;
        }
        else{
            $output['status'] = 'error';
            $output['message'] = 'Something went wrong';
        }
        echo json_encode($output);
}
