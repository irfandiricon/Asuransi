<?php
include_once("../koneksi_db/Koneksi.php");
$dpm_online = DB_DPM_ONLINE;
$table_kredit = TABLE_KREDIT;
$table_cover_jaminan = TABLE_COVER_JAMINAN;
$table_jaminan_document = TABLE_JAMINAN_DOKUMENT;
$table_nasabah = TABLE_NASABAH;
$table_kre_kode_asuransi = TABLE_KRE_KODE_ASURANSI;
$table_okupasi = TABLE_OKUPASI;
$tipe_kendaraan_motor = TIPE_KENDARAAN_MOTOR;

$nama_perusahaan = NAMA_PERUSAHAAN;
$alamat_perusahaan = ALAMAT_PERUSAHAAN;
$tanggal_sekarang = date('d F Y');

$kode_asuransi = isset($_POST['kode_asuransi']) ? $_POST['kode_asuransi']:"";
$jenis = isset($_POST['jenis']) ? $_POST['jenis']:"";
$tipe_kendaraan = isset($_POST['tipe_kendaraan']) ? $_POST['tipe_kendaraan']:"";
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
$objPHPExcel->getActiveSheet()->setCellValue('A3','COVER ASURANSI KENDARAAN BERMOTOR ('.$tipe_kendaraan.') '.$nama_asuransi);
$objPHPExcel->getActiveSheet()->setCellValue('A4', $tanggal_sekarang);
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'No');
$objPHPExcel->getActiveSheet()->setCellValue('B5', 'Tanggal pengajuan');
$objPHPExcel->getActiveSheet()->setCellValue('C5', 'No rekening');
$objPHPExcel->getActiveSheet()->setCellValue('D5', 'Nama nasabah');
$objPHPExcel->getActiveSheet()->setCellValue('E5', 'Lama cover');
$objPHPExcel->getActiveSheet()->setCellValue('F5', 'Nilai pertanggungan');
$objPHPExcel->getActiveSheet()->setCellValue('G5', 'Spesifikasi kendaraan');
$objPHPExcel->getActiveSheet()->setCellValue('G6', 'Merk / Type');
$objPHPExcel->getActiveSheet()->setCellValue('H6', 'Tahun');
$objPHPExcel->getActiveSheet()->setCellValue('I6', 'Warna');
$objPHPExcel->getActiveSheet()->setCellValue('J6', 'No. Polisi');
$objPHPExcel->getActiveSheet()->setCellValue('K6', 'No. Rangka');
$objPHPExcel->getActiveSheet()->setCellValue('L6', 'No. Mesin');

$objPHPExcel->getActiveSheet()->mergeCells('A1:L1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:L2');
$objPHPExcel->getActiveSheet()->mergeCells('A3:L3');
$objPHPExcel->getActiveSheet()->mergeCells('A4:L4');
$objPHPExcel->getActiveSheet()->mergeCells('H5:L5');
$objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
$objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
$objPHPExcel->getActiveSheet()->mergeCells('C5:C6');
$objPHPExcel->getActiveSheet()->mergeCells('D5:D6');
$objPHPExcel->getActiveSheet()->mergeCells('E5:E6');
$objPHPExcel->getActiveSheet()->mergeCells('F5:F6');
$objPHPExcel->getActiveSheet()->mergeCells('G5:L5');

$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3:M3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A4:M4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5:M5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A3:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$n=7;
$no=1;

$query = "SELECT a.kode_kantor, b.no_rekening, a.tgl_realisasi, a.tgl_jatuh_tempo, d.nama_nasabah,
    a.jml_angsuran, a.kode_asuransi, e.deskripsi_asuransi, b.nilai_pertanggungan,
    b.titipan_asuransi, c.kd_jenis, c.kd_merk, c.kd_type,
    c.no_rangka, c.no_mesin, c.warna, c.tahun, c.no_polisi, c.alamat_bpkb, b.selisih, b.kode_pertanggungan
    FROM dpm_online.kredit AS a
    INNER JOIN webtool.asr_cover_jaminan AS b ON a.no_rekening = b.no_rekening
    INNER JOIN dpm_online.jaminan_dokument AS c ON c.agunan_id = b.agunan_id
    INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
    INNER JOIN dpm_online.kre_kode_asuransi AS e ON b.kode_asuransi = e.kode_asuransi
    WHERE b.kode_asuransi = '$kode_asuransi' AND b.jenis_jaminan='$jenis'
    AND DATE(b.created_date) BETWEEN'$periode_awal' AND '$periode_akhir'
    AND c.kd_jenis IN ($tipe_kendaraan_motor)
    ORDER BY a.tgl_realisasi asc ";

$ex_query=mysqli_query($KONEKSI,$query);
//
// echo json_encode($query);
// exit();
while($d= mysqli_fetch_assoc($ex_query)){
    list($thn,$bln,$tgl) = explode("-",$d['tgl_realisasi']);
    $tgl_realisasi = "$tgl-$bln-$thn";
    $no_rekening = $d['no_rekening'];
    $nama_nasabah = $d['nama_nasabah'];
    $lama_cover = $d['jml_angsuran'];
    $nilai_pertanggungan = $d['nilai_pertanggungan'];
    $kd_merk=$d['kd_merk'];
    $kd_type=$d['kd_type'];
    $tahun=$d['tahun'];
    $warna=$d['warna'];
    $no_polisi=$d['no_polisi'];
    $no_rangka=$d['no_rangka'];
    $no_mesin=$d['no_mesin'];

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $no++);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, $tgl_realisasi);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $no_rekening);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$n, $nama_nasabah);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, $lama_cover);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, number_format($nilai_pertanggungan,2));
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $kd_merk." / ".$kd_type);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$n, $tahun);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$n, $warna);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$n, $no_polisi);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$n, $no_rangka);
    $objPHPExcel->getActiveSheet()->setCellValue('L'.$n, $no_mesin);

    $objPHPExcel->getActiveSheet()->getStyle('F'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$n++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('30');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth('20');
$objPHPExcel->getActiveSheet()->setTitle($JudulData);

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=DATA.xls ");
header('Cache-Control: max-age=0');
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->setPreCalculateFormulas(false);
$objWriter->save('php://output');
