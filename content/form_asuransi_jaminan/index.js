$(function(){
    var hTbl = parseInt($(window).innerHeight())-parseInt($('.navbar-fixed-top').height())-parseInt($('.navbar-fixed-bottom').height())-50;
    var kode_area = localStorage.getItem('KODE_AREA');
    var username = localStorage.getItem('USERNAME');
    var jabatan = localStorage.getItem('JABATAN');
    var group_menu = localStorage.getItem('GROUP_MENU');
    var kode_kantor = localStorage.getItem('KODE_KANTOR');
    var user_id = localStorage.getItem('USER_ID');
    var divisi_id = localStorage.getItem('DIVISI_ID');
    var koneksi = localStorage.getItem('KONEKSI');

    if(koneksi=="local"){
        host = "http://localhost:9999";
    }else{
        host = "http://103.234.254.186:9999";
    }

    $('#dg_nasabah_jaminan').datagrid({
        title : 'FORM ASURANSI JAMINAN',
        fitColumns : true,
        url : "content/form_asuransi_jaminan/master_data_nasabah.php",
        height : hTbl,
        method:'post',
        queryParams : {
            kode_kantor : kode_kantor,
            jabatan : jabatan,
            divisi_id : divisi_id,
            group_menu : group_menu,
            usernname : username,
            user_id : user_id,
            kode_area : kode_area
        },
        rownumbers:true,
        singleSelect : true,
        columns:[[
            {field:'tgl_realisasi',title:'<span style="font-weight:bold">TGL REALISASI</span>',width : 150,sortable:true},
            {field:'no_rekening',title:'<span style="font-weight:bold">NO REKENING</span>',width : 150,sortable:true},
            {field:'nama_nasabah',title:'<span style="font-weight:bold">NAMA NASABAH</span>',width : 250,sortable:true},
            {field:'jenis',title:'<span style="font-weight:bold">JAMINAN</span>',width : 150,sortable:true},
            {field:'deskripsi_asuransi',title:'<span style="font-weight:bold">NAMA ASURANSI</span>',width : 150,sortable:true},
        ]],
        striped : true,
        pagination:true,
        pageSize:20,
        onDblClickRow : function(){
            ProsesDataJaminan();
        },
        toolbar : [{
            text:'Proses Data',
            iconCls:'icon-save',
            handler:function(){
                ProsesDataJaminan();
            }
        }],
        onLoadSuccess : function(data){
            //console.log(JSON.stringify(data));
        }
    });

    $classToolbarGrid = $('.datagrid-toolbar table tbody tr');

    $classToolbarGrid.find('td').css('display','inline-block');
    $classToolbarGrid.parent().parent().css('width','100%');
    $('<td><label>Kata Kunci</label>&nbsp;&nbsp;&nbsp;<input id="keyword" name="keyword"></td>')
    .css({'float' : 'right','display':'inline-block','padding-left':'.5em'}).appendTo($classToolbarGrid);
    $('<td><label>Tgl Realisasi</label>&nbsp;&nbsp;&nbsp;<input id="tgl_realisasi" name="tgl_realisasi"></td>')
    .css({'float' : 'right','display':'inline-block','padding-left':'.5em'}).appendTo($classToolbarGrid);

    $('#keyword').searchbox({
        searcher : doSearch,
        prompt : "NO REKENING / NAMA NASABAH",
        width : 250,
        height : 30
    });

    $('#tgl_realisasi').val("<?php echo date('Y-m-d')?>").datebox({
        parser : myparser,
        formatter : myformatter,
        height : 30,
        width : 150,
        onChange : doSearch
    });
});

function doSearch(){
    var kode_area = localStorage.getItem('KODE_AREA');
    var username = localStorage.getItem('USERNAME');
    var jabatan = localStorage.getItem('JABATAN');
    var group_menu = localStorage.getItem('GROUP_MENU');
    var kode_kantor = localStorage.getItem('KODE_KANTOR');
    var user_id = localStorage.getItem('USER_ID');
    var divisi_id = localStorage.getItem('DIVISI_ID');
    var tgl_realisasi = $('#tgl_realisasi').datebox('getValue');
    var keyword = $('#keyword').textbox('getValue');

    var data = {
        kode_kantor : kode_kantor,
        jabatan : jabatan,
        divisi_id : divisi_id,
        group_menu : group_menu,
        usernname : username,
        user_id : user_id,
        kode_area : kode_area,
        tgl_realisasi : tgl_realisasi,
        keyword : keyword
    }
    $('#dg_nasabah_jaminan').datagrid('load', data);
}

function ProsesDataJaminan(){
    var hTbl = parseInt($(window).innerHeight())-40;
    var rowSelected = $('#dg_nasabah_jaminan').datagrid('getSelected') || {};
    var no_rekening = rowSelected.no_rekening;
    var nama_nasabah = rowSelected.nama_nasabah;
    var kode_asuransi = rowSelected.kode_asuransi;
    var jaminan = rowSelected.jenis;
    var jenis_kendaraan = rowSelected.kd_jenis;

    if(no_rekening==undefined){
        $.messager.alert('INFORMASI','SILAHKAN PILIH DATA');
        return;
    }else if (jaminan=="SERTIFIKAT"){
        var file = "content/form_asuransi_jaminan/form_asuransi_kebakaran.php";
    }else if (jaminan=="BPKB"){
        if ($.inArray(jenis_kendaraan,["MT","SM","SPD M"]) >= 0){
            var file = "content/form_asuransi_jaminan/form_asuransi_kendaraan_motor.php";
        }else{
            var file = "content/form_asuransi_jaminan/form_asuransi_kendaraan_mobil.php";
        }
    }else{
        $.messager.alert('INFORMASI','MAAF DATA BELUM TERSEDIA');
        return;
    }

    $('body').find('#form_data_jaminan').remove();
    $('<div/>').attr('id','form_data_jaminan').appendTo($('body')).dialog({
        href : file,
        width : 1200,
        height : hTbl,
        top : 15,
        position : 'center',
        title : "Data Asuransi Jaminan ( "+no_rekening+" - "+nama_nasabah+"  )",
        modal:true,
        method : 'POST',
        onBeforeLoad : function (){
            try {
                delete onLoad.form;
            }catch(e){}
        },
        onLoad : function (){
            var $this=$(this).find('form');
            try{
                $this.form('load',rowSelected);
                onLoad.form(rowSelected);
            }catch(e){}
            $('#btn_data').linkbutton('disable',true);
        },
        buttons: [{
            text:'Simpan',
            iconCls:'icon-save',
            id : 'prosesSimpanJaminan',
            handler:function(){
                ProsesSimpanJaminan();
            }
        },{
            text:'Batal',
            iconCls:'icon-cancel',
            handler:function(){
                $('#form_data_jaminan').dialog('close').dialog('destroy');
            }
        }]
    });
}


function getRateOkupasi(id){
  var data = {
      id : id
  }
    $.ajax({
        url : 'content/master/master_data_rate_okupasi.php',
        data : data,
        cache : false,
        type : 'POST',
        dataType : 'json',
        success : function(data){
            //console.log(JSON.stringify(data));
            $('#rate').textbox('setValue', data.rate);
            HitungRateJaminan();
        }
    });
}

function HitungRateJaminan(){
    var rows = $('#dg_nasabah_jaminan').datagrid('getSelected') || {};
    var jenis = rows.jenis;
    var nilai_pertanggungan = rows.nilai_asuransi;
    var rate = $('#rate').textbox('getValue');
    var tgl_realisasi = rows.tgl_realisasi;
    var tgl_jatuh_tempo = rows.tgl_jatuh_tempo;
    var tanggal_realisasi = tgl_realisasi.substring(8);
    var oneDay = 24*60*60*1000;
		var firstDate = new Date(tgl_realisasi);
		var secondDate = new Date(tgl_jatuh_tempo);
		var jumlah_hari = Math.round(Math.round((secondDate.getTime() - firstDate.getTime()) / (oneDay)));
    var lama_cover = Math.ceil(rows.jml_angsuran/12);
    var jenis_kendaraan = rows.kd_jenis;
    var biaya_polis = 50000;

    if(jenis=="BPKB"){
        if ($.inArray(jenis_kendaraan,["MT","SM","SPD M"]) >= 0){
            if(tgl_realisasi > 25){
                var premi = Math.round((nilai_pertanggungan*rate/100) * (jumlah_hari));
            }else{
                var premi = Math.round(lama_cover*nilai_pertanggungan*rate/100);
            }
            var titipan_asuransi = premi + biaya_polis;
        }else{
            if(tgl_realisasi > 25){
                var premi = Math.round((nilai_pertanggungan*rate/1000) * (jumlah_hari/365));
            }else{
                var premi = Math.round(lama_cover*nilai_pertanggungan*rate/1000);
            }
            var titipan_asuransi = premi + biaya_polis;
        }
        var nilai_titipan = rows.nilai_premi_kendaraan;
    }else{
        if(tanggal_realisasi > 25){
            var premi = Math.round((nilai_pertanggungan*rate/1000)*(jumlah_hari/365));
        }else{
            var premi = Math.round(lama_cover*nilai_pertanggungan*rate/1000);
        }
        var titipan_asuransi = premi + biaya_polis;
        var nilai_titipan = rows.nilai_premi_kebakaran;
    }

    var str_premi = titipan_asuransi.toString().substr(-3);

    if (str_premi==0){
        var nilai_bulat_500 = 0;
        var nilai_bulat_1000 = 0;
    }else{
        var nilai_bulat_500 = 500;
        var nilai_bulat_1000 = 1000;
    }

    if (str_premi <= nilai_bulat_500) {
        var nilai_awal=nilai_bulat_500-str_premi;
        var nilai_premi=titipan_asuransi+nilai_awal;
    }
    if (str_premi <= nilai_bulat_1000 && str_premi > nilai_bulat_500){
        var nilai_awal=nilai_bulat_1000-str_premi;
        var nilai_premi=titipan_asuransi+nilai_awal;
    }

    var selisih = nilai_titipan - nilai_premi;
    $('#nilai_premi').numberbox('setValue',nilai_premi);
    $('#selisih').numberbox('setValue',selisih);
}

function KategoriJaminan(){
    var rows = $('#dg_nasabah_jaminan').datagrid('getSelected') || {};
    var kategori = $('#kategori').combobox('getValue');
    if(kategori==""){
        $.messager.alert('INFORMASI','PILIH DATA KATEGORI KENDARAAN');
        $('#kategori_jaminan').hide();
        return;
    }
    var data = {
        id_kategori : kategori,
        rows : rows
    }

    $.ajax({
        type : 'POST',
        url : 'content/form_asuransi_jaminan/form_asuransi_kategori_mobil.php',
        data : data,
        cache : false,
        success : function(result){
            $('#kategori_jaminan').show();
            $('#kategori_jaminan').html(result);
        }
    });
}

function ProsesSimpanJaminan(){
    $('#prosesSimpanJaminan').linkbutton('disable',true);
    var rows = $('#dg_nasabah_jaminan').datagrid('getSelected') || {};
    var jenis = rows.jenis;
    if(jenis=="SERTIFIKAT"){
        var okupasi = $('#id_okupasi').textbox('getValue');
        if(okupasi==""){
            $.messager.alert('Informasi', 'PILIH DATA OKUPASI');
            $('#nilai_premi').numberbox('setValue','');
            $('#selisih').numberbox('setValue','');
            return;
        }
    }

    $('#form_jaminan').form('submit',{
        url : "content/__proses/simpan_cover_jaminan.php",
        onSubmit:function(){
            return $(this).form('enableValidation').form('validate');
        },
        success : function (data){
            var pesan = data;
            $('#form_data_jaminan').dialog('close').dialog('destroy');
            $.messager.alert('Informasi', JSON.parse(JSON.stringify(pesan)));
            //console.log(JSON.parse(JSON.stringify(data)));
            $('#dg_nasabah_jaminan').datagrid('load');
        }
    });
}
