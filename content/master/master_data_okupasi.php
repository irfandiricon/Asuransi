<?php
include "../../koneksi_db/Koneksi.php";

$table_okupasi = TABLE_OKUPASI;
$addSemua=isset($_POST['addSemua']) ? true : false;
$kode_asuransi = isset($_POST['kode_asuransi']) ? $_POST['kode_asuransi']:"004";

$json = array();
$query = "SELECT id, deskripsi_okupasi FROM $DB.$table_okupasi where kode_asuransi = '$kode_asuransi' ";
$query .= $addSemua ? " UNION SELECT '' AS id, '~~ PILIH DATA ~~' AS deskripsi_okupasi " : '';

$execQuery 	= mysqli_query($KONEKSI, $query);
while ($row = mysqli_fetch_assoc($execQuery)) {
    $json[] = $row;
}
echo json_encode($json);
mysqli_free_result($execQuery);
mysqli_close($KONEKSI);
