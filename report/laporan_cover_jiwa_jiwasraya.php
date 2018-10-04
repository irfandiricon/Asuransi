<?php
include "../koneksi_db/Koneksi.php";
$nama_perusahaan = strtoupper(NAMA_PERUSAHAAN);
$alamat_perusahaan = ALAMAT_PERUSAHAAN;

$table_app_kode_kantor = TABLE_APP_KODE_KANTOR;
$dpm_online = DB_DPM_ONLINE;
$table_kredit = TABLE_KREDIT;
$table_cover_jiwa = TABLE_COVER_JIWA;
$table_jaminan_document = TABLE_JAMINAN_DOKUMENT;
$table_nasabah = TABLE_NASABAH;
$table_kre_kode_asuransi = TABLE_KRE_KODE_ASURANSI;
$table_css_kode_dati = TABLE_CSS_KODE_DATI;
$table_nasabah_alamat = TABLE_NASABAH_ALAMAT;
$table_css_kode_propvinsi = TABLE_CSS_KODE_PROPVINSI;

$now = date('Y-m');
$kode_asuransi = isset($_POST['kode_asuransi']) ? $_POST['kode_asuransi']:"";
$kategori = isset($_POST['kategori']) ? $_POST['kategori']:"";
$periode_awal = isset($_POST['periode_awal']) ? $_POST['periode_awal']:"$now";

$kode_kantor = isset($_SESSION['kode_kantor']) ? $_SESSION['kode_kantor']:"";
$q1 = "SELECT kota_kantor, nama_area_kerja FROM $DB.$table_app_kode_kantor where kode_kantor = '$kode_kantor'";
$ex_q1 = mysqli_query($KONEKSI, $q1);
$res_ex_q1 = mysqli_fetch_assoc($ex_q1);
$kota_kantor = $res_ex_q1['kota_kantor'];
$nama_area_kerja = $res_ex_q1['nama_area_kerja'];
$cabang = "$nama_area_kerja - $kota_kantor";

$JudulData="Asuransi Jiwa";
$lokasi = $kota_kantor.", ".date('d F Y');

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
$objPHPExcel->getActiveSheet()->setCellValue('A5', $nama_perusahaan);
$objPHPExcel->getActiveSheet()->setCellValue('A6', $alamat_perusahaan);
$objPHPExcel->getActiveSheet()->setCellValue('A7','COVER ASURANSI JIWASRAYA');
$objPHPExcel->getActiveSheet()->setCellValue('A8', $lokasi);
$objPHPExcel->getActiveSheet()->setCellValue('A9', 'No');
$objPHPExcel->getActiveSheet()->setCellValue('B9', 'No Rekening');
$objPHPExcel->getActiveSheet()->setCellValue('C9', 'Nama Tertanggung');
$objPHPExcel->getActiveSheet()->setCellValue('D9', 'Tempat Lahir');
$objPHPExcel->getActiveSheet()->setCellValue('E9', 'Tanggal Lahir');
$objPHPExcel->getActiveSheet()->setCellValue('F9', 'Alamat');
$objPHPExcel->getActiveSheet()->setCellValue('G9', 'Wilayah');
$objPHPExcel->getActiveSheet()->setCellValue('H9', 'No. Telp / HP');
$objPHPExcel->getActiveSheet()->setCellValue('I9', 'Berat Badan (Kg)');
$objPHPExcel->getActiveSheet()->setCellValue('J9', 'Tinggi Badan (Cm)');
$objPHPExcel->getActiveSheet()->setCellValue('K9', 'Up. Awal (Rp.)');
$objPHPExcel->getActiveSheet()->setCellValue('L9', 'Masa');
$objPHPExcel->getActiveSheet()->setCellValue('L10', 'Tahun');
$objPHPExcel->getActiveSheet()->setCellValue('M10', 'Bulan');
$objPHPExcel->getActiveSheet()->setCellValue('N9', 'Mulai Pertanggungan');
$objPHPExcel->getActiveSheet()->setCellValue('O9', 'Akhir Pertanggungan');
$objPHPExcel->getActiveSheet()->setCellValue('P9', 'Umur (Thn)');
$objPHPExcel->getActiveSheet()->setCellValue('Q9', 'Cek Body');

$objPHPExcel->getActiveSheet()->mergeCells('A5:Q5');
$objPHPExcel->getActiveSheet()->mergeCells('A6:Q6');
$objPHPExcel->getActiveSheet()->mergeCells('A7:Q7');
$objPHPExcel->getActiveSheet()->mergeCells('A8:Q8');

$objPHPExcel->getActiveSheet()->getStyle('A5:Q5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A6:Q6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A7:Q7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A8:Q8')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A9:Q9')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('L10:M10')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->mergeCells('A9:A10');
$objPHPExcel->getActiveSheet()->mergeCells('B9:B10');
$objPHPExcel->getActiveSheet()->mergeCells('C9:C10');
$objPHPExcel->getActiveSheet()->mergeCells('D9:D10');
$objPHPExcel->getActiveSheet()->mergeCells('E9:E10');
$objPHPExcel->getActiveSheet()->mergeCells('F9:F10');
$objPHPExcel->getActiveSheet()->mergeCells('G9:G10');
$objPHPExcel->getActiveSheet()->mergeCells('H9:H10');
$objPHPExcel->getActiveSheet()->mergeCells('I9:I10');
$objPHPExcel->getActiveSheet()->mergeCells('J9:J10');
$objPHPExcel->getActiveSheet()->mergeCells('K9:K10');
$objPHPExcel->getActiveSheet()->mergeCells('N9:N10');
$objPHPExcel->getActiveSheet()->mergeCells('O9:O10');
$objPHPExcel->getActiveSheet()->mergeCells('P9:P10');
$objPHPExcel->getActiveSheet()->mergeCells('Q9:Q10');
$objPHPExcel->getActiveSheet()->mergeCells('L9:M9');

$objPHPExcel->getActiveSheet()->getStyle('L9:M9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$n=11;
$no=1;

$query = "SELECT DISTINCT
    d.no_id, b.no_ktp, d.nama_nasabah, d.tempatlahir, d.tgllahir, d.alamat, h.ktp_alamat, h.ktp_rt,
    h.ktp_rw, h.ktp_desa, h.ktp_kecamatan, g.deskripsi_kode_dati  AS kota_kab, i.nama_provinsi AS ktp_propinsi, h.ktp_kodepos,
    b.tinggi_badan, b.berat_badan, d.hp AS no_telp, d.telpon, a.tgl_realisasi, a.tgl_jt_asuransi_jiwa,
    a.jml_angsuran, a.jml_pinjaman, a.nilai_taksasi_agunan,  a.nilai_asuransi_jiwa, b.no_rekening, b.nama_tertanggung,
    b.titipan_asuransi
    FROM $dpm_online.$table_kredit AS a
    INNER JOIN $DB.$table_cover_jiwa AS b ON a.no_rekening = b.no_rekening
    INNER JOIN $dpm_online.$table_jaminan_document AS c ON
    	(a.agunan_id1 = c.agunan_id OR a.agunan_id2 = c.agunan_id OR a.agunan_id3 = c.agunan_id
    	OR a.agunan_id4 = c.agunan_id OR a.agunan_id5 = c.agunan_id)
    INNER JOIN $dpm_online.$table_nasabah AS d ON a.nasabah_id = d.nasabah_id
    INNER JOIN $dpm_online.$table_kre_kode_asuransi AS e ON e.kode_asuransi = b.kode_asuransi
    INNER JOIN $dpm_online.$table_app_kode_kantor AS f ON f.kode_kantor = b.kode_group_cabang
    INNER JOIN $dpm_online.$table_css_kode_dati AS g ON g.kode_dati = d.kota_kab
    INNER JOIN $dpm_online.$table_nasabah_alamat AS h ON h.nasabah_id = d.nasabah_id
    INNER JOIN $dpm_online.$table_css_kode_propvinsi AS i ON h.ktp_propinsi = i.kode_provinsi
    WHERE b.kode_asuransi = '007' and b.created_date like '%$periode_awal%'
    ORDER BY DATE(a.tgl_realisasi)";

$ex_query=mysqli_query($KONEKSI,$query);
while($d= mysqli_fetch_assoc($ex_query)){
    list($thn,$bln,$tgl) = explode("-",$d['tgl_realisasi']);
    $tgl_realisasi = "$tgl-$bln-$thn";
    $no_rekening = $d['no_rekening'];
    $nama_nasabah = $d['nama_nasabah'];
    $tempat_lahir = $d['tempatlahir'];
    $tanggal_lahir = $d['tgllahir'];
    $kota_kab = $d['kota_kab'];
    $ktp_alamat=$d['ktp_alamat'];
    $ktp_rt=$d['ktp_rt'];
    $ktp_rw=$d['ktp_rw'];
    $ktp_desa=$d['ktp_desa'];
    $ktp_kecamatan=$d['ktp_kecamatan'];
    $ktp_propinsi=$d['ktp_propinsi'];
    $ktp_kodepos=$d['ktp_kodepos'];
    $alamat_lengkap= strtolower("$ktp_alamat, RT. $ktp_rt, RW. $ktp_rw, $ktp_desa, $ktp_kecamatan, $kota_kab, $ktp_propinsi, $ktp_kodepos ");
    $wilayah = strtoupper($kota_kab);
    $no_telp = $d['no_telp'];
    $berat_badan = $d['berat_badan'];
    $tinggi_badan = $d['tinggi_badan'];
    $jml_pinjaman = $d['jml_pinjaman'];
    $tgl_jatuh_tempo = $d['tgl_jt_asuransi_jiwa'];
    $tgl_realisasi = $d['tgl_realisasi'];
    $tanggal_jatuh_tempo=new DateTime($tgl_jatuh_tempo);
    $tanggal_realisasi=new DateTime($tgl_realisasi);
    $diff=$tanggal_jatuh_tempo->diff($tanggal_realisasi);
    $masa_tahun=$diff->y;
    $masa_bulan=$diff->m;
    $waktu_lahir = $d['tgllahir'];
    $biday=new DateTime($waktu_lahir);
    $tanggal_sekarang=new DateTime();
    $diff_umur=$tanggal_sekarang->diff($biday);
    $umur_tahun=$diff_umur->y;
    $umur_bulan=$diff_umur->m;
    if ($umur_bulan > 6){
        $umur=$umur_tahun+1;
    }else{
        $umur=$umur_tahun;
    }

    $tgllahir = new DateTime($tanggal_lahir);
    $tgl_lahir = $tgllahir->format('d F Y');
    $tanggal_mulai = $tanggal_realisasi->format('d F Y');
    $tanggal_akhir = $tanggal_jatuh_tempo->format('d F Y');

    $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $no++);
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$n, $no_rekening);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$n, $nama_nasabah);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$n, $tempat_lahir);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$n, $tgl_lahir);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$n, $alamat_lengkap);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$n, $wilayah);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$n, $no_telp);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$n, $berat_badan);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$n, $tinggi_badan);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$n, number_format($jml_pinjaman,2));
    $objPHPExcel->getActiveSheet()->setCellValue('L'.$n, $masa_tahun);
    $objPHPExcel->getActiveSheet()->setCellValue('M'.$n, $masa_bulan);
    $objPHPExcel->getActiveSheet()->setCellValue('N'.$n, $tanggal_mulai);
    $objPHPExcel->getActiveSheet()->setCellValue('O'.$n, $tanggal_akhir);
    $objPHPExcel->getActiveSheet()->setCellValue('P'.$n, $umur);
    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$n, '');

    $objPHPExcel->getActiveSheet()->getStyle('K'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$n++;
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('45');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth('20');
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth('15');
$objPHPExcel->getActiveSheet()->setTitle($JudulData);

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=DATA.xls ");
header('Cache-Control: max-age=0');
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->setPreCalculateFormulas(false);
$objWriter->save('php://output');
 ?>
