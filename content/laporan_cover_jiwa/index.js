$(function(){
    $('#kategori_asuransi').hide();
    $('#kode_asuransi').combobox({
        url : 'content/master/master_data_vendor_jiwa.php',
        width : '100%',
        panelHeight:'auto',
        valueField:'kode_asuransi',
        textField:'deskripsi_asuransi',
        method : 'POST',
        queryParams : {
            addSemua : '1'
        },
        onChange : function(){
            SetKategoriAsuransi();
        }
    });

    $('#kategori').combobox({
        url : 'content/master/master_data_kategori_jiwa.php',
        width : '300',
        panelHeight:'auto',
        valueField:'id',
        textField:'tipe',
        method : 'POST'
    });

    $('#periode_awal').datebox({
        formatter : myformattermonth,
        parser : myparsermonth,
        width : '100%'
    });
});

function SetKategoriAsuransi(){
    var kode_asuransi = $('#kode_asuransi').combobox('getValue');
    if(kode_asuransi=="005"){
        $('#kategori_asuransi').show();
    }else{
        $('#kategori_asuransi').hide();
    }
}
function ProsesCetakLaporanJiwa(){
    var kode_asuransi = $('#kode_asuransi').combobox('getValue');
    var periode_awal = $('#periode_awal').datebox('getValue');

    if(kode_asuransi==""){
        $.messager.alert('INFORMASI','SILAHKAN PILIH NAMA ASURANSI');
        return;
    }else if(kode_asuransi=="005"){
        var kategori = $('#kategori').combobox('getValue');
        if(kategori == ""){
            $.messager.alert('INFORMASI','SILAHKAN PILIH KATEGORI');
            return;
        }else{
            var file = "report/laporan_cover_jiwa_sinarmas.php";
        }
    }else if(kode_asuransi=="007"){
        var file = "report/laporan_cover_jiwa_jiwasraya.php";
    }

    $('#FormLaporanCoverJiwa').form('submit',{
        url : file,
        onSubmit:function(){
            return $(this).form('enableValidation').form('validate');
        },
        success : function (data){
            alert(data);
        }
    });

}
