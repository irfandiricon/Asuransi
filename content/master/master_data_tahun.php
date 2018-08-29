<?php
$tahun_buat=2017;
$tahun_sekarang=date('Y');
for ($i=$tahun_buat;$i<=$tahun_sekarang;$i++){
    $hasil[]=array("id" => $i);
}

echo json_encode($hasil);
