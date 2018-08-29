<form id="form_jiwa" name="form_jiwa" style="overflow:hidden" method="post" enctype="multipart/form-data">
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
                            <input readonly class="easyui-numberbox" id="nilai_premi_jiwa" name="nilai_premi_jiwa" data-options="precision:2,groupSeparator:','">
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
                            <input readonly class="easyui-textbox" id="nama_jaminan" name="nama_jaminan">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <b>Alamat</b>
                        </div>
                        <div class="col-lg-7">
                            <input readonly class="easyui-textbox" id="alamat_jaminan" name="alamat_jaminan" data-options="multiline:true, height:80">
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
                          <b>Tinggi Badan</b>
                      </div>
                      <div class="col-lg-7">
                          <input class="easyui-numberbox" id="tinggi_asuransi_jiwa" name="tinggi_asuransi_jiwa">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-5">
                          <b>Berat Badan</b>
                      </div>
                      <div class="col-lg-7">
                          <input class="easyui-numberbox" id="berat_asuransi_jiwa" name="berat_asuransi_jiwa">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-5">
                          <b>Rate</b>
                      </div>
                      <div class="col-lg-7">
                          <input readonly class="easyui-textbox" id="rate" name="rate" >
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-5">
                          <b>Extra Premi</b>
                      </div>
                      <div class="col-lg-7">
                          <input id="extra_premi" value="1" type="checkbox" onchange="ExtraPremi()">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-5">
                          <b>Premi</b>
                      </div>
                      <div class="col-lg-7">
                          <input readonly class="easyui-numberbox" value="0" id="nilai_premi" name="nilai_premi" data-options="precision:2,groupSeparator:','">
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-5">
                          <b>Selisih</b>
                      </div>
                      <div class="col-lg-7">
                          <input readonly class="easyui-numberbox" value="0" id="selisih" name="selisih" data-options="precision:2,groupSeparator:','">
                      </div>
                  </div>
                  <div class="row" id="form_spa">
                      <div class="col-lg-5">
                          <b>File SPA / SPAJK</b>
                      </div>
                      <div class="col-lg-7">
                          <input required name="file_spa" id="file_spa" class="easyui-filebox">
                      </div>
                  </div>
                  <div class="row" id="form_ktp">
                      <div class="col-lg-5">
                          <b>File KTP</b>
                      </div>
                      <div class="col-lg-7">
                          <input required name="file_ktp" id="file_ktp" class="f1 easyui-filebox">
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</form>

<script>
onLoad = {
    form:function (row){
        $('#form_jiwa')
            .append('<input type="hidden" name="kode_kantor" value="'+row.kode_kantor+'"/>')
            .append('<input type="hidden" name="kode_asuransi_jiwa" value="'+row.kode_asuransi_jiwa+'"/>')
            .append('<input type="hidden" name="jenis_kelamin" value="'+row.jenis_kelamin+'"/>')
            .append('<input type="hidden" name="nama_user" value="'+localStorage.getItem('NAMA')+'"/>')
            .append('<input type="hidden" name="created_by" value="'+localStorage.getItem('USER_ID')+'"/>');
    }
}
</script>
<style>
    .row{
        padding : 5px;
    }
</style>
