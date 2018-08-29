<?php 
date_default_timezone_set('Asia/Jakarta');
ini_set('memory_limit', '-1');

include_once("../koneksi_db/Koneksi.php");

$DB_DPM=DB_DPM_ONLINE;

$USERNAME=isset($_POST['username']) ? $_POST['username']:"";
$KODE_KANTOR=isset($_POST['kode_kantor']) ? $_POST['kode_kantor']:"";
$NIK=isset($_POST['nik']) ? $_POST['nik']:"";
$KODE_AREA=isset($_POST['kode_area']) ? $_POST['kode_area']:"";
$USER_ID=isset($_POST['user_id']) ? $_POST['user_id']:"";

$result=array('total' =>0 ,'rows' => array());
$query=array();
$error=array();
$limit=2;

$query[]="SELECT COUNT(*) AS total FROM $DB.ace_notifikasi WHERE status='0' AND user_id_receive='$USER_ID'";
$query[]="SELECT a.*,b.nik,b.nama FROM $DB.ace_notifikasi AS a INNER JOIN dpm_online.user AS b
            ON a.user_id_request=b.user_id WHERE a.status='0' AND a.user_id_receive='$USER_ID' LIMIT $limit";

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
            $result=array("total" => 0,"rows" => array());
    }
}
echo json_encode($result);
mysqli_close($KONEKSI);
?>