<?php
    include "../../koneksi_db/Koneksi.php";
    $table_rate_jaminan_bus_truck_pickup =  TABLE_RATE_JAMINAN_BUS_TRUCK_PICKUP;
    $table_rate_jaminan_non_bus_truck = TABLE_RATE_JAMINAN_NON_BUS_TRUCK;
    $table_parameter = TABLE_PARAMETER;
    $parameter_biaya_polis = PARAMETER_BIAYA_POLIS;
    $dpm_online = DB_DPM_ONLINE;

    $q3 = mysqli_query($KONEKSI,"SELECT value FROM $dpm_online.$table_parameter where id='$parameter_biaya_polis'");
    $res3 = mysqli_fetch_array($q3);
    $biaya_polis = $res3['value'];

    $no_rekening = isset($_POST['rows']['no_rekening']) ? $_POST['rows']['no_rekening']:"";
    $agunan_id = isset($_POST['rows']['agunan_id']) ? $_POST['rows']['agunan_id']:"";
    $no_rekening = isset($_POST['rows']['no_rekening']) ? $_POST['rows']['no_rekening']:"";
    $jenis = isset($_POST['rows']['jenis']) ? $_POST['rows']['jenis']:"";
    $kd_jenis = isset($_POST['rows']['kd_jenis']) ? $_POST['rows']['kd_jenis']:"";
    $nilai_premi_kebakaran = isset($_POST['rows']['nilai_premi_kebakaran']) ? $_POST['rows']['nilai_premi_kebakaran']:"";
    $nilai_premi_kendaraan = isset($_POST['rows']['nilai_premi_kendaraan']) ? $_POST['rows']['nilai_premi_kendaraan']:"";
    $kd_jenis = isset($_POST['rows']['kd_jenis']) ? $_POST['rows']['kd_jenis']:"";
    $nilai_pertanggungan = isset($_POST['rows']['nilai_taksasi_detail']) ? $_POST['rows']['nilai_taksasi_detail']:"";
    $jml_angsuran = isset($_POST['rows']['jml_angsuran']) ? $_POST['rows']['jml_angsuran']:"";

    $id_kategori = isset($_POST['id_kategori']) ? $_POST['id_kategori']:"";

    $q1 = "SELECT rate FROM $DB.$table_rate_jaminan_bus_truck_pickup where id_kategori='$id_kategori' and kd_jenis = '$kd_jenis' ";
    $ex_q1 = mysqli_query($KONEKSI,$q1);
    $total = mysqli_num_rows($ex_q1);
    $res_ex_q1 = mysqli_fetch_assoc($ex_q1);

    if($total==0){
        $q2 = "SELECT rate from $DB.$table_rate_jaminan_non_bus_truck
            where id_kategori='$id_kategori' AND '$nilai_pertanggungan' BETWEEN min_tanggungan AND max_tanggungan ";
        $ex_q2 = mysqli_query($KONEKSI, $q2);
        $res_ex_q2 = mysqli_fetch_assoc($ex_q2);
        $rate=$res_ex_q2['rate'];
    }else{
        $rate = $res_ex_q1['rate'];
    }

    if($jenis=="BPKB"){
        $nilai_premi = $nilai_premi_kendaraan;
    }else{
        $nilai_premi = $nilai_premi_kebakaran;
    }

    $kurang_pertahun=15;
    $persentase_tahun=115;
    $jumlah_tenor = ceil($jml_angsuran/12);

    $titipan_asuransi = 0;
    $titipan_asuransi_persentase = 0;
    for ($i=0;$i<$jumlah_tenor;$i++){
        $persentase_tahun -= $kurang_pertahun;
        $nilai_pertanggungan_next = $nilai_pertanggungan * ($persentase_tahun/100);
        $titipan_asuransi_persentase += $nilai_pertanggungan_next;
        $jumlah = $nilai_pertanggungan_next * ($rate/100);
        $titipan_asuransi += $jumlah;
?>
    <div class="row">
        <div class="col-lg-5">
            <b>Penyusutan / Tahun - (<?php echo $i+1;?>)</b>
        </div>
        <div class="col-lg-7">
            <input readonly id="penyusutan" name="penyusutan" value="<?php echo $persentase_tahun;?>">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <b>Nilai Pertanggungan</b>
        </div>
        <div class="col-lg-7">
            <input readonly value="<?php echo number_format($nilai_pertanggungan_next,2);?>" id="nilai_pertanggungan" name="nilai_pertanggungan" data-options="precision:2,groupSeparator:','">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <b>Rate</b>
        </div>
        <div class="col-lg-7">
            <input readonly value="<?php echo $rate;?>" id="rate" name="rate">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <b>Jumlah</b>
        </div>
        <div class="col-lg-7">
            <input readonly value="<?php echo number_format($jumlah,2);?>" id="jumlah" name="jumlah">
        </div>
    </div>
    <hr width="100%" align="center">
<?php
    }
?>
<div class="row">
    <div class="col-lg-5">
        <b>Premi</b>
    </div>
    <div class="col-lg-7">
        <input readonly value="<?php echo number_format($titipan_asuransi+$biaya_polis,2);?>" id="nilai_premi" name="nilai_premi">
    </div>
</div>
<div class="row">
    <div class="col-lg-5">
        <b>Selisih</b>
    </div>
    <div class="col-lg-7">
        <input readonly value="<?php echo number_format(($nilai_premi)-($titipan_asuransi+$biaya_polis),2);?>" id="selisih" name="selisih">
    </div>
</div>
