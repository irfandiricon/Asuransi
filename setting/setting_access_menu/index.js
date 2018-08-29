$(function (){
    var hTbl = parseInt($(window).innerHeight())-parseInt($('.navbar-fixed-top').height())-parseInt($('.navbar-fixed-bottom').height())-50;
    $('#dg_access_menu').datagrid({
        title:'Pengaturan Akses Menu',
        singleSelect:true,
        fitColumns: true,
        pagination:true,
        height : hTbl,
        pageSize:20,
        url:'setting/master/data_user.php',
        columns:[[
            {field:'user',title:'USERNAME',width:50},
            {field:'nik',title:'NIK',width:40},
            {field:'nama',title:'NAMA USER',width:90},
            {field:'jabatan',title:'JABATAN',width:70},
            {field:'nama_kantor',title:'KANTOR CABANG / KAS',width:70}
        ]],
        rownumbers:true,
        onClickRow : function(){
            $('#btn_view_access_menu').linkbutton('enable');
        },
        onDblClickRow : function(data,rowIndex){
            addMenuAccess(rowIndex);
        },
        toolbar : '#dg_toolbar_keywoard',
        onLoadSuccess : function(data){
            //console.log($(this).datagrid('options').queryParams);
        }
    });
});

function doSearch(){
    var parameter_area_kerja = $('#parameter_area_kerja').combobox('getValue');
    var parameter_keywoard = $('#parameter_keywoard').searchbox('getValue');

    var queryParams = {
        parameter_keywoard : parameter_keywoard,
        parameter_area_kerja : parameter_area_kerja
    }
    $('#dg_access_menu').datagrid('load',queryParams);
}

function addMenuAccess(){
    var rowSelected = $('#dg_access_menu').datagrid('getSelected') || {};
    $('body').find('#addMenuAccess').remove();
    $('<div/>').attr('id','addMenuAccess').appendTo($('body')).dialog({
        href: 'setting/popup/form_access_menu.php',
        title: ' Form Access Menu',
        iconCls : "icon-add",
        width: 700,
        height: 400,
        queryParams : rowSelected,
        method : 'post',
        onBeforeLoad : function (){
          try {
              delete onLoad.form;
          } catch(e){}
        },
        onLoad : function (){
            var $this=$(this).find('form');
            try{
                $this.form('load',rowSelected);
                onLoad.form(rowSelected);
            }catch(e){}
            var $dialog=$('#addMenuAccess').next();
            $dialog.prepend('<span style="left: -175px;position:relative;color:#000;">\n\
                <b>Duplikasi &nbsp;&nbsp;<input id="duplikasi_access" name="duplikasi_access"> \n\
                <a id="btn_duplikasi_access" onClick="duplikasiWewenang()" href="javascript:void(0)">OK &nbsp;</a>\n\
            </span>');

            $('#duplikasi_access').combobox({
                url:'setting/setting_access_menu/data_user.php',
                valueField:'user_id',
                textField:'nama',
                panelHeight:'auto',
                queryParams : {
                    addSemua : '1'
                },
                method : 'post',
                onChange : function(){
                    var data_duplikasi_access=$('#duplikasi_access').combobox('getValue');
                    if(data_duplikasi_access==""){
                        $('#btn_duplikasi_access').linkbutton('disable');
                        $('#btn_update_access_menu').linkbutton('enable');
                    }else{
                        $('#btn_duplikasi_access').linkbutton('enable');
                        $('#btn_update_access_menu').linkbutton('disable');
                    }
                }
            });

            $('#btn_duplikasi_access').linkbutton({
                iconCls: 'icon-ok',
                disabled:true
            });
        },
        modal: true,
        buttons: [{
            text:'Update',
            iconCls:'icon-ok',
            id : 'btn_update_access_menu',
            handler:function(){
               simpanEditMenu();
            }
        },{
            text:'Batal',
            iconCls:'icon-cancel',
            handler:function(){
                $('#addMenuAccess').dialog('close').dialog('destroy');
            }
        }]
    });
}

function simpanEditMenu(){
  $.messager.confirm({
	title: 'Konfirmasi Update',
	msg: 'Anda Yakin Akan Melanjutkan ?',
	fn: function(r){
        if (r){
            var rowUserId = $('#dg_access_menu').datagrid('getSelected') || {};
            var rowMenu = $('#form_access_menu').datagrid('getSelections') || {};
            var id_menu = [];
            var id_group_menu = [];
            for(var i=0; i<rowMenu.length; i++){
                id_menu.push(rowMenu[i].id_menu);
            }
            for(var i=0; i<rowMenu.length; i++){
                id_group_menu.push(rowMenu[i].id_group_menu);
            }
            var rowUserID = rowUserId.user_id;
            var rowUserJabatan = rowUserId.jabatan;
            var rowUserDivisi = rowUserId.divisi_id;

            var user_id=localStorage.getItem('USER_ID');

            var DataGrid="row_user_id="+rowUserID+"&id_menu="+id_menu+"&id_group_menu="+id_group_menu+"&user_id="+user_id+"&divisi_id="+rowUserDivisi+"&jabatan="+rowUserJabatan;
            $.ajax({
                type: "POST",
                url: "setting/__proses/simpan_access_menu.php",
                data: DataGrid,
                cache: false,
                success: function(data){
                    $.messager.alert('Konfirmasi', data, 'info');
                    $('#addMenuAccess').dialog('close').dialog('destroy');
                    setTimeout(function(){
                        $('.pagination-load').trigger('click');
                    },1000);
                }
            });
        }
	}
    });
}

function duplikasiWewenang(){
    $.messager.confirm({
	title: 'Konfirmasi Update',
	msg: 'Anda Yakin Akan Melanjutkan ?',
	fn: function(r){
        if (r){
            var rowUserId = $('#dg_access_menu').datagrid('getSelected') || {};
            var userPaste = rowUserId.user_id;
            var userCopyDivisi = rowUserId.divisi_id;
            var userCopyJabatan = rowUserId.jabatan;
            var userCopy=$('#duplikasi_access').combobox('getValue');
            var userCreated=localStorage.getItem('USER_ID');

            var DataGrid="userCopy="+userCopy+"&userPaste="+userPaste+"&userCreated="+userCreated+"&userCopyDivisi="+userCopyDivisi+"&userCopyJabatan="+userCopyJabatan;
            $.ajax({
                type: "POST",
                url: "setting/__proses/simpan_duplicate_access_menu.php",
                data: DataGrid,
                cache: false,
                success: function(data){
                    $.messager.alert('Konfirmasi', data, 'info');
                    $('#addMenuAccess').dialog('close').dialog('destroy');
                    setTimeout(function(){
                        $('.pagination-load').trigger('click');
                    },1000);
                }
            });
        }
	}
    });
}
