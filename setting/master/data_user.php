<?php
include "../../koneksi_db/Koneksi.php";

$parameter_keywoard = isset($_POST['parameter_keywoard']) ? $_POST['parameter_keywoard']:"";
$parameter_area_kerja = isset($_POST['parameter_area_kerja']) ? $_POST['parameter_area_kerja']:"";

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$jmlRows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
$offset = ( $page-1 )* $jmlRows;
$limit = "LIMIT $jmlRows OFFSET $offset";

$error=array();
$query=array();
$result=array('total' =>0 ,'rows' => array());

if($parameter_area_kerja==""){
    $parameter_area_kerja="";
}else{
    $parameter_area_kerja="AND a.kd_cabang='$parameter_area_kerja'";
}

$query[]="SELECT COUNT(*) AS total FROM ".DB_DPM_ONLINE.".".TABLE_USER." AS a 
        INNER JOIN ".DB_DPM_ONLINE.".".TABLE_APP_KODE_KANTOR." AS b
        ON a.kd_cabang=b.kode_kantor
        WHERE flg_block='N' and (a.nik like '%$parameter_keywoard%' or a.nama like '%$parameter_keywoard%'
        or a.user like '%$parameter_keywoard%' or a.jabatan like '%$parameter_keywoard%') $parameter_area_kerja";
$query[]="SELECT a.user_id,a.user,nik,nama,kd_cabang,divisi_id,jabatan,CONCAT(kd_cabang,' - ',nama_kantor) AS nama_kantor
        FROM ".DB_DPM_ONLINE.".".TABLE_USER." AS a 
        INNER JOIN ".DB_DPM_ONLINE.".".TABLE_APP_KODE_KANTOR." AS b
        ON a.kd_cabang=b.kode_kantor
        WHERE flg_block='N' and (a.nik like '%$parameter_keywoard%' or a.nama like '%$parameter_keywoard%'
        or a.user like '%$parameter_keywoard%' or a.jabatan like '%$parameter_keywoard%') $parameter_area_kerja
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
