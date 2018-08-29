<?php
include_once("../../koneksi_db/Koneksi.php");
$dpm_online = DB_DPM_ONLINE;
$view_speda_combo_kantor = VIEW_SPEDA_COMBO_KANTOR;

$addSemua = isset($_POST['addSemua']) ? true : false;
$KODE_AREA = isset($_POST['kode_area']) ? $_POST['kode_area']:"";
$USERNAME = isset($_POST['username']) ? $_POST['username']:"";
$JABATAN = isset($_POST['jabatan']) ? $_POST['jabatan']:"";
$DIVISI_ID = isset($_POST['divisi_id']) ? $_POST['divisi_id']:"";
$GROUP_MENU = isset($_POST['group_menu']) ? $_POST['group_menu']:"";
$KODE_KANTOR = isset($_POST['kode_kantor']) ? $_POST['kode_kantor']:"";

if (in_array($USERNAME, array('erik','triaji','lutfi','jemmy',"icmar_yudha")) || $GROUP_MENU=="IT" || $JABATAN=="DEPARTMENT HEAD"){
    $parameter_kantor="";
}else if ($JABATAN=="AREA MANAGER" || in_array($USERNAME, array('rahmat'))){
    $query="SELECT kode_kantor FROM $dpm_online.$view_speda_combo_kantor WHERE kode_area='$KODE_AREA'";
    $execQuery = mysqli_query($KONEKSI, $query);
    while($result=mysqli_fetch_assoc($execQuery)){
        $kode_kantor[]=$result['kode_kantor'];
    }
    $data_kantor = "'".implode("','",$kode_kantor)."'";
    $data_kantor=substr($data_kantor, 0);
    $parameter_kantor="AND kode_kantor IN ($data_kantor)";
}else{
    $parameter_kantor=" AND kode_kantor='$KODE_KANTOR'";
}

$query = "SELECT kode_kantor, CONCAT(kode_kantor,' - ',nama_kantor) as nama_kantor
        FROM $dpm_online.$view_speda_combo_kantor WHERE kode_kantor NOT IN ('31','32') $parameter_kantor";
$query .= $addSemua ? " UNION SELECT '' AS kode_kantor, 'Konsolidasi' AS  nama_kantor" : '';

$execQuery = mysqli_query($KONEKSI, $query);
while ($row = mysqli_fetch_assoc($execQuery))
$json[] = $row;

echo json_encode($json);
mysqli_free_result($execQuery);
mysqli_close($KONEKSI);
