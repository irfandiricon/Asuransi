<?php
include_once('../../koneksi_db/Koneksi.php');
include_once("../../__setting.php");
$table_group_menu  = TABLE_GROUP_MENU;

$status_aktif= isset($_POST['status_aktif']) ? $_POST['status_aktif']:0;
$font_icon= isset($_POST['font_icon']) ? $_POST['font_icon']:"";
$nama_group_menu= isset($_POST['nama_group_menu']) ? $_POST['nama_group_menu']:"";
$id_group_menu= isset($_POST['id_group_menu']) ? $_POST['id_group_menu']:"";
$USER_ID=isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID']:"";

if($status_aktif=="Aktif"){
    $status='1';
}else{
    $status='0';
}

$query="UPDATE $DB.$table_group_menu SET font_icon='$font_icon',nama_group_menu='$nama_group_menu',"
        . "status_aktif='$status' where id_group_menu='$id_group_menu'";
$ex_query= mysqli_query($KONEKSI, $query);

if ($ex_query){
    echo json_encode('Berhasil Tersimpan');
}else{
    echo json_encode(mysqli_error($ex_query));
}


