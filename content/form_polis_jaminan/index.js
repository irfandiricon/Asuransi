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
        title : 'FORM POLIS JAMINAN',
        fitColumns : true,
        url : "content/form_polis_jaminan/master_data_nasabah.php",
        height : hTbl,
        method:'post',
        queryParams : {
            kode_kantor : kode_kantor,
            jabatan : jabatan,
            divisi_id : divisi_id,
            group_menu : group_menu,
            username : username,
            user_id : user_id,
            kode_area : kode_area
        },
        rownumbers:true,
        singleSelect : true,
        columns:[[
            {field:'id_polis',title:'<span style="font-weight:bold">NO POLIS</span>',width : 150,sortable:true},
            {field:'tgl_realisasi',title:'<span style="font-weight:bold">TGL REALISASI</span>',width : 150,sortable:true},
            {field:'no_rekening',title:'<span style="font-weight:bold">NO REKENING</span>',width : 150,sortable:true},
            {field:'nama_nasabah',title:'<span style="font-weight:bold">NAMA NASABAH</span>',width : 250,sortable:true},
            {field:'status_endorsement',title:'<span style="font-weight:bold">ENDORSEMENT</span>',width : 150,sortable:true},
            {field:'deskripsi_asuransi',title:'<span style="font-weight:bold">NAMA ASURANSI</span>',width : 150,sortable:true},
        ]],
        striped : true,
        pagination:true,
        pageSize:20,
        onDblClickRow : function(){
            ProsesPolisJaminan();
        },
        toolbar : [{
            text:'Proses Data',
            iconCls:'icon-save',
            handler:function(){
                ProsesPolisJaminan();
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
    $('<td><label>Periode</label>&nbsp;&nbsp;&nbsp;<input id="tgl_cover" name="tgl_cover"></td>')
    .css({'float' : 'right','display':'inline-block','padding-left':'.5em'}).appendTo($classToolbarGrid);

    $('#keyword').searchbox({
        searcher : doSearch,
        prompt : "NO REKENING / NAMA NASABAH",
        width : 250,
        height : 30
    });

    $('#tgl_cover').val("<?php echo date('Y-m')?>").datebox({
        parser : myparsermonth,
        formatter : myformattermonth,
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
    var tgl_cover = $('#tgl_cover').datebox('getValue');
    var keyword = $('#keyword').textbox('getValue');

    var data = {
        kode_kantor : kode_kantor,
        jabatan : jabatan,
        divisi_id : divisi_id,
        group_menu : group_menu,
        username : username,
        user_id : user_id,
        kode_area : kode_area,
        tgl_cover : tgl_cover,
        keyword : keyword
    }
    $('#dg_nasabah_jaminan').datagrid('load', data);
}

function ProsesPolisJaminan(){
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
    }

    $('body').find('#form_polis_jaminan').remove();
    $('<div/>').attr('id','form_polis_jaminan').appendTo($('body')).dialog({
        href : 'content/form_polis_jaminan/form_polis_jaminan.php',
        width : 800,
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
                ProsesSimpanPolisJaminan();
            }
        },{
            text:'Batal',
            iconCls:'icon-cancel',
            handler:function(){
                $('#form_polis_jaminan').dialog('close').dialog('destroy');
            }
        }]
    });
}

function ProsesSimpanPolisJaminan(){
    var id = $('#id').val();
    var id_polis = $('#id_polis').numberbox('getValue');
    var no_rekening = $('#no_rekening').textbox('getValue');
    var agunan_id = $('#agunan_id').val();
    var tanggal_awal_polis = $('#tgl_realisasi').datebox('getValue');
    var tanggal_akhir_polis = $('#tgl_jatuh_tempo').datebox('getValue');
    var status = $('#status_endorsement').is(":checked");
    var created_by = localStorage.getItem('USER_ID');

    if(id_polis == ""){
        $.messager.alert('INFORMASI','SILAHKAN MASUKAN NO POLIS !!!');
        return;
    }
    if(status==true){
        status_endorsement = 1;
    }else if(status==false){
        status_endorsement = 0;
    }

    var data = {
        id : id,
        id_polis : id_polis,
        no_rekening : no_rekening,
        agunan_id : agunan_id,
        jenis_asuransi : '1',
        tanggal_awal_polis : tanggal_awal_polis,
        tanggal_akhir_polis : tanggal_akhir_polis,
        status_endorsement : status_endorsement,
        created_by : created_by
    }
    $.ajax({
        url : 'content/__proses/simpan_polis_jaminan.php',
        data : data,
        cahce : false,
        type : 'post',
        dataType : 'json',
        success : function(row){
          $.messager.alert('INFORMASI',JSON.stringify(row));
          $('#form_polis_jaminan').dialog('close').dialog('destroy');
          $('#dg_nasabah_jaminan').datagrid('load');
        }
    });
}
