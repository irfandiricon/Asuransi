<?php
require_once '__setting.php';
$koneksi=isset($_POST['koneksi']) ? $_POST['koneksi']:"";
$DB_DPM_ONLINE=DB_DPM_ONLINE;

if ($koneksi=="local"){
    $HOST=HOST_KMI_LOCAL;
    $USER=USERNAME_KMI_LOCAL;
    $PASSWORD=PASSWORD_KMI_LOCAL;
    $DB=DATABASE_ACE_LOCAL;
}elseif($koneksi=="kmi"){
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

$KONEKSI= mysqli_connect($HOST, $USER, $PASSWORD);
$CONNECTION= mysqli_select_db($KONEKSI, $DB);

$username=$_POST['username'];
$password=$_POST['password'];

$myusername=mysqli_real_escape_string($KONEKSI, $username);
$mypassword= md5(mysqli_real_escape_string($KONEKSI, $password));

$query="SELECT a.user,a.password,a.nik,a.kd_cabang,a.nama,a.divisi_id,a.jabatan,a.user_id,a.user_id_induk,a.group_menu,
    IF(a.kode_area='',b.kode_area,a.kode_area) AS kode_area, a.email
    FROM $DB_DPM_ONLINE.".TABLE_USER." as a LEFT JOIN $DB_DPM_ONLINE.app_kode_kantor AS b
    ON a.kd_cabang=b.kode_kantor where a.user='$myusername' and a.password='$mypassword' and a.flg_block='N'";

$ex_query= mysqli_query($KONEKSI, $query);
$rows= mysqli_num_rows($ex_query);

if ($rows == 0){
    $pesan = "Login Gagal. Pastikan Username dan Password Anda Benar !";
    $isValid = 0;
    $row=array('isValid' =>0,'rows' => $pesan);
}else{
    $data= mysqli_fetch_assoc($ex_query);
    $row['rows'] = $data;
    $isValid = 1;
    $row=array('isValid' =>1,'rows' => $data);
    session_start();
    $_SESSION['KONEKSI']=$koneksi;
    $_SESSION['USERNAME']=$data['user'];
    $_SESSION['PASSWORD']=$data['password'];
    $_SESSION['KODE_KANTOR']=$data['kd_cabang'];
    $_SESSION['DIVISI_ID']=$data['divisi_id'];
    $_SESSION['JABATAN']=$data['jabatan'];
    $_SESSION['USER_ID']=$data['user_id'];
    $_SESSION['NIK']=$data['nik'];
    $_SESSION['GROUP_MENU']=$data['group_menu'];
    $_SESSION['KODE_AREA']=$data['kode_area'];
    $_SESSION['USER_ID_INDUK']=$data['user_id_induk'];
    $_SESSION['EMAIL']=$data['email'];
}

echo json_encode($row);
mysqli_close($KONEKSI);
