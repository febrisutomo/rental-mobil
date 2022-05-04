<?php
$conn = mysqli_connect('localhost', 'root', '', 'rental_mobil');
date_default_timezone_set("Asia/Bangkok");

function select($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function upload($gambar){
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $tipe_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION)); 
    $limit = 1 * 1024 * 1024;
    $ekstensi = ['png', 'jpg', 'jpeg', 'gif'];

    if(!in_array($tipe_file, $ekstensi)){
        return "tipe";
    }
    elseif($ukuran_file > $limit){
        return "ukuran";
    }
    else{
        $nama_baru = uniqid();
        $nama_baru .= '.';
        $nama_baru .= $tipe_file;

        move_uploaded_file($tmp_file, '../src/img/'.$gambar.'/'.$nama_baru);
        return $nama_baru;
    }
}

function upload2($gambar){
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $tipe_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION)); 
    $limit = 1 * 1024 * 1024;
    $ekstensi = ['png', 'jpg', 'jpeg', 'gif'];

    if(!in_array($tipe_file, $ekstensi)){
        return "tipe";
    }
    elseif($ukuran_file > $limit){
        return "ukuran";
    }
    else{
        $nama_baru = uniqid();
        $nama_baru .= '.';
        $nama_baru .= $tipe_file;

        move_uploaded_file($tmp_file, 'src/img/'.$gambar.'/'.$nama_baru);
        return $nama_baru;
    }
}

function rupiah($angka){
	$angka = $angka * 1000;
	$hasil_rupiah = "Rp" . number_format($angka,2,',','.');
	return $hasil_rupiah;
}

function tgl_indo($tgl){
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                'Juli', 'Agustus', 'September',  'Oktober', 'November', 'Desember'];
    $string = explode('-', $tgl);
    return $string[2].' '.$bulan[(int)$string[1]].' '.$string[0];
}

$curPage = substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],"/")+1);

?>