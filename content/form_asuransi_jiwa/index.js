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

    $('#dg_nasabah_jiwa').datagrid({
        title : 'FORM ASURANSI JIWA',
        fitColumns : true,
        url : "content/form_asuransi_jiwa/master_data_nasabah.php",
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
            {field:'no_rekening',title:'<span style="font-weight:bold">NO REKENING</span>',width:150,sortable:true},
            {field:'nama_nasabah',title:'<span style="font-weight:bold">NAMA NASABAH</span>',width:250,sortable:true},
            {field:'jenis',title:'<span style="font-weight:bold">JAMINAN</span>',width:150,sortable:true},
            {field:'deskripsi_asuransi',title:'<span style="font-weight:bold">NAMA ASURANSI</span>',width:150,sortable:true},
        ]],
        striped : true,
        pagination:true,
        pageSize:20,
        onDblClickRow : function(){
            ProsesDataJiwa();
        },
        toolbar : [{
            text:'Proses Data',
            iconCls:'icon-save',
            handler:function(){
                ProsesDataJiwa();
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
    $('#dg_nasabah_jiwa').datagrid('load', data);
}

function ProsesDataJiwa(){
    var hTbl = parseInt($(window).innerHeight())-40;
    var rows = $('#dg_nasabah_jiwa').datagrid('getSelected') || {};
    var no_rekening = rows.no_rekening;
    var nama_nasabah = rows.nama_nasabah;
    var kode_asuransi_jiwa = rows.kode_asuransi_jiwa;

    if(no_rekening==undefined){
        $.messager.alert('INFORMASI','SILAHKAN PILIH DATA');
        return;
    }
    if(kode_asuransi_jiwa == "005"){
        var file = "content/form_asuransi_jiwa/form_asuransi_jiwa_sinarmas.php";
    }else if(kode_asuransi_jiwa == "007"){
        var file = "content/form_asuransi_jiwa/form_asuransi_jiwa_jiwasraya.php";
    }else{
        $.messager.alert('INFORMASI','MAAF, BELUM TERSEDIA !!!');
        return;
    }

    $('body').find('#form_data_jiwa').remove();
    $('<div/>').attr('id','form_data_jiwa').appendTo($('body')).dialog({
        href : file,
        width : 1200,
        height : hTbl,
        top : 15,
        position : 'center',
        title : "Data Asuransi Jiwa ( "+no_rekening+" - "+nama_nasabah+"  )",
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
                $this.form('load',rows);
                onLoad.form(rows);
            }catch(e){}
            if(kode_asuransi_jiwa == "005"){
                PerhitunganSinarmas();
            }else if(kode_asuransi_jiwa == "007"){
                PerhitunganJiwasraya();
            }
        },
        buttons: [{
            text:'Simpan',
            iconCls:'icon-save',
            id : 'prosesSimpanJiwa',
            handler:function(){
                ProsesSimpanJiwa();
            }
        },{
            text:'Batal',
            iconCls:'icon-cancel',
            handler:function(){
                $('#form_data_jiwa').dialog('close').dialog('destroy');
            }
        }]
    });
}

function PerhitunganJiwasraya(){
    var rows = $('#dg_nasabah_jiwa').datagrid('getSelected') || {};
    var no_rekening = rows.no_rekening;
    if(no_rekening == undefined){
        $.messager.alert('INFORMASI','SILAHKAN PILIH DATA');
        return;
    }
    var data = {
        rows : rows
    }
    $.ajax({
        url : "content/form_asuransi_jiwa/get_data_perhitungan_jiwasraya.php",
        cache : false,
        type : 'POST',
        data : data,
        dataType : 'json',
        success : function(result){
            var rate = result.rate;
            var premi = result.premi;
            var selisih = result.selisih;
            $('#rate').textbox('setValue', rate);
            $('#nilai_premi').numberbox('setValue',premi);
            $('#selisih').numberbox('setValue',selisih);
            //console.log(JSON.stringify(result));
            //$.messager.alert('INFORMASI', result);
        }
    });
}

function PerhitunganSinarmas(){
    var rows = $('#dg_nasabah_jiwa').datagrid('getSelected') || {};
    var no_rekening = rows.no_rekening;
    if(no_rekening == undefined){
        $.messager.alert('INFORMASI','SILAHKAN PILIH DATA');
        return;
    }
    var data = {
        rows : rows
    }
    $.ajax({
        url : "content/form_asuransi_jiwa/get_data_perhitungan_sinarmas.php",
        cache : false,
        type : 'POST',
        data : data,
        dataType : 'json',
        success : function(result){
            var rate = result.rate;
            var premi = result.premi;
            var selisih = result.selisih;
            $('#rate').textbox('setValue', rate);
            $('#nilai_premi').numberbox('setValue',premi);
            $('#selisih').numberbox('setValue',selisih);
            //console.log(JSON.stringify(result));
            //$.messager.alert('INFORMASI', result);
        }
    });
}

function ExtraPremi(){
    var extra_premi = $("#extra_premi:checked").val();
    var premi = $('#nilai_premi').numberbox('getValue');
    var nilai_premi_jiwa = $('#nilai_premi_jiwa').numberbox('getValue');
    if(extra_premi==1){
        var nilai_extra_premi = premi * 2;
    }else{
        var nilai_extra_premi = premi / 2;
    }
    var selisih = nilai_premi_jiwa - nilai_extra_premi;
    $('#nilai_premi').numberbox('setValue',nilai_extra_premi);
    $('#selisih').numberbox('setValue',selisih);
}

function ProsesSimpanJiwa(){
    var rows = $('#dg_nasabah_jiwa').datagrid('getSelected') || {};
    var kode_asuransi_jiwa = rows.kode_asuransi_jiwa;
    var tinggi = $('#tinggi_asuransi_jiwa').numberbox('getValue');
    var berat = $('#berat_asuransi_jiwa').numberbox('getValue');
    var file_spa = $('#file_spa').filebox('getValue');

    if(tinggi==0 || berat==0){
        $.messager.alert('Informasi', "Masukan Data Tinggi & Berat Badan");
        return;
    }else if(kode_asuransi_jiwa == "007"){
        var file_ktp = $('#file_ktp').filebox('getValue');
        if(file_spa=="" || file_spa==null){
            $.messager.alert('Informasi', "Masukan File Lampiran SPA/SPAJK ");
            return;
        }else if(file_ktp=="" || file_ktp==null){
            $.messager.alert('Informasi', "Masukan File Lampiran KTP");
            return;
        }
    }else if(kode_asuransi_jiwa == "005"){
        if(file_spa=="" || file_spa==null){
            $.messager.alert('Informasi', "Masukan File Lampiran SPA/SPAJK ");
            return;
        }
    }else{
        $('#prosesSimpanJiwa').linkbutton('disable',true);
    }

    $('#form_jiwa').form('submit',{
        url : "content/__proses/simpan_cover_jiwa.php",
        onSubmit:function(){
            return $(this).form('enableValidation').form('validate');
        },
        success : function (data){
            var pesan = data;
            $('#form_data_jiwa').dialog('close').dialog('destroy');
            $.messager.alert('Informasi', JSON.parse(JSON.stringify(pesan)));
            //console.log(JSON.parse(JSON.stringify(data)));
            $('#dg_nasabah_jiwa').datagrid('load');
        }
    });
}
