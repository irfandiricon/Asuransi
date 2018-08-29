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

$tanggal_sekarang = date('Y-m-d');
$keyword = isset($_POST['keyword']) ? $_POST['keyword']:"";
$tanggal_realisasi = isset($_POST['tgl_realisasi']) ? $_POST['tgl_realisasi']:"$tanggal_sekarang";
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
$sort = isset($_POST['sort']) ? $_POST['sort']:"no_rekening";
$order = isset($_POST['order']) ? $_POST['order']:"asc";

$error=array();
$query=array();
$result=array('total' =>0 ,'rows' => array());

if(in_array($username, array($pic_asuransi)) || in_array($group_menu,array("IT"))){
    $paramater_kantor = "";
}else{
    $paramater_kantor = "and a.kode_kantor = '$kode_kantor'";
}

$query[] = "SELECT COUNT(*) as total
FROM $dpm_online.$table_kredit  AS a
INNER JOIN $dpm_online.$table_jaminan_dokument AS b
	ON (a.agunan_id1 = b.agunan_id OR a.agunan_id2 = b.agunan_id OR a.agunan_id3 = b.agunan_id OR a.agunan_id4 = b.agunan_id OR a.agunan_id5 = b.agunan_id)
INNER JOIN $dpm_online.$table_nasabah AS c ON a.nasabah_id = c.nasabah_id
INNER JOIN $dpm_online.$table_kre_kode_asuransi AS d ON a.kode_asuransi = d.kode_asuransi
WHERE a.pokok_saldo_akhir <> 0 AND a.kode_asuransi IN ($kode_asuransi_jaminan)
AND a.tgl_realisasi = '$tanggal_realisasi' $paramater_kantor
AND (a.no_rekening like '$keyword%' or c.nama_nasabah like '%$keyword%')
AND a.no_rekening NOT IN (SELECT no_rekening FROM $DB.$table_cover_jaminan) ";

$query[] = "SELECT a.kode_asuransi, UPPER(CONCAT(a.kode_asuransi,' - ',d.deskripsi_asuransi)) as nama_asuransi,
UPPER(d.deskripsi_asuransi) AS deskripsi_asuransi, a.no_rekening, c.nasabah_id, c.nama_nasabah,
c.alamat, c.telpon, c.jenis_kelamin, c.tempatlahir, c.tgllahir, c.desa, c.kecamatan, a.kode_kantor, a.tgl_realisasi,
a.tgl_jatuh_tempo, a.materai AS nilai_premi_kebakaran, a.premi AS nilai_premi_kendaraan,
a.nilai_asuransi, a.jml_pinjaman, a.jml_angsuran,  CEIL(a.`JML_ANGSURAN`/12) AS jml_angsuran_tahun, a.premi, b.agunan_id , a.nilai_taksasi_agunan,
b.nilai_taksasi_detail, b.jenis, b.kd_jenis, b.kd_merk_old,
b.nama_bpkb, b.alamat_bpkb, b.keterangan, b.nama_pemilik_sertifikat, b.alamat_sertifikat
FROM $dpm_online.$table_kredit  AS a
INNER JOIN $dpm_online.$table_jaminan_dokument AS b
	ON (a.agunan_id1 = b.agunan_id OR a.agunan_id2 = b.agunan_id OR a.agunan_id3 = b.agunan_id OR a.agunan_id4 = b.agunan_id OR a.agunan_id5 = b.agunan_id)
INNER JOIN $dpm_online.$table_nasabah AS c ON a.nasabah_id = c.nasabah_id
INNER JOIN $dpm_online.$table_kre_kode_asuransi AS d ON a.kode_asuransi = d.kode_asuransi
WHERE a.pokok_saldo_akhir <> 0 AND a.kode_asuransi IN ($kode_asuransi_jaminan)
AND a.tgl_realisasi = '$tanggal_realisasi' $paramater_kantor
AND (a.no_rekening like '$keyword%' or c.nama_nasabah like '%$keyword%')
AND a.no_rekening NOT IN (SELECT no_rekening FROM $DB.$table_cover_jaminan)
ORDER BY $sort $order $limit";

if (count($query) > 0){
    if (mysqli_multi_query($KONEKSI, join(";",$query))){
        do{
             if ($rs = mysqli_store_result($KONEKSI)){
                while ($row = mysqli_fetch_assoc($rs)) {
                   if(isset($row['total'])) {
                        $result['total']=$row['total'];
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
