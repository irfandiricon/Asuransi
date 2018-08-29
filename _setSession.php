<?php 
session_start();
$koneksi = isset($_POST['koneksi']) ? $_POST['koneksi']:"";
$username = isset($_POST['username']) ? $_POST['username']:"";
$password = isset($_POST['password']) ? $_POST['password']:"";
$kode_kantor = isset($_POST['kode_kantor']) ? $_POST['kode_kantor']:"";
$divisi_id = isset($_POST['divisi_id']) ? $_POST['divisi_id']:"";
$jabatan = isset($_POST['jabatan']) ? $_POST['jabatan']:"";
$user_id = isset($_POST['user_id']) ? $_POST['user_id']:"";
$nik = isset($_POST['nik']) ? $_POST['nik']:"";
$group_menu = isset($_POST['group_menu']) ? $_POST['group_menu']:"";
$kode_area = isset($_POST['kode_area']) ? $_POST['kode_area']:"";
$user_id_induk = isset($_POST['user_id_induk']) ? $_POST['user_id_induk']:"";
$token = isset($_POST['token']) ? $_POST['token']:"";

$_SESSION['KONEKSI'] = $koneksi;
$_SESSION['USERNAME'] = $username;
$_SESSION['PASSWORD'] = $password;
$_SESSION['KODE_KANTOR'] = $kode_kantor;
$_SESSION['DIVISI_ID'] = $divisi_id;
$_SESSION['JABATAN'] = $jabatan;
$_SESSION['USER_ID'] = $user_id;
$_SESSION['NIK'] = $nik;
$_SESSION['GROUP_MENU'] = $group_menu;
$_SESSION['KODE_AREA'] = $kode_area;
$_SESSION['USER_ID_INDUK'] = $user_id_induk;
$_SESSION['jwt'] = $token;
?>