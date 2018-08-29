<?php
include "../../koneksi_db/Koneksi.php";
$dpm_online = DB_DPM_ONLINE;
$kode_asuransi_jaminan = KODE_ASURANSI_JAMINAN;
$table_kre_kode_asuransi = TABLE_KRE_KODE_ASURANSI;

$addSemua=isset($_POST['addSemua']) ? true : false;

$json = array();
$query = "SELECT kode_asuransi, UPPER(deskripsi_asuransi) as deskripsi_asuransi
    FROM $dpm_online.$table_kre_kode_asuransi
    WHERE kode_asuransi IN ($kode_asuransi_jaminan) ";
$query .= $addSemua ? " UNION SELECT '' AS kode_asuransi, '~~ PILIH DATA ~~' AS deskripsi_asuransi " : '';

$execQuery 	= mysqli_query($KONEKSI, $query);
while ($row = mysqli_fetch_assoc($execQuery)) {
    $json[] = $row;
}
echo json_encode($json);
mysqli_free_result($execQuery);
mysqli_close($KONEKSI);
?>
