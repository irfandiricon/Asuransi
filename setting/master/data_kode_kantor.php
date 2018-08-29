<?php
include_once("../../koneksi_db/Koneksi.php");

$addSemua = isset($_POST['addSemua']) ? true : false;

$query = "SELECT kode_kantor, CONCAT(kode_kantor,' - ',nama_kantor) as nama_kantor "
        . "FROM ".DB_DPM_ONLINE.".".VIEW_SPEDA_COMBO_KANTOR. " WHERE kode_kantor NOT IN ('31','32')";
$query .= $addSemua ? " UNION SELECT '' AS kode_kantor, 'Konsolidasi' AS  nama_kantor" : '';

$execQuery = mysqli_query($KONEKSI, $query);
while ($row = mysqli_fetch_assoc($execQuery))
$json[] = $row;

echo json_encode($json);
mysqli_free_result($execQuery);
mysqli_close($KONEKSI);
