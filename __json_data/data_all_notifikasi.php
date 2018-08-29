<?php
session_start();
include_once("../koneksi_db/Koneksi.php");

$user_id=isset($_POST['user_id']) ? $_POST['user_id']:"3";

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$jmlRows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ( $page-1 )* $jmlRows;
$limit = "LIMIT $jmlRows OFFSET $offset";

$error=array();
$query=array();
$result=array('total' =>0 ,'rows' => array());

$query[]="SELECT COUNT(*) as total FROM $DB.ace_notifikasi where status='0' and user_id_receive='$user_id'";

$query[]="SELECT a.id,a.subject,CONCAT(a.created_date,' ',a.created_time) as waktu,a.status,b.nik,b.nama FROM $DB.ace_notifikasi AS a INNER JOIN
        dpm_online.user AS b ON a.user_id_request=b.user_id WHERE a.status='0' and user_id_receive='$user_id' 
        order by status, id $limit";

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

mysqli_close($KONEKSI);
echo json_encode($result);