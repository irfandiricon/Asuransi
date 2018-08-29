<?php
include "../../koneksi_db/Koneksi.php";
$table_rate_jiwasraya = TABLE_RATE_JIWASRAYA;
$no_rekening = isset($_POST['rows']['no_rekening']) ? $_POST['rows']['no_rekening']:"";
$tgl_realisasi = isset($_POST['rows']['tgl_realisasi']) ? $_POST['rows']['tgl_realisasi']:"";
$type_kredit = isset($_POST['rows']['type_kredit']) ? $_POST['rows']['type_kredit']:"";
$jml_angsuran = isset($_POST['rows']['jml_angsuran']) ? $_POST['rows']['jml_angsuran']:"";
$tgl_lahir = isset($_POST['rows']['tgllahir']) ? $_POST['rows']['tgllahir']:"";
$nilai_premi_jiwa= isset($_POST['rows']['nilai_premi_jiwa']) ? $_POST['rows']['nilai_premi_jiwa']:"";
$jml_pinjaman = isset($_POST['rows']['jml_pinjaman']) ? $_POST['rows']['jml_pinjaman']:"";

$tanggal_sekarang = date('Y-m-d');

$jumlah_tenor = $jml_angsuran/12;

$tahun = 0;
$sisa = 0;
list($tahun,$sisa) = array_pad(explode(".",$jumlah_tenor),2,null);

list($thn_mulai,$bln_mulai,$tgl_mulai) = explode('-',$tgl_realisasi);

$tahun_1 = $tahun+1;
$tahun_2 = $tahun;
$data_bulan = $tahun*12;

if($tgl_mulai > 25){
	$sisa_bulan=($jml_angsuran-$data_bulan)+1;
}else{
	$sisa_bulan=$jml_angsuran-$data_bulan;
}

if($tgl_mulai > 25){
    $q1="SELECT nilai_rate FROM $table_rate_jiwasraya where id='$tahun_1'";
    $ex_q1= mysqli_query($KONEKSI, $q1);
    $res_ex_q1= mysqli_fetch_array($ex_q1);
    $rateJiwasraya_1=str_replace(",",".",$res_ex_q1['nilai_rate']);

    $q2="SELECT nilai_rate FROM $table_rate_jiwasraya where id='$tahun_2'";
    $ex_q2= mysqli_query($KONEKSI, $q2);
    $res_ex_q2= mysqli_fetch_array($ex_q2);
    $rateJiwasraya_2=str_replace(",",".",$res_ex_q2['nilai_rate']);

    $rateJiwasraya=number_format((($rateJiwasraya_1 * $sisa_bulan) + ($rateJiwasraya_2 * (12-$sisa_bulan))) / 12,3);
}else{
    $q1="SELECT nilai_rate FROM $table_rate_jiwasraya where id='$tahun_1'";
    $ex_q1= mysqli_query($KONEKSI, $q1);
    $res_ex_q1= mysqli_fetch_array($ex_q1);
    $rateJiwasraya_1=str_replace(",",".",$res_ex_q1['nilai_rate']);

    $q2="SELECT nilai_rate FROM $table_rate_jiwasraya where id='$tahun_2'";
    $ex_q2= mysqli_query($KONEKSI, $q2);
    $res_ex_q2= mysqli_fetch_array($ex_q2);
    $rateJiwasraya_2=str_replace(",",".",$res_ex_q2['nilai_rate']);

    $rateJiwasraya=number_format((($rateJiwasraya_1 * $sisa_bulan) + ($rateJiwasraya_2 * (12-$sisa_bulan))) / 12,3);
}

$premi=round(str_replace(',','.',$rateJiwasraya)*$jml_pinjaman/1000);

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

$data = array("rate" => $rateJiwasraya, "premi" => $nilai_premi, "selisih" => $selisih);

echo json_encode($data);
mysqli_close($KONEKSI);
?>
