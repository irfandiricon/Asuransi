<?php
$id = array("","MOTOR","MOBIL");
$tipe = array("~~ PILIH DATA ~~","MOTOR","MOBIL");

$jumlah = count($tipe);
for($i=0;$i<$jumlah;$i++){
    $data_id = $id[$i];
    $data_tipe = $tipe[$i];

    $hasil[] = array("id" => $data_id,"tipe" => $data_tipe);
}

echo json_encode($hasil);
