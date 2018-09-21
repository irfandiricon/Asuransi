<?php

include "../../koneksi_db/Koneksi.php";
$dpm_online = DB_DPM_ONLINE;
$kode_asuransi_jaminan = KODE_ASURANSI_JAMINAN;
$table_jaminan_dokument = TABLE_JAMINAN_DOKUMENT;
$table_kre_kode_asuransi = TABLE_KRE_KODE_ASURANSI;
$table_nasabah = TABLE_NASABAH;
$table_kredit = TABLE_KREDIT;
$pic_asuransi = 'nini_hernita';
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

if(in_array($username, array("nini_hernita")) || in_array($group_menu,array("IT"))){
    $paramater_kantor = "";
}else{
    $paramater_kantor = "and a.kode_kantor = '$kode_kantor'";
}

$query[] = "SELECT COUNT(*) as total
    FROM dpm_online.kredit AS a
    INNER JOIN webtool.asr_cover_jaminan AS b ON a.no_rekening = b.no_rekening
    INNER JOIN dpm_online.jaminan_dokument AS c ON c.agunan_id = b.agunan_id
    INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
    INNER JOIN dpm_online.kre_kode_asuransi AS e ON b.kode_asuransi = e.kode_asuransi
    LEFT JOIN webtool.asr_polis AS f ON b.no_rekening = f.no_rekening AND b.agunan_id = f.agunan_id AND f.jenis_asuransi='1'
    WHERE b.created_date like '%$tanggal_cover%' $paramater_kantor
    AND (b.no_rekening like '$keyword%' or d.nama_nasabah like '%$keyword%')";

$query[] = "SELECT f.id, f.id_polis, b.no_rekening, a.tgl_realisasi, a.tgl_jatuh_tempo, c.agunan_id, a.nilai_asuransi, d.nama_nasabah, d.alamat, d.tgllahir, c.jenis,
    a.jml_angsuran, a.jml_pinjaman, a.nilai_taksasi_agunan, a.kode_asuransi, UPPER(e.deskripsi_asuransi) AS deskripsi_asuransi, b.rate, b.nilai_pertanggungan,
    b.premi, b.titipan_asuransi, b.total_titipan, b.komisi, b.net_premi, b.created_date, b.created_by, c.kd_jenis, c.kd_merk, c.kd_type,
    c.no_rangka, c.no_mesin, c.warna, c.tahun, c.no_polisi, c.nama_bpkb, c.alamat_bpkb, c.nama_pemilik_sertifikat, c.alamat_sertifikat, c.kelurahan_sertifikat, c.kecamatan_sertifikat,
    c.kota_sertifikat, c.propinsi_sertifikat, c.kode_pos_sertifikat, b.okupasi, b.kode_pertanggungan, b.selisih, f.id_polis,
    IF(f.status_endorsement=1,'Ya', IF(f.status_endorsement=0,'Tidak',NULL)) AS status_endorsement, d.tempatlahir, d.telpon,
    IF(c.jenis='BPKB',c.nama_bpkb, c.nama_pemilik_sertifikat) as nama_jaminan,
    IF(c.jenis='BPKB',c.alamat_bpkb, c.alamat_sertifikat) as alamat_jaminan
    FROM dpm_online.kredit AS a
    INNER JOIN webtool.asr_cover_jaminan AS b ON a.no_rekening = b.no_rekening
    INNER JOIN dpm_online.jaminan_dokument AS c ON c.agunan_id = b.agunan_id
    INNER JOIN dpm_online.nasabah AS d ON a.nasabah_id = d.nasabah_id
    INNER JOIN dpm_online.kre_kode_asuransi AS e ON b.kode_asuransi = e.kode_asuransi
    LEFT JOIN webtool.asr_polis AS f ON b.no_rekening = f.no_rekening AND b.agunan_id = f.agunan_id AND f.jenis_asuransi='1'
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
