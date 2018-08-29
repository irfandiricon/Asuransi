$(function (){
    var hTbl = parseInt($(window).innerHeight())-parseInt($('.navbar-fixed-top').height())-parseInt($('.navbar-fixed-bottom').height())-50;

    $('#dg_group_menu').datagrid({
        title:'Group Menu',
        singleSelect:true,
        fitColumns: true,
        pagination:true,
        height : hTbl,
        pageSize:10,
        url:'setting/master/data_group_menu.php',
        columns:[[
            {field:'nama_group_menu',title:'Nama Group Menu',width:100},
            {field:'status_aktif',title:'Status',width:20}
        ]],
        rownumbers:true,
        queryParams : {},
        onClickRow : function(){
            $('#btn_edit_group_menu').linkbutton('enable');
            $('#btn_hapus_group_menu').linkbutton('enable');
        },
        onDblClickRow : function(rowIndex){
            editGroupMenu();
        },
        toolbar :[{
            text:'Tambah',
            iconCls:'icon-add',
            handler:function(){
                tambahGroupMenu();
            }
        },{
            text:'Edit',
            iconCls:'icon-edit',
            id : 'btn_edit_group_menu',
            disabled : true,
            handler:function(){
                editGroupMenu();
            }
        },{
            text:'Hapus',
            iconCls:'icon-remove',
            id : 'btn_hapus_group_menu',
            disabled : true,
            handler:function(){
                hapusGroupMenu();
            }
        }],
        view: detailview,
        detailFormatter:function(index,row){
            return '<div style="padding:2px;position:relative;"><table class="tabel-menu-'+row.id_group_menu+'"></table></div>';
        },
        onExpandRow: function(index,row){
            var that=$(this);
            var ddv = that.datagrid('getRowDetail',index).find('table.tabel-menu-'+row.id_group_menu);
            that.datagrid('selectRow',index);
            ddv.datagrid({
                url:'setting/master/data_menu.php',
                fitColumns:true,
                title: 'Menu',
                singleSelect:true,
                rownumbers:true,
                loadMsg:'',
                height:'auto',
                queryParams : row,
                onClickRow : function(){
                    $('#btn_edit_menu').linkbutton('enable');
                    $('#btn_hapus_menu').linkbutton('enable');
                },
                onDblClickRow : function(index,row){
                    editMenu(row.id_group_menu);
                },
                toolbar :[{
                    text:'Tambah',
                    iconCls:'icon-add',
                    handler:function(){
                        tambahMenu(row.id_group_menu);
                    }
                }],
                columns:[[
                    {field:'nama_menu',title:'Nama Menu',width : 100},
                    {field:'path',title:'Lokasi File',width : 100},
                    {field:'nama_file',title:'Nama File',width : 100},
                    {field:'status_aktif',title:'Status',width : 50}
                ]],
                onResize:function(){
                    that.datagrid('fixDetailRowHeight',index);
                },
                onLoadSuccess:function(data){
                    setTimeout(function(){
                        that.datagrid('fixDetailRowHeight',index);
                    },0);
                }
            });
            that.datagrid('fixDetailRowHeight',index);
        }
    });
});

function tambahGroupMenu(){
    $('body').find('#addGroupMenu').remove();
    $('<div/>').attr('id','addGroupMenu').appendTo($('body')).dialog({
        href: 'setting/popup/form_add_group_menu.php',
        title: ' Tambah Group Menu',
        iconCls : "icon-add",
        width: 400,
        height: 300,
        modal: true,
        buttons: [{
            text:'Simpan',
            iconCls:'icon-ok',
            handler:function(){
               simpanGroupMenu();
            }
        },{
            text:'Batal',
            iconCls:'icon-cancel',
            handler:function(){
                $('#addGroupMenu').dialog('close').dialog('destroy');
            }
        }]
    });
}

function simpanGroupMenu(){
    $.messager.confirm({
        title: 'Notification',
        msg: 'Anda Yakin Akan Menyimpan Data Ini ?',
        fn: function(r){
            if (r){
                var nama_group_menu=$('#nama_group_menu').val();
                var font_icon=$('#font_icon').val();
                var DataGrid="nama_group_menu="+nama_group_menu+"&font_icon="+font_icon;
                if (nama_group_menu=="" || font_icon==""){
                    alert('Masukan Data !!!');
                }else{
                    $.ajax({
                        type: "POST",
                        url: "setting/__proses/simpan_group_menu.php",
                        data: DataGrid,
                        cache: false,
                        success: function(data){
                            $.messager.alert('Konfirmasi', data, 'info');
                            $('#addGroupMenu').dialog('close').dialog('destroy');
                            setTimeout(function (){
                                $('.pagination-load').trigger('click');
                            },1000);
                        }
                    });
                }
            }
        }
    });
}

function hapusGroupMenu(){
    var rowSelected = $('#dg_group_menu').datagrid('getSelected') || {};
    var id_group_menu = rowSelected.id_group_menu;
    var nama_group_menu = rowSelected.nama_group_menu;
    $.messager.confirm({
	title: 'Konfirmasi Hapus',
	msg: 'Anda Yakin Akan Mengahapus Data '+nama_group_menu+' Ini ? ',
	fn: function(r){
            if (r){
                $.ajax({
                    type: "POST",
                    url: "setting/__proses/hapus_group_menu.php",
                    data : "id_group_menu="+id_group_menu,
                    cache: false,
                    success: function(html){
                        $('.pagination-load').trigger('click');
                        console.log(html);
                    }
                });
            }
	}
    });
}

function editGroupMenu(){
    var rowSelected = $('#dg_group_menu').datagrid('getSelected') || {};
    $('body').find('#editGroupMenu').remove();
    $('<div/>').attr('id','editGroupMenu').appendTo($('body')).dialog({
        href: 'setting/popup/form_edit_group_menu.php',
        title: ' Edit Group Menu',
        iconCls : "icon-edit",
        width: 400,
        height: 400,
        queryParams : rowSelected,
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
        },
        modal: true,
        buttons: [{
            text:'Update',
            iconCls:'icon-ok',
            handler:function(){
               simpanEditGroupMenu();
            }
        },{
            text:'Batal',
            iconCls:'icon-cancel',
            handler:function(){
                $('#editGroupMenu').dialog('close').dialog('destroy');
            }
        }]
    });
}

function simpanEditGroupMenu(){
    $.messager.confirm({
        title: 'Notification',
        msg: 'Anda Yakin Akan Menyimpan Data Ini ?',
        fn: function(r){
            if (r){
                var rowSelected = $('#dg_group_menu').datagrid('getSelected') || {};
                var id_group_menu=rowSelected.id_group_menu;
                var nama_group_menu=$('#nama_group_menu').val();
                var font_icon=$('#font_icon').val();
                var status_aktif = $('#status_aktif').combobox('getValue');
                var DataGrid="id_group_menu="+id_group_menu+"&nama_group_menu="+nama_group_menu+"&font_icon="+font_icon+"&status_aktif="+status_aktif;

                if (nama_group_menu=="" || font_icon==""){
                    alert('Masukan Data !!!');
                }else{
                    $.ajax({
                        type: "POST",
                        url: "setting/__proses/edit_group_menu.php",
                        data: DataGrid,
                        cache: false,
                        success: function(data){
                            $.messager.alert('Konfirmasi', data, 'info');
                            $('#editGroupMenu').dialog('close').dialog('destroy');
                            setTimeout(function (){
                                $('.pagination-load').trigger('click');
                            },1000);
                        }
                    });
                }
            }
        }
    });
}

function tambahMenu(id_group_menu){
    $('body').find('#addMenu').remove();
    $('<div/>').attr('id','addMenu').appendTo($('body')).dialog({
        href: 'setting/popup/form_add_menu.php',
        title: ' Tambah Menu',
        iconCls : "icon-add",
        width: 400,
        height: 400,
        modal: true,
        method : 'POST',
        buttons: [{
            text:'Simpan',
            iconCls:'icon-ok',
            handler:function(){
               simpanMenu(id_group_menu);
            }
        },{
            text:'Batal',
            iconCls:'icon-cancel',
            handler:function(){
                $('#addMenu').dialog('close').dialog('destroy');
            }
        }]
    });
}

function simpanMenu(id_group_menu){
    $.messager.confirm({
        title: 'Notification',
        msg: 'Anda Yakin Akan Menyimpan Data Ini ?',
        fn: function(r){
            if (r){
                var nama_menu=$('#nama_menu').val();
                var path = $('#path').val();
                var nama_file=$('#nama_file').val();
                var DataGrid="id_group_menu="+id_group_menu+"&nama_menu="+nama_menu+"&path="+path+"&nama_file="+nama_file;
                if (nama_menu=="" || path=="" || nama_file==""){
                    alert('Masukan Data !!!');
                }else{
                    $.ajax({
                        type: "POST",
                        url: "setting/__proses/simpan_menu.php",
                        data: DataGrid,
                        cache: false,
                        success: function(data){
                            $.messager.alert('Konfirmasi', data, 'info');
                            $('#addMenu').dialog('close').dialog('destroy');
                            setTimeout(function (){
                                $('.pagination-load').trigger('click');
                            },1000);
                        }
                    });
                }
            }
        }
    });
}

function editMenu(id_group_menu){
    var rowSelected = $('.tabel-menu-'+id_group_menu).datagrid('getSelected') || {};

    $('body').find('#editMenu').remove();
    $('<div/>').attr('id','editMenu').appendTo($('body')).dialog({
        href: 'setting/popup/form_edit_menu.php',
        title: ' Edit Menu',
        iconCls : "icon-edit",
        width: 400,
        height: 460,
        queryParams : rowSelected,
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
        },
        modal: true,
        buttons: [{
            text:'Update',
            iconCls:'icon-ok',
            handler:function(){
               simpanEditMenu(id_group_menu);
            }
        },{
            text:'Hapus',
            iconCls:'icon-remove',
            handler:function(){
               hapusMenu(id_group_menu);
            }
        },{
            text:'Batal',
            iconCls:'icon-cancel',
            handler:function(){
                $('#editMenu').dialog('close').dialog('destroy');
            }
        }]
    });
}

function simpanEditMenu(id_group_menu){
    $.messager.confirm({
        title: 'Notification',
        msg: 'Anda Yakin Akan Menyimpan Data Ini ?',
        fn: function(r){
            if (r){
                var rowSelected = $('.tabel-menu-'+id_group_menu).datagrid('getSelected') || {};
                var id_menu=rowSelected.id_menu;
                var nama_menu=$('#nama_menu').val();
                var path=$('#path').val();
                var nama_file = $('#nama_file').val();
                var status_aktif = $('#status_aktif').combobox('getValue');
                var DataGrid="id_menu="+id_menu+"&nama_menu="+nama_menu+"&path="+path+"&nama_file="+nama_file+"&status_aktif="+status_aktif;

                if (nama_menu=="" || path=="" || nama_file==""){
                    alert('Masukan Data !!!');
                }else{
                    $.ajax({
                        type: "POST",
                        url: "setting/__proses/edit_menu.php",
                        data: DataGrid,
                        cache: false,
                        success: function(data){
                            $.messager.alert('Konfirmasi', data, 'info');
                            $('#editMenu').dialog('close').dialog('destroy');
                            setTimeout(function (){
                                $('.pagination-load').trigger('click');
                            },1000);
                        }
                    });
                }
            }
        }
    });
}

function hapusMenu(id_group_menu){
    var rowSelected = $('.tabel-menu-'+id_group_menu).datagrid('getSelected') || {};
    var id_menu=rowSelected.id_menu;
    var nama_menu=rowSelected.nama_menu;
    $.messager.confirm({
	title: 'Konfirmasi Hapus',
	msg: 'Anda Yakin Akan Mengahapus Menu '+nama_menu+' Ini ? ',
	fn: function(r){
            if (r){
                $.ajax({
                    type: "POST",
                    url: "setting/__proses/hapus_menu.php",
                    data : "id_menu="+id_menu,
                    cache: false,
                    success: function(html){
                        $('#editMenu').dialog('close').dialog('destroy');
                        $('.pagination-load').trigger('click');
                        console.log(html);
                    }
                });
            }
	}
    });
}
