<?php
include "../../koneksi_db/Koneksi.php";

$table_jenis_pertanggungan_inventaris = TABLE_JENIS_PERTANGGUNGAN_INVENTARIS;
$addSemua=isset($_POST['addSemua']) ? true : false;

$json = array();
$query = "SELECT id_pertanggungan, nama_pertanggungan FROM $DB.$table_jenis_pertanggungan_inventaris where id_pertanggungan IN ('1','5') ";
$query .= $addSemua ? " UNION SELECT '' AS id_pertanggungan, '~~ PILIH DATA ~~' AS nama_pertanggungan " : '';

$execQuery 	= mysqli_query($KONEKSI, $query);
while ($row = mysqli_fetch_assoc($execQuery)) $json[] = $row;

echo json_encode($json);
mysqli_free_result($execQuery);
mysqli_close($KONEKSI);
