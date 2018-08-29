<?php
include_once("../koneksi_db/Koneksi.php");
$dpm_online = DB_DPM_ONLINE;
$table_kredit = TABLE_KREDIT;
$table_cover_jaminan = TABLE_COVER_JAMINAN;
$table_jaminan_document = TABLE_JAMINAN_DOKUMENT;
$table_nasabah = TABLE_NASABAH;
$table_kre_kode_asuransi = TABLE_KRE_KODE_ASURANSI;
$table_okupasi = TABLE_OKUPASI;

$nama_perusahaan = NAMA_PERUSAHAAN;
$alamat_perusahaan = ALAMAT_PERUSAHAAN;
$tanggal_sekarang = date('d F Y');

$kode_asuransi = isset($_POST['kode_asuransi']) ? $_POST['kode_asuransi']:"";
$jenis = isset($_POST['jenis']) ? $_POST['jenis']:"";
$periode_awal = isset($_POST['periode_awal']) ? $_POST['periode_awal']:"";
$periode_akhir = isset($_POST['periode_akhir']) ? $_POST['periode_akhir']:"";

$q1 = "SELECT deskripsi_asuransi FROM $dpm_online.$table_kre_kode_asuransi WHERE kode_asuransi='$kode_asuransi'";
$ex_q1 = mysqli_query($KONEKSI, $q1);
$res_q1 = mysqli_fetch_assoc($ex_q1);
$nama_asuransi = strtoupper($res_q1['deskripsi_asuransi']);

$JudulData="Asuransi Jaminan";

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
date_default_timezone_set('Asia/Jakarta');

require_once '../__plugin/PHPExcel.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel
       ->getProperties()->setCreator("Irfandi Ricon")
       ->setLastModifiedBy("Irfandi Ricon")
       ->setTitle("Reports")
       ->setSubject("Excel Download")
       ->setDescription("Dokumen ACE")
       ->setKeywords("phpExcel")
       ->setCategory("Dokumen ACE");
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->setCellValue('A1',$nama_perusahaan);
$objPHPExcel->getActiveSheet()->setCellValue('A2',$alamat_perusahaan);
$objPHPExcel->getActiveSheet()->setCellValue('A3','COVER ASURANSI KEBAKARAN '.$nama_asuransi);
$objPHPExcel->getActiveSheet()->setCellValue('A4', $tanggal_sekarang);
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'No');
$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Tanggal pengajuan');
$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Keterangan okupasi');
$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Rate');
$objPHPExcel->getActiveSheet()->setCellValue('E5', 'No PK');
$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Nama nasabah');
$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Lama cover');
$objPHPExcel->getActiveSheet()->setCellValue('H5', 'Nilai pertanggungan');
$objPHPExcel->getActiveSheet()->setCellValue('I5', 'Spesifikasi objek yang dijaminkan');

$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:I4');

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5:I5')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$n=6;
$no=1;

$query = "SELECT b.created_date, b.no_rekening, a.tgl_realisasi, d.nama_nasabah,
    a.jml_angsuran, a.kode_asuransi, e.deskripsi_asuransi, b.nilai_pertanggungan,
    b.titipan_asuransi, c.alamat_sertifikat, c.kelurahan_sertifikat, c.kecamatan_sertifikat,
    c.kota_sertifikat, c.propinsi_sertifikat, c.kode_pos_sertifikat, f.deskripsi_okupasi, f.tarif_premi
    FROM $dpm_online.$table_kredit AS a
    INNER JOIN $DB.$table_cover_jaminan AS b ON a.no_rekening = b.no_rekening
    INNER JOIN $dpm_online.$table_jaminan_document AS c ON c.agunan_id = b.agunan_id
    INNER JOIN $dpm_online.$table_nasabah AS d ON a.nasabah_id = d.nasabah_id
    INNER JOIN $dpm_online.$table_kre_kode_asuransi AS e ON b.kode_asuransi = e.kode_asuransi
    INNER JOIN $DB.$table_okupasi AS f ON b.okupasi = f.id
    WHERE b.kode_asuransi = '$kode_asuransi' AND b.jenis_jaminan='$jenis'
    AND DATE(b.created_date) BETWEEN'$periode_awal' AND '$periode_akhir'
    ORDER BY a.tgl_realisasi asc";

$ex_query=mysqli_query($KONEKSI,$query);
while($d= mysqli_fetch_assoc($ex_query)){
    list($thn,$bln,$tgl) = explode("-",$d['tgl_realisasi']);
    $tgl_realisasi = "$tgl-$bln-$thn";
    $deskripsi_okupasi = $d['deskripsi_okupasi'];
    $no_rekening = $d['no_rekening'];
    $nama_nasabah = $d['nama_nasabah'];
    $lama_cover = $d['jml_angsuran'];
    $nilai_pertanggungan = $d['nilai_pertanggungan'];
    $rate=$d['tarif_premi'];
    $alamat_sertifikat=$d['alamat_sertifikat'];
    $kelurahan_sertifikat=$d['kelurahan_sertifikat'];
    $kecamatan_sertifikat=$d['kecamatan_sertifikat'];
    $kota_sertifikat=$d['kota_sertifikat'];
    $propinsi_sertifikat=$d['propinsi_sertifikat'];
    $kode_pos_sertifikat=$d['kode_pos_sertifikat'];

    if (empty($kode_pos_sertifikat)){
        $kode_pos_sertifikat="";
    }else{
        $kode_pos_sertifikat=",$kode_pos_sertifikat";
    }

    $alamat_jaminan= strtolower("$alamat_sertifikat, $kelurahan_sertifikat, $kecamatan_sertifikat, "
            . "$kota_sertifikat, $propinsi_sertifikat $kode_pos_sertifikat");

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $no++);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, $tgl_realisasi);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $deskripsi_okupasi);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$n, $rate);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, $no_rekening);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, $nama_nasabah);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $lama_cover);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$n, number_format($nilai_pertanggungan,2));
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$n, $alamat_jaminan);

    $objPHPExcel->getActiveSheet()->getStyle('H'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$n++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('50');
$objPHPExcel->getActiveSheet()->setTitle($JudulData);

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=DATA.xls ");
header('Cache-Control: max-age=0');
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->setPreCalculateFormulas(false);
$objWriter->save('php://output');
