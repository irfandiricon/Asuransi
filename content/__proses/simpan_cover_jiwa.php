<?php
include "../../koneksi_db/Koneksi.php";
include "../../__setting_email.php";
include "../master/master_data_email.php";

$hasil = array();
$email_user = isset($_SESSION['EMAIL']) ? $_SESSION['EMAIL']:"";
$table_cover_jiwa = TABLE_COVER_JIWA;

$no_rekening = isset($_POST['no_rekening']) ? $_POST['no_rekening']:"";
$kode_asuransi_jiwa = isset($_POST['kode_asuransi_jiwa']) ? $_POST['kode_asuransi_jiwa']:"";
$kode_kantor = isset($_POST['kode_kantor']) ? $_POST['kode_kantor']:"";
$jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin']:"";
$tinggi_asuransi_jiwa = isset($_POST['tinggi_asuransi_jiwa']) ? $_POST['tinggi_asuransi_jiwa']:"";
$berat_asuransi_jiwa = isset($_POST['berat_asuransi_jiwa']) ? $_POST['berat_asuransi_jiwa']:"";
$rate = isset($_POST['rate']) ? $_POST['rate']:"";
$nilai_premi = isset($_POST['nilai_premi']) ? $_POST['nilai_premi']:"";
$selisih = isset($_POST['selisih']) ? $_POST['selisih']:"";
$created_by = isset($_POST['created_by']) ? $_POST['created_by']:"";

$file_name_spa = isset($_FILES['file_spa']['name']) ? $_FILES['file_spa']['name']:"";
$file_tmp_name_spa = isset($_FILES['file_spa']['tmp_name']) ? $_FILES['file_spa']['tmp_name']:"";
$file_size_spa = isset($_FILES['file_spa']['size']) ? $_FILES['file_spa']['size']:"";
$file_type_spa = isset($_FILES['file_spa']['type']) ? $_FILES['file_spa']['type']:"";

$file_name_ktp = isset($_FILES['file_ktp']['name']) ? $_FILES['file_ktp']['name']:"";
$file_tmp_name_ktp = isset($_FILES['file_ktp']['tmp_name']) ? $_FILES['file_ktp']['tmp_name']:"";
$file_size_ktp = isset($_FILES['file_ktp']['size']) ? $_FILES['file_ktp']['size']:"";
$file_type_ktp = isset($_FILES['file_ktp']['type']) ? $_FILES['file_ktp']['type']:"";

$tgl_sekarang = date('d-m-Y');
$tgl_realisasi = isset($_POST['tgl_realisasi']) ? $_POST['tgl_realisasi']:"";
$nama_asuransi = isset($_POST['nama_asuransi']) ? $_POST['nama_asuransi']:"";
$nama_nasabah = isset($_POST['nama_nasabah']) ? $_POST['nama_nasabah']:"";
$alamat = isset($_POST['alamat']) ? $_POST['alamat']:"";
$nama_user = isset($_POST['nama_user']) ? $_POST['nama_user']:"";

list($thn,$bln,$tgl) = explode("-",$tgl_realisasi);
$tanggal_realisasi = "$tgl-$bln-$thn";

$allowed_file_types = array('.pdf');
$file_ext_spa = substr($file_name_spa, strripos($file_name_spa, '.'));
$file_basename_spa = substr($file_name_spa, 0, strripos($file_name_spa, '.'));
$newfilename_spa = $no_rekening.$file_ext_spa;

$file_ext_ktp = substr($file_name_ktp, strripos($file_name_ktp, '.'));
$file_basename_ktp = substr($file_name_ktp, 0, strripos($file_name_ktp, '.'));
$newfilename_ktp = $no_rekening.$file_ext_ktp;

$q1 = "SELECT COUNT(*) as total FROM $DB.$table_cover_jiwa  WHERE no_rekening='$no_rekening'";
$ex_q1 = mysqli_query($KONEKSI,$q1);
$res_ex_q1 = mysqli_fetch_assoc($ex_q1);
$total = $res_ex_q1['total'];
if($total > 0){
    $pesan = "Data Sudah Tersedia !!!";
    $info = 0;
}else{
    $q2 = "INSERT INTO $DB.$table_cover_jiwa (no_rekening, kode_asuransi, kode_group_cabang, jenis_kelamin,
    tinggi_badan, berat_badan, rateAsuransi, titipan_asuransi, selisih, file_ktp, file_spa, created_date, created_by)
    values ('$no_rekening', '$kode_asuransi_jiwa', '$kode_kantor','$jenis_kelamin', '$tinggi_asuransi_jiwa', '$berat_asuransi_jiwa',
    '$rate', '$nilai_premi', '$selisih', '$newfilename_ktp', '$newfilename_spa', now(), '$created_by')";
    $ex_q2 = mysqli_query($KONEKSI, $q2);
    if(!$ex_q2){
        $pesan = "Data Gagal Tersimpan, Error : ".mysqli_error($KONEKSI);
    }else{
      $max_size_spa = 1024*1024*5;
      $max_size_ktp = 1024*1024*5;
      $target_path_ktp="../../file_upload/ktp/";
      $target_path_spa="../../file_upload/spa/";

      if (in_array($file_ext_spa,$allowed_file_types) && ($file_size_spa < $max_size_spa) && ($file_size_ktp < $max_size_ktp)) {
          if (file_exists($target_path_spa.$newfilename_spa) || file_exists($target_path_ktp.$newfilename_ktp)) {
              $pesan = "File sudah tersedia, data sudah tersimpan !!!";
              $info = 0;
          }else{
                $qu="UPDATE $DB.$table_cover_jiwa set file_spa = '$newfilename_spa',file_ktp='$newfilename_ktp' where no_rekening='$no_rekening'";
                $ex_qu=mysqli_query($KONEKSI,$qu);
                if($ex_qu){
                    if($kode_asuransi_jiwa=="007"){
                        move_uploaded_file($file_tmp_name_spa, $target_path_spa.$newfilename_spa);
                        move_uploaded_file($file_tmp_name_ktp, $target_path_ktp.$newfilename_ktp);
                    }else{
                        move_uploaded_file($file_tmp_name_spa, $target_path_spa.$newfilename_spa);
                    }
                    $pesan = "Data Berhasil Tersimpan !!!";
                    $info = 1;
                }else{
                    $pesan="Gagal Tersimpan, Error : ".mysqli_error($KONEKSI);
                    $info = 0;
                }

                $file_spa_location="http://103.234.254.186/asuransi/file_upload/spa/".$newfilename_spa;
                //$pesan = "DATA BERHASIL TERSIMPAN !!!";
                $subjek=strtoupper("Proses Asuransi Jiwa $nama_asuransi");
                $messages="Proses Asuransi Jiwa Telah Dilakukan <br><br> "
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
        } elseif (empty($file_basename) || empty($file_basename_ktp)) {
            $pesan="Tidak ada file lampiran, data sudah tersimpan !!!";
            $info = 0;
        } elseif ($file_size > $max_size_spa || $file_size_ktp > $max_size_ktp) {
            $pesan="File yang diupload terlalu besar, data sudah tersimpan !!!";
            $info = 0;
        } else {
            $pesan="Type file yang dizinkan : " . implode(', ',$allowed_file_types);
            $info = 0;
            unlink($file_tmp_name);
        }
    }
}

echo json_encode($pesan);
mysqli_close($KONEKSI);
?>
