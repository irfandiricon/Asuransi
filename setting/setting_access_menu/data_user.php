<?php
include "../../koneksi_db/Koneksi.php";

$dpm_online = DB_DPM_ONLINE;
$table_access_menu = TABLE_ACCESS_MENU;
$table_user = TABLE_USER;

$json = array();
$addSemua = isset($_POST['addSemua']) ? true : false;

$query="SELECT a.user_id,nama
        FROM $DB.$table_access_menu as a
        INNER JOIN $dpm_online.$table_user AS b ON a.user_id=b.user_id
        WHERE b.flg_block='N'";

$query   .= $addSemua ? " UNION SELECT '' AS user_id, 'PILIH USER' AS user_id " : '';

$execQuery 	= mysqli_query($KONEKSI, $query);
while ($row = mysqli_fetch_assoc($execQuery)) $json[] = $row;

echo json_encode($json);
mysqli_close($KONEKSI);
