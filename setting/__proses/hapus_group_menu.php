<?php
include_once('../../koneksi_db/Koneksi.php');
include_once("../../__setting.php");
$table_group_menu  = TABLE_GROUP_MENU;

$id_group_menu= isset($_POST['id_group_menu']) ? $_POST['id_group_menu']:"";

$query="DELETE FROM $DB.$table_group_menu where id_group_menu='$id_group_menu'";
$ex_query= mysqli_query($KONEKSI, $query);

if (!$ex_query){
    echo json_encode(mysqli_error($ex_query));
}


