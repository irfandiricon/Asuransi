<form id="form_polis_jaminan" name="form_polis_jaminan" style="overflow:hidden" method="post" enctype="multipart/form-data">
    <div class="panel panel-default panel-heading" style="background:#9b8d8d;">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default panel-heading" style="padding-bottom:50px;">
                    <font size="5"><b>Data Nasabah</b></font>
                    <hr width="100%">
                    <div class="row">
                        <div class="col-lg-5">
                            <b>No. Rekening</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="no_rekening" name="no_rekening">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Nama Nasabah</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="nama_nasabah" name="nama_nasabah">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Tempat Lahir</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="tempatlahir" name="tempatlahir">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Tanggal Lahir</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-datebox" id="tgllahir" name="tgllahir" data-options="formatter:myformatter,parser:myparser">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Telepon</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="telpon" name="telpon">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Alamat</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="alamat" name="alamat" data-options="multiline:true, height:80">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Nama Jaminan</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="nama_jaminan" name="nama_jaminan">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Alamat Jaminan</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="alamat_jaminan" name="alamat_jaminan" data-options="multiline:true, height:80">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default panel-heading" style="padding-bottom:50px;">
                    <font size="5"><b>Data Kredit Nasabah</b></font>
                    <hr width="100%">
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Tgl Realisasi</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-datebox" id="tgl_realisasi" name="tgl_realisasi" data-options="formatter:myformatter,parser:myparser">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Tgl JT Tempo</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-datebox" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" data-options="formatter:myformatter,parser:myparser">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Plafon</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-numberbox" id="jml_pinjaman" name="jml_pinjaman" data-options="precision:2,groupSeparator:','">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Lama Cover (M)</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="jml_angsuran" name="jml_angsuran">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Rate</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="rate" name="rate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Premi</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-numberbox" id="titipan_asuransi" name="titipan_asuransi" data-options="precision:2,groupSeparator:','">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>No Polis</b>
                        </div>
                        <div class="col-lg-7">
                            <input required class="easyui-numberbox" id="id_polis" name="id_polis">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Status</b>
                        </div>
                        <div class="col-lg-7">
                            <input type="checkbox" id="status_endorsement" name="status_endorsement">&nbsp;
                            <font size="4"><b>Endorsement</b></font>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
onLoad = {
    form : function(row){
      $('#form_polis_jaminan')
          .append('<input type="hidden" name="id" id="id" value="'+row.id+'"/>')
          .append('<input type="hidden" name="agunan_id" id="agunan_id" value="'+row.agunan_id+'"/>')
          .append('<input type="hidden" name="created_by" value="'+localStorage.getItem('USER_ID')+'"/>');
    }
}
</script>
<style>
    .row{
        padding : 5px;
    }
</style>
