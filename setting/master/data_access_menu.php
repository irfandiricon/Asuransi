<?php
include "../../koneksi_db/Koneksi.php";
require_once "../../__setting.php";

$table_access_menu = TABLE_ACCESS_MENU;
$table_menu = TABLE_MENU;
$table_group_menu = TABLE_GROUP_MENU;
$user_id= isset($_POST['user_id']) ? $_POST['user_id']:"";

$error=array();
$query=array();
$result=array('rows' => array());

$query_access="SELECT id_menu from $DB.$table_access_menu WHERE user_id='$user_id'";
$ex_query_access= mysqli_query($KONEKSI, $query_access);
$res_query_access = mysqli_fetch_assoc($ex_query_access);
$id_menu=$res_query_access['id_menu'];

if($id_menu==""){
    $data_menu="''";
}else{
    $data_menu=$id_menu;
}

$query[]="SELECT a.id_menu,a.id_group_menu,b.nama_group_menu,a.nama_menu,
        IF(a.id_menu IN ($data_menu),'1','0') AS status_menu
        FROM $DB.$table_menu AS a
        LEFT JOIN $DB.$table_group_menu AS b ON a.id_group_menu=b.id_group_menu ORDER BY a.id_group_menu, a.id_menu";

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
            $result=array("rows" => array(),"pesan" => join("",$error));
    }
}

echo json_encode($result);
mysqli_close($KONEKSI);
