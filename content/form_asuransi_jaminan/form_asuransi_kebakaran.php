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
                            <input readonly class="easyui-numberbox" id="nilai_premi_kebakaran" name="nilai_premi_kebakaran" data-options="precision:2,groupSeparator:','">
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
                            <input readonly class="easyui-textbox" id="nama_pemilik_sertifikat" name="nama_pemilik_sertifikat">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Alamat</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="alamat_sertifikat" name="alamat_sertifikat" data-options="multiline:true, height:80">
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
                          <b>Data Okupasi</b>
                      </div>
                      <div class="col-lg-7">
                          <input class="easyui-textbox" id="okupasi" name="okupasi">
                          <input type="hidden" class="easyui-textbox" id="id_okupasi" name="id_okupasi">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-5">
                          <b>Pertanggungan</b>
                      </div>
                      <div class="col-lg-7">
                          <input readonly class="easyui-numberbox" id="nilai_asuransi" name="nilai_asuransi" data-options="precision:2,groupSeparator:','">
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
                          <input readonly class="easyui-numberbox" id="nilai_premi" name="nilai_premi" data-options="precision:2,groupSeparator:','">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-5">
                          <b>Selisih</b>
                      </div>
                      <div class="col-lg-7">
                          <input readonly class="easyui-numberbox" id="selisih" name="selisih" data-options="precision:2,groupSeparator:','">
                      </div>
                  </div>
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
        var rows = $('#dg_nasabah_jaminan').datagrid('getSelected') || {};
        var kode_asuransi = rows.kode_asuransi;
        $('#okupasi').combobox({
            url:'content/master/master_data_okupasi.php',
            valueField : 'id',
            textField : 'deskripsi_okupasi',
            panelHeight: 200,
            queryParams : {
                addSemua : '1',
                kode_asuransi : kode_asuransi
            },
            method : 'post',
            onChange : function(rows){
                $('#id_okupasi').textbox('setValue',rows);
                getRateOkupasi(rows);
            }
        });
    });
</script>
<style>
    .row{
        padding : 5px;
    }
</style>
