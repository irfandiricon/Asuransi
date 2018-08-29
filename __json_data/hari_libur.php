<?php
include_once("../koneksi_db/Koneksi.php");
$firstDate = isset($_POST['firstDate']) ? $_POST['firstDate']:"";

$json = array();
$query = "SELECT COUNT(*) as total FROM ".DB_DPM_ONLINE.".".TABLE_HARI_LIBUR.
    " WHERE tgl BETWEEN '$firstDate' AND CURRENT_DATE()";

$execQuery = mysqli_query($KONEKSI, $query);
while ($row = mysqli_fetch_assoc($execQuery)) $json[] = $row;

echo json_encode($json);
mysqli_free_result($execQuery);
mysqli_close($KONEKSI);
?>
