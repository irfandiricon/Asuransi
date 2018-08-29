<?php
include "../../koneksi_db/Koneksi.php";
$table_polis = TABLE_POLIS;
$id = isset($_POST['id']) ? $_POST['id']:"";
$id_polis = isset($_POST['id_polis']) ? $_POST['id_polis']:"0";
$no_rekening = isset($_POST['no_rekening']) ? $_POST['no_rekening']:"";
$agunan_id = isset($_POST['agunan_id']) ? $_POST['agunan_id']:"";
$jenis_asuransi = isset($_POST['jenis_asuransi']) ? $_POST['jenis_asuransi']:"";
$tanggal_awal_polis = isset($_POST['tanggal_awal_polis']) ? $_POST['tanggal_awal_polis']:"";
$tanggal_akhir_polis = isset($_POST['tanggal_akhir_polis']) ? $_POST['tanggal_akhir_polis']:"";
$status_endorsement = isset($_POST['status_endorsement']) ? $_POST['status_endorsement']:"";
$created_by = isset($_POST['created_by']) ? $_POST['created_by']:"";

if($id=="null" || $id=="" || empty($id)){
    $query = "INSERT INTO $DB.$table_polis (no_rekening, agunan_id, id_polis, jenis_asuransi, tanggal_awal_polis, tanggal_akhir_polis,
        status_endorsement, created_date, created_time, created_by) values ('$no_rekening', '$agunan_id', '$id_polis', '$jenis_asuransi',
        '$tanggal_awal_polis', '$tanggal_akhir_polis', '$status_endorsement', now(), now(), '$created_by')";
}else{
    $query = "UPDATE $DB.$table_polis SET id_polis='$id_polis', status_endorsement='$status_endorsement', updated_date=now(), updated_time=now(),
        updated_by='$created_by' WHERE id='$id'";
}

$ex_query = mysqli_query($KONEKSI, $query);
if($ex_query){
    $pesan = "Data Berhasil Tersimpan !!!";
}else{
    $pesan = "Data Gagal Tersimpan, Error : ".mysqli_error($KONEKSI);
}
echo json_encode($pesan);
mysqli_close($KONEKSI);
?>
