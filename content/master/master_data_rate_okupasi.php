<?php
include "../../koneksi_db/Koneksi.php";

$table_okupasi = TABLE_OKUPASI;
$addSemua=isset($_POST['addSemua']) ? true : false;
$id = isset($_POST['id']) ? $_POST['id']:"";

$json = array();
$query = "SELECT tarif_premi as rate FROM $DB.$table_okupasi where id='$id' ";
$execQuery 	= mysqli_query($KONEKSI, $query);
$row = mysqli_fetch_assoc($execQuery);
$rate = $row['rate'];
$json = array("rate" => $rate,"query" => $query); 
echo json_encode($json);
mysqli_free_result($execQuery);
mysqli_close($KONEKSI);
