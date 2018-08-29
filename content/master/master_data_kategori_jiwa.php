<?php
$id = array("","1","2");
$tipe = array("~~ PILIH DATA ~~","UP. MENURUN","UP. TETAP");

$jumlah = count($tipe);
for($i=0;$i<$jumlah;$i++){
    $data_id = $id[$i];
    $data_tipe = $tipe[$i];

    $hasil[] = array("id" => $data_id,"tipe" => $data_tipe);
}

echo json_encode($hasil);
