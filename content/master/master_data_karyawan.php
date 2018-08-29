<?php
include "../../koneksi_db/Koneksi.php";

$dpm_online = DB_DPM_ONLINE;
$table_app_kode_kantor = TABLE_APP_KODE_KANTOR;
$table_user = TABLE_USER;
$view_speda_combo_kantor = VIEW_SPEDA_COMBO_KANTOR;

$parameter_keywoard = isset($_POST['parameter_keyword']) ? $_POST['parameter_keyword']:"";
$parameter_kode_kantor = isset($_POST['parameter_kode_kantor']) ? $_POST['parameter_kode_kantor']:"";

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$jmlRows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ( $page-1 )* $jmlRows;
$limit = "LIMIT $jmlRows OFFSET $offset";

$error=array();
$query=array();
$result=array('total' =>0 ,'rows' => array());

$KODE_AREA = isset($_POST['kode_area']) ? $_POST['kode_area']:"";
$USERNAME = isset($_POST['username']) ? $_POST['username']:"";
$JABATAN = isset($_POST['jabatan']) ? $_POST['jabatan']:"";
$DIVISI_ID = isset($_POST['divisi_id']) ? $_POST['divisi_id']:"";
$GROUP_MENU = isset($_POST['group_menu']) ? $_POST['group_menu']:"";
$KODE_KANTOR = isset($_POST['kode_kantor']) ? $_POST['kode_kantor']:"";


if (in_array($USERNAME, array('erik','triaji','lutfi','jemmy',"icmar_yudha")) || in_array($GROUP_MENU,array("IT","PUSAT")) || 
    $JABATAN=="DEPARTMENT HEAD"){
    if($parameter_kode_kantor==""){
        $parameter_kantor="";
    }else{
        $parameter_kantor=" AND a.kd_cabang='$parameter_kode_kantor'";
    }
}else if ($JABATAN=="AREA MANAGER" || in_array($USERNAME, array('rahmat'))){
    if($parameter_kode_kantor==""){
        $query="SELECT kode_kantor FROM $dpm_online.$view_speda_combo_kantor WHERE kode_area='$KODE_AREA'";
        $execQuery = mysqli_query($KONEKSI, $query);
        while($result=mysqli_fetch_assoc($execQuery)){
            $kode_kantor[]=$result['kode_kantor'];
        }
        $data_kantor = "'".implode("','",$kode_kantor)."'";
        $data_kantor=substr($data_kantor, 0);
        $parameter_kantor="AND a.kd_cabang IN ($data_kantor)";
    }else{
        $parameter_kantor=" AND a.kd_cabang='$parameter_kode_kantor'";
    }
}else{
    if($parameter_kode_kantor==""){
        $parameter_kantor=" AND a.kd_cabang='$KODE_KANTOR'";
    }else{
        $parameter_kantor=" AND a.kd_cabang='$parameter_kode_kantor'";
    }
}


$query[]="SELECT COUNT(*) AS total FROM $dpm_online.$table_user as a
    INNER JOIN $dpm_online.$table_app_kode_kantor AS b
    ON a.kd_cabang=b.kode_kantor
    WHERE flg_block='N' and (a.nik like '%$parameter_keywoard%' or a.nama like '%$parameter_keywoard%'
    or a.user like '%$parameter_keywoard%' or a.jabatan like '%$parameter_keywoard%') $parameter_kantor";
$query[]="SELECT a.user_id,a.user,nik,nama,kd_cabang,divisi_id,jabatan,CONCAT(kd_cabang,' - ',nama_kantor) AS nama_kantor
    FROM $dpm_online.$table_user AS a
    INNER JOIN $dpm_online.$table_app_kode_kantor AS b
    ON a.kd_cabang=b.kode_kantor
    WHERE flg_block='N' and (a.nik like '%$parameter_keywoard%' or a.nama like '%$parameter_keywoard%'
    or a.user like '%$parameter_keywoard%' or a.jabatan like '%$parameter_keywoard%') $parameter_kantor
    order by nama $limit";

if (count($query) > 0){
    if (mysqli_multi_query($KONEKSI, join(";",$query))){
        do{
             if ($rs = mysqli_store_result($KONEKSI)){
                while ($row = mysqli_fetch_assoc($rs)) {
                   if(isset($row['total'])) {
                        $result['total']=$row['total'];
                   }else{
                        $result['rows'][]=$row;
                   }
                }
             }
        } while(next($query) && mysqli_more_results($KONEKSI) && mysqli_next_result($KONEKSI));
    }
    if(mysqli_error($KONEKSI)) $error[] = mysqli_error($KONEKSI);
    if (count($error) > 1){
            $result=array("total" => 0,"rows" => array(),"pesan" => join("",$error));
    }
}

echo json_encode($result);
mysqli_close($KONEKSI);
