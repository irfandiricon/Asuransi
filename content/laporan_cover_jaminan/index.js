$(function(){
    $('#tipe').hide();
    $('#kode_asuransi').combobox({
        url : 'content/master/master_data_vendor_jaminan.php',
        width : '100%',
        panelHeight:'auto',
        valueField:'kode_asuransi',
        textField:'deskripsi_asuransi',
        method : 'POST',
        queryParams : {
            addSemua : '1'
        }
    });

    $('#jenis').combobox({
        url : 'content/master/master_data_jaminan.php',
        width : '100%',
        panelHeight:'auto',
        valueField:'id',
        textField:'jenis',
        method : 'POST',
        onChange : function(){
            SetTipeJaminan();
        }
    });

    $('#tipe_kendaraan').combobox({
        url : 'content/master/master_data_tipe_kendaraan.php',
        width : '300',
        panelHeight:'auto',
        valueField:'id',
        textField:'tipe',
        method : 'POST'
    });

    $('#periode_awal').datebox({
        formatter : myformatter,
        parser : myparser,
        width : '90%'
    });

    $('#periode_akhir').datebox({
        formatter : myformatter,
        parser : myparser,
        width : '90%'
    });
});

function SetTipeJaminan(){
    var jenis = $('#jenis').combobox('getValue') || {};
    if(jenis=="BPKB"){
        $('#tipe').show();
    }else{
        $('#tipe').hide();
    }
}

function ProsesCetakLaporanJaminan(){
    var data = $('#FormLaporanCoverJaminan').serialize();
    var kode_asuransi = $('#kode_asuransi').combobox('getValue');
    var jenis = $('#jenis').combobox('getValue');
    var tipe = $('#tipe_kendaraan').combobox('getValue');
    //var status = document.getElementById("export").checked;

    if(kode_asuransi==""){
        $.messager.alert('INFORMASI','SILAHKAN PILIH NAMA ASURANSI');
        return;
    }else if(jenis==""){
        $.messager.alert('INFORMASI','SILAHKAN PILIH JENIS JAMINAN');
        return;
    }else if(jenis=="BPKB" && tipe==""){
        $.messager.alert('INFORMASI','SILAHKAN PILIH TIPE KENDARAAN');
        return;
    }

    if(jenis=="SERTIFIKAT"){
        file = "report/laporan_cover_jaminan_kebakaran.php";
    }else if(jenis=="BPKB"){
        if(tipe=="MOTOR"){
            file = "report/laporan_cover_jaminan_kendaraan_motor.php";
        }else{
            file = "report/laporan_cover_jaminan_kendaraan_mobil.php";
        }
    }

    $('#FormLaporanCoverJaminan').form('submit',{
        url : file,
        onSubmit:function(){
            return $(this).form('enableValidation').form('validate');
        },
        success : function (data){
            alert(data);
        }
    });

}
