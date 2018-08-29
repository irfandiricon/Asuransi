<?php
if(!isset($_SESSION)){session_start();}
//require_once "__setting.php";
$rootPath=$_SERVER['DOCUMENT_ROOT'];
$application_name = "asuransi_new";
require_once ($rootPath."/$application_name/".'__setting.php');

$SESSION_KONEKSI=isset($_SESSION['KONEKSI']) ? $_SESSION['KONEKSI']:"";

if ($SESSION_KONEKSI=="local"){
    $HOST=HOST_KMI_LOCAL;
    $USER=USERNAME_KMI_LOCAL;
    $PASSWORD=PASSWORD_KMI_LOCAL;
    $DB=DATABASE_ACE_LOCAL;
}elseif($SESSION_KONEKSI=="kmi"){
    $HOST=HOST_KMI;
    $USER=USERNAME_KMI;
    $PASSWORD=PASSWORD_KMI;
    $DB=DATABASE_ACE_KMI;
}else{
    $HOST=HOST_KMJ;
    $USER=USERNAME_KMJ;
    $PASSWORD=PASSWORD_KMJ;
    $DB=DATABASE_ACE_KMJ;
}

$KONEKSI = mysqli_connect($HOST, $USER, $PASSWORD);
$DATABASE= mysqli_select_db($KONEKSI, $DB);

if(!$DATABASE){
    die("Koneksi Gagal : ". mysqli_connect_error());
}
