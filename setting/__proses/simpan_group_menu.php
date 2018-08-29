<?php
include_once('../../koneksi_db/Koneksi.php');
include_once("../../__setting.php");
$table_group_menu  = TABLE_GROUP_MENU;

$font_icon= isset($_POST['font_icon']) ? $_POST['font_icon']:"";
$nama_group_menu= isset($_POST['nama_group_menu']) ? $_POST['nama_group_menu']:"";
$USER_ID=isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID']:"";

$query="INSERT INTO $DB.$table_group_menu(font_icon,nama_group_menu,created_date,created_by)"
        . " values ('$font_icon','$nama_group_menu',now(),'$USER_ID')";
$ex_query= mysqli_query($KONEKSI, $query);

if ($ex_query){
    echo json_encode('Berhasil Tersimpan');
}else{
    echo json_encode(mysqli_error($ex_query));
}


