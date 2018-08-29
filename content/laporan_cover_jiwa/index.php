<script src="content/laporan_cover_jiwa/index.js"></script>
<div class="rows" style="padding-top:20px;">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form method="POST" id="FormLaporanCoverJiwa" name="FormLaporanCoverJiwa">
        <?php
        // session_start();
        // echo json_encode($_SESSION);
        ?>
        <div class="panel panel-default panel-heading" style="background:#efefef">
            <div class="row" align="center">
                <div class="col-md-12">
                    <font size="5"><b>Parameter Cetak</b></font>
                </div>
            </div>
            <hr align="center" width="100%" style="background:red;color:red;">
            <div class="row">
                <div class="col-md-4">
                    <b>Nama Asuransi</b>
                </div>
                <div class="col-md-8">
                    <input id="kode_asuransi" name="kode_asuransi">
                </div>
            </div>
            <div class="row" id="kategori_asuransi">
                <div class="col-md-4">
                    <b>Kategori</b>
                </div>
                <div class="col-md-8">
                    <input id="kategori" name="kategori">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <b>Periode Cover</b>
                </div>
                <div class="col-md-8">
                    <input id="periode_awal" name="periode_awal" value="<?php echo date('Y-m-d');?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <button class="btn btn-small btn-primary" type="button" onclick="ProsesCetakLaporanJiwa()">Cetak Data</button>
                </div>
            </div>

            <hr width="100%" align="center">
        </div>
        </form>
    </div>
</div>

<div id="report"></div>
<style>
    .row{
        padding : 5px;
    }
</style>
