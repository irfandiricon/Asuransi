<?php
include_once('../../koneksi_db/Koneksi.php');
include_once("../../__setting.php");
$table_menu  = TABLE_MENU;

$id_menu= isset($_POST['id_menu']) ? $_POST['id_menu']:"";

$query="DELETE FROM $DB.$table_menu where id_menu='$id_menu'";
$ex_query= mysqli_query($KONEKSI, $query);

if (!$ex_query){
    echo json_encode(mysqli_error($ex_query));
}


