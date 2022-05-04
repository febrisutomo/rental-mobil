<?php
require 'utility\function.php';
$tgl_rental = '22-05-2021 10:20:01';
$durasi = 3;
$tgl_ambil= date('d-m-Y H:i:s', strtotime('+'.$durasi.' days', strtotime($tgl_rental)));
$tgl_ambil = date_create($tgl_ambil);
$batas= date_add($tgl_ambil, date_interval_create_from_date_string('2 hours'));
$batas= date_format($batas, 'd-m-Y H:i');

echo $batas;
if(date('d-m-Y H:i') > date('d-m-Y H:i', strtotime($batas))){
  echo 'melebihi batas!'; 
}   
