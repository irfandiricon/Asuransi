<?php
include "../../koneksi_db/Koneksi.php";

$table_menu = TABLE_MENU;

$id_group_menu= isset($_POST['id_group_menu']) ? $_POST['id_group_menu']:"";
$error=array();
$query=array();
$result=array('total' =>0 ,'rows' => array());

$query[]="SELECT id_menu,id_group_menu,path,nama_menu,nama_file,
          IF(status_aktif = '1','Aktif','Non Aktif') AS status_aktif
          FROM $DB.$table_menu where id_group_menu='$id_group_menu'";

if (count($query) > 0){
    if (mysqli_multi_query($KONEKSI, join(";",$query))){
        do{
             if ($rs = mysqli_store_result($KONEKSI)){
                while ($row = mysqli_fetch_assoc($rs)) {
                    $result['rows'][]=$row;
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
