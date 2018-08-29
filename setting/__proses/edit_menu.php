<?php
include_once('../../koneksi_db/Koneksi.php');
include_once("../../__setting.php");
$table_menu  = TABLE_MENU;

$id_menu= isset($_POST['id_menu']) ? $_POST['id_menu']:"";
$nama_menu= isset($_POST['nama_menu']) ? $_POST['nama_menu']:"";
$path= isset($_POST['path']) ? $_POST['path']:"";
$nama_file= isset($_POST['nama_file']) ? $_POST['nama_file']:"";
$status_aktif= isset($_POST['status_aktif']) ? $_POST['status_aktif']:0;
$USER_ID=isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID']:"";

if($status_aktif=="Aktif"){
    $status='1';
}else{
    $status='0';
}

$query="UPDATE $DB.$table_menu SET nama_menu='$nama_menu',path='$path',nama_file='$nama_file',"
        . "status_aktif='$status' where id_menu='$id_menu'";
$ex_query= mysqli_query($KONEKSI, $query);

if ($ex_query){
    echo json_encode('Berhasil Tersimpan');
}else{
    echo json_encode(mysqli_error($ex_query));
}


