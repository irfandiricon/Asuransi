<?php
$id = array("","BPKB","SERTIFIKAT");
$jenis = array("~~ PILIH DATA ~~","BPKB","SERTIFIKAT");

$jumlah = count($jenis);
for($i=0;$i<$jumlah;$i++){
    $data_id = $id[$i];
    $data_jenis = $jenis[$i];

    $hasil[] = array("id" => $data_id,"jenis" => $data_jenis);
}

echo json_encode($hasil);
