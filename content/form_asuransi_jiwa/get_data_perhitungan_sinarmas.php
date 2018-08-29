<?php
include "../../koneksi_db/Koneksi.php";
$parameter_sinarmas_tetap = PARAMETER_SINARMAS_TETAP;
$table_rate_jiwa_tetap_sinarmas = TABLE_RATE_JIWA_TETAP_SINARMAS;
$table_rate_jiwa_menurun_sinarmas = TABLE_RATE_JIWA_MENURUN_SINARMAS;
$no_rekening = isset($_POST['rows']['no_rekening']) ? $_POST['rows']['no_rekening']:"";
$type_kredit = isset($_POST['rows']['type_kredit']) ? $_POST['rows']['type_kredit']:"";
$jml_angsuran = isset($_POST['rows']['jml_angsuran']) ? $_POST['rows']['jml_angsuran']:"";
$tgl_lahir = isset($_POST['rows']['tgllahir']) ? $_POST['rows']['tgllahir']:"";
$nilai_premi_jiwa= isset($_POST['rows']['nilai_premi_jiwa']) ? $_POST['rows']['nilai_premi_jiwa']:"";
$jml_pinjaman = isset($_POST['rows']['jml_pinjaman']) ? $_POST['rows']['jml_pinjaman']:"";

$tenor = ceil($jml_angsuran/12);
$tanggal_sekarang = date('Y-m-d');

$biday=new DateTime($tgl_lahir);
$tanggal_sekarang=new DateTime();
$diff=$tanggal_sekarang->diff($biday);
$umur_tahun=$diff->y;
$umur_bulan=$diff->m;
//$umur="$umur_tahun Tahun - $umur_bulan Bulan";
if ($umur_bulan >= 6){
    $umur=$umur_tahun+1;
}else{
    $umur=$umur_tahun;
}

if(in_array($type_kredit, array($parameter_sinarmas_tetap))){
    $table_rate_sinarmas = $table_rate_jiwa_tetap_sinarmas;
}else{
    $table_rate_sinarmas = $table_rate_jiwa_menurun_sinarmas;
}

$table_tenor = "th_$tenor";

$q_rate_sinarmas = "SELECT $table_tenor from $table_rate_sinarmas where usia='$umur'";
$ex_q_rate_sinarmas = mysqli_query($KONEKSI, $q_rate_sinarmas);
$res_ex_q_rate_sinarmas = mysqli_fetch_assoc($ex_q_rate_sinarmas);
$nilai_rate_sinarmas_old = $res_ex_q_rate_sinarmas[$table_tenor];
$nilai_rate_sinarmas = str_replace(",", ".", $nilai_rate_sinarmas_old);

$premi=round($nilai_rate_sinarmas*$jml_pinjaman/1000);

$str_premi=substr($premi,-3);
if ($str_premi==0){
    $nilai_bulat_500 = 0;
}else{
    $nilai_bulat_500 = 500;
}

$nilai_bulat_1000 = 1000;

if ($str_premi <= $nilai_bulat_500) {
    $nilai_awal=$nilai_bulat_500-$str_premi;
    $nilai_akhir=$premi+$nilai_awal;
}
if ($str_premi <= $nilai_bulat_1000 && $str_premi > $nilai_bulat_500){
    $nilai_awal=$nilai_bulat_1000-$str_premi;
    $nilai_akhir=$premi+$nilai_awal;
}

$nilai_premi = $nilai_akhir;
$selisih = $nilai_premi_jiwa - $nilai_akhir;

$data = array("rate" => $nilai_rate_sinarmas, "premi" => $nilai_premi, "selisih" => $selisih);

echo json_encode($data);
mysqli_close($KONEKSI);
?>
