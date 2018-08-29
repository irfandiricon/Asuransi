<form id="form_jaminan" name="form_jaminan" style="overflow:hidden" method="post" enctype="multipart/form-data">
    <div class="panel panel-default panel-heading" style="background:#9b8d8d;">
        <div class="row">
            <div class="col-md-4">
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
                </div>
            </div>
            <div class="col-md-4">
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
                            <b>Lama Cover (M/Y)</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="jml_angsuran" name="jml_angsuran" data-options="width:50"> &nbsp; / &nbsp;
                            <input readonly class="easyui-textbox" id="jml_angsuran_tahun" name="jml_angsuran_tahun" data-options="width:50"> &nbsp;
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Nilai Titipan</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-numberbox" id="nilai_premi_kendaraan" name="nilai_premi_kendaraan" data-options="precision:2,groupSeparator:','">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Jaminan</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="jenis" name="jenis">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Atas Nama</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="nama_bpkb" name="nama_bpkb">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Alamat</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="alamat_bpkb" name="alamat_bpkb" data-options="multiline:true, height:80">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
              <div class="panel panel-default panel-heading" style="padding-bottom:50px;">
                  <font size="5"><b>Premi Asuransi</b></font>
                  <hr width="100%">
                  <div class="row">
                      <div class="col-lg-5">
                          <b>Asuransi</b>
                      </div>
                      <div class="col-lg-7">
                          <input readonly class="easyui-textbox" id="nama_asuransi" name="nama_asuransi">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-5">
                            <b>Kategori</b>
                      </div>
                      <div class="col-lg-7">
                          <input id="kategori" name="kategori">
                          <input type="hidden" class="easyui-textbox" id="nilai_asuransi" name="nilai_asuransi">
                      </div>
                  </div>
                  <div id="kategori_jaminan"></div>
              </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
onLoad = {
    form:function (row){
        $('#form_jaminan')
            .append('<input type="hidden" name="agunan_id" value="'+row.agunan_id+'"/>')
            .append('<input type="hidden" name="kode_asuransi" value="'+row.kode_asuransi+'"/>')
            .append('<input type="hidden" name="nama_user" value="'+localStorage.getItem('NAMA')+'"/>')
            .append('<input type="hidden" name="created_by" value="'+localStorage.getItem('USER_ID')+'"/>');
    }
}

    $(function (){
        $('#kategori').combobox({
            url:'content/master/master_data_kategori_mobil.php',
            valueField:'id_pertanggungan',
            textField:'nama_pertanggungan',
            panelHeight: 'auto',
            queryParams : {
                addSemua : '1',
            },
            method : 'post',
            onChange : function(){
                KategoriJaminan()
            }
        });
    });
</script>
<style>
    .row{
        padding : 5px;
    }
</style>
