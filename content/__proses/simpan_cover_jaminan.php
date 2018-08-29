<?php
include "../../koneksi_db/Koneksi.php";
include "../../__setting_email.php";
include "../master/master_data_email.php";

$email_user = $_SESSION['EMAIL'];
$table_cover_jaminan = TABLE_COVER_JAMINAN;

$no_rekening = isset($_POST['no_rekening']) ? $_POST['no_rekening']:"";
$nama_nasabah = isset($_POST['nama_nasabah']) ? $_POST['nama_nasabah']:"";
$alamat = isset($_POST['alamat']) ? $_POST['alamat']:"";
$agunan_id = isset($_POST['agunan_id']) ? $_POST['agunan_id']:"";
$jenis = isset($_POST['jenis']) ? $_POST['jenis']:"";
$kode_asuransi = isset($_POST['kode_asuransi']) ? $_POST['kode_asuransi']:"";
$id_okupasi = isset($_POST['id_okupasi']) ? $_POST['id_okupasi']:"0";
$kode_pertanggungan = isset($_POST['kode_pertanggungan']) ? $_POST['kode_pertanggungan']:"0";
$nilai_pertanggungan = isset($_POST['nilai_asuransi']) ? $_POST['nilai_asuransi']:"";
$rate = isset($_POST['rate']) ? $_POST['rate']:"";
$premi = str_replace(",","",isset($_POST['nilai_premi']) ? $_POST['nilai_premi']:"");
$selisih = isset($_POST['selisih']) ? $_POST['selisih']:"";
$nama_user = isset($_POST['nama_user']) ? $_POST['nama_user']:"";
$created_by = isset($_POST['created_by']) ? $_POST['created_by']:"";

$tgl_sekarang = date('d-m-Y');
$tgl_realisasi = isset($_POST['tgl_realisasi']) ? $_POST['tgl_realisasi']:"";
$nama_asuransi = isset($_POST['nama_asuransi']) ? $_POST['nama_asuransi']:"";

list($thn,$bln,$tgl) = explode("-",$tgl_realisasi);
$tanggal_realisasi = "$tgl-$bln-$thn";

$q1 = "SELECT COUNT(*) as total FROM $DB.$table_cover_jaminan  WHERE no_rekening='$no_rekening' and agunan_id='$agunan_id'";
$ex_q1 = mysqli_query($KONEKSI,$q1);
$res_ex_q1 = mysqli_fetch_assoc($ex_q1);
$total = $res_ex_q1['total'];

if($total > 0){
    $pesan = "DATA SUDAH TERSEDIA !!!";
}else{
    $q2 = "INSERT INTO $DB.$table_cover_jaminan (no_rekening, agunan_id, jenis_jaminan, kode_asuransi, okupasi, kode_pertanggungan,
    nilai_pertanggungan, rate, titipan_asuransi, selisih, created_date, created_by)
    values ('$no_rekening', '$agunan_id', '$jenis','$kode_asuransi', '$id_okupasi', '$kode_pertanggungan', '$nilai_pertanggungan',
    '$rate', '$premi', '$selisih', now(), '$created_by')";
    $ex_q2 = mysqli_query($KONEKSI, $q2);
    if(!$ex_q2){
        $pesan = "DATA GAGAL TERSIMPAN, ERROR : ".mysqli_error($KONEKSI);
    }else{
        $pesan = "DATA BERHASIL TERSIMPAN !!!";

        $subjek=strtoupper("Proses Asuransi Jaminan $nama_asuransi - $jenis");
        $messages="Proses Asuransi Jaminan Telah Dilakukan <br><br> "
                . "<table>"
                . "<tr>"
                . "<td width=130>Tanggal Proses</td> "
                . "<td width='5'>:</td>"
                . "<td>$tgl_sekarang</td>"
                . "</tr>"
                . "<tr>"
                . "<td>No. Rekening</td>"
                . "<td>:</td>"
                . "<td>$no_rekening</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Tgl Realisasi</td>"
                . "<td>:</td>"
                . "<td>$tanggal_realisasi</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Nama Nasabah</td>"
                . "<td>:</td>"
                . "<td>$nama_nasabah</td>"
                . "</tr>"
                . "<tr>"
                . "<td>Alamat</td>"
                . "<td>:</td>"
                . "<td>$alamat</td>"
                . "</tr>"
                . "<tr>"
                . "<td>User Input</td>"
                . "<td>:</td>"
                . "<td>$nama_user</td>"
                . "</tr>"
                . "</table>";

        $mail->setFrom("$email_user", '');
        //$mail->AddAddress("$email_asuransi_pusat", '');
        foreach ($email_asuransi_pusat as $email_pusat){
            $mail->AddAddress($email_pusat);
        }

        $mail->AddCC("$email_user");
        $mail->Subject = "$subjek";
        $mail->msgHTML("$messages");
        //$mail->send();

        if($mail->send()){
            $pesan_email = "EMAIL PEMBERITAHUAN TERKIRIM";
        }else{
            $pesan_email = "EMAIL PEMBERITAHUAN TIDAK TERKIRIM";
        }
    }
}
echo json_encode($pesan);
mysqli_close($KONEKSI);
