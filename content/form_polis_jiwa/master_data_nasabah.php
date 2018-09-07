<?php

include "../../koneksi_db/Koneksi.php";
$dpm_online = DB_DPM_ONLINE;
$kode_asuransi_jaminan = KODE_ASURANSI_JAMINAN;
$table_jaminan_dokument = TABLE_JAMINAN_DOKUMENT;
$table_kre_kode_asuransi = TABLE_KRE_KODE_ASURANSI;
$table_nasabah = TABLE_NASABAH;
$table_kredit = TABLE_KREDIT;
$pic_asuransi = PIC_ASURANSI;
$table_cover_jaminan = TABLE_COVER_JAMINAN;
$table_polis = TABLE_POLIS;

$tanggal_sekarang = date('Y-m');
$keyword = isset($_POST['keyword']) ? $_POST['keyword']:"";
$tanggal_cover = isset($_POST['tgl_cover']) ? $_POST['tgl_cover']:"$tanggal_sekarang";
$kode_kantor = isset($_POST['kode_kantor']) ? $_POST['kode_kantor']:"";
$user_id = isset($_POST['user_id']) ? $_POST['user_id']:"";
$divisi_id = isset($_POST['divisi_id']) ? $_POST['divisi_id']:"";
$jabatan = isset($_POST['jabatan']) ? $_POST['jabatan']:"";
$username = isset($_POST['username']) ? $_POST['username']:"";
$group_menu = isset($_POST['group_menu']) ? $_POST['group_menu']:"";

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$jmlRows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
$offset = ( $page-1 )* $jmlRows;
$limit = "LIMIT $jmlRows OFFSET $offset";
$sort = isset($_POST['sort']) ? $_POST['sort']:"b.created_date";
$order = isset($_POST['order']) ? $_POST['order']:"asc";

$error=array();
$query=array();
$result=array('total' =>0 ,'rows' => array());

if(in_array($username, array($pic_asuransi)) || in_array($group_menu,array("IT"))){
    $paramater_kantor = "";
}else{
    $paramater_kantor = "and a.kode_kantor = '$kode_kantor'";
}

$lampiran_spa = "file_spa";
$lampiran_ktp = "file_ktp";
$link_spa = "'http://103.234.254.186/asuransi/file_upload/spa/'";
$link_ktp = "'http://103.234.254.186/asuransi/file_upload/ktp/'";
$file = "CONCAT('<a href=',".$link_spa.",".$lampiran_spa.",' target=__blank>',' &nbsp;<b>(SPA)</b>','</a>','  || ',
        '<a href=',".$link_ktp.",".$lampiran_ktp.",' target=__blank>',' &nbsp;<b>(KTP)</b>','</a>') as lampiran,";

$query[] = "SELECT COUNT(*) as total
    FROM dpm_online.kredit AS a
    INNER JOIN webtool.asr_cover_jiwa AS b ON a.no_rekening = b.no_rekening
    INNER JOIN dpm_online.jaminan_dokument AS c ON
    	(a.agunan_id1 = c.agunan_id OR a.agunan_id2 = c.agunan_id OR a.agunan_id3 = c.agunan_id
    	OR a.agunan_id4 = c.agunan_id OR a.agunan_id5 = c.agunan_id)
    INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
    INNER JOIN dpm_online.kre_kode_asuransi AS e ON e.kode_asuransi = b.kode_asuransi
    INNER JOIN dpm_online.app_kode_kantor AS f ON f.kode_kantor = b.kode_group_cabang
    INNER JOIN dpm_online.css_kode_dati AS g ON g.kode_dati = d.kota_kab
    INNER JOIN dpm_online.nasabah_alamat AS h ON h.nasabah_id = d.nasabah_id
    INNER JOIN dpm_online.css_kode_propvinsi AS i ON h.ktp_propinsi = i.kode_provinsi
    LEFT JOIN webtool.asr_polis AS f ON b.no_rekening = f.no_rekening AND f.jenis_asuransi='2'
    WHERE b.created_date like '%$tanggal_cover%' $paramater_kantor
    AND (b.no_rekening like '$keyword%' or d.nama_nasabah like '%$keyword%')";

$query[] = "SELECT $file
    f.id, f.id_polis, a.kode_kantor, d.no_id, b.no_ktp, d.nama_nasabah, f.nama_area_kerja, d.tempatlahir, d.tgllahir, d.alamat, h.ktp_alamat, h.ktp_rt,
    h.ktp_rw, h.ktp_desa, h.ktp_kecamatan, g.deskripsi_kode_dati  AS kota_kab, i.nama_provinsi AS ktp_propinsi, h.ktp_kodepos AS ktp_kodepos,
    b.jenis_kelamin, b.tinggi_badan, b.berat_badan, d.hp AS no_telp, d.telpon, a.type_kredit, a.tgl_realisasi, a.tgl_jatuh_tempo,
    a.tgl_jt_asuransi_jiwa AS tgl_jt_asuransi_jiwa, a.jml_angsuran, a.jml_pinjaman, a.nilai_taksasi_agunan, c.jenis, c.kd_jenis, a.nilai_asuransi_jiwa,
    c.alamat_bpkb, c.alamat_sertifikat, UPPER(e.deskripsi_asuransi) as deskripsi_asuransi, b.no_rekening, b.kode_asuransi, b.kode_group_cabang, b.nama_tertanggung,
    b.rateAsuransi AS rate, b.ratePremiGross AS premiGross, b.ratePremiCigna AS premiCigna, b.extraPremi, b.totalPremi, b.totalLoan,
    b.titipan_asuransi, b.biayaAdmin, b.keteranganJaminan, b.companyCode,  b.programCigna, b.created_date, b.created_by, b.file_spa, b.file_ktp,
    IF(f.status_endorsement=1,'Ya', IF(f.status_endorsement=0,'Tidak',NULL)) AS status_endorsement, '0' AS agunan_id
    FROM dpm_online.kredit AS a
    INNER JOIN webtool.asr_cover_jiwa AS b ON a.no_rekening = b.no_rekening
    INNER JOIN dpm_online.jaminan_dokument AS c ON
    	(a.agunan_id1 = c.agunan_id OR a.agunan_id2 = c.agunan_id OR a.agunan_id3 = c.agunan_id
    	OR a.agunan_id4 = c.agunan_id OR a.agunan_id5 = c.agunan_id)
    INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
    INNER JOIN dpm_online.kre_kode_asuransi AS e ON e.kode_asuransi = b.kode_asuransi
    INNER JOIN dpm_online.app_kode_kantor AS f ON f.kode_kantor = b.kode_group_cabang
    INNER JOIN dpm_online.css_kode_dati AS g ON g.kode_dati = d.kota_kab
    INNER JOIN dpm_online.nasabah_alamat AS h ON h.nasabah_id = d.nasabah_id
    INNER JOIN dpm_online.css_kode_propvinsi AS i ON h.ktp_propinsi = i.kode_provinsi
    LEFT JOIN webtool.asr_polis AS f ON b.no_rekening = f.no_rekening AND f.jenis_asuransi='2'
    WHERE b.created_date like '%$tanggal_cover%' $paramater_kantor
    AND (b.no_rekening like '$keyword%' or d.nama_nasabah like '%$keyword%')
    ORDER BY $sort $order $limit";

if (count($query) > 0){
    if (mysqli_multi_query($KONEKSI, join(";",$query))){
        do{
             if ($rs = mysqli_store_result($KONEKSI)){
                while ($row = mysqli_fetch_assoc($rs)) {
                   if(isset($row['total'])) {
                        $result['total']=$row['total'];
                        $result['query']=$query;
                   }else{
                        $result['rows'][]=$row;
                   }
                }
             }
        } while(next($query) && mysqli_more_results($KONEKSI) && mysqli_next_result($KONEKSI));
    }
    if(mysqli_error($KONEKSI)) $error[] = mysqli_error($KONEKSI);
    if (count($error) > 1){
            $result=array("total" => 0,"rows" => array(),"pesan" => join("",$error));
    }
}

echo json_encode($result);
mysqli_close($KONEKSI);
