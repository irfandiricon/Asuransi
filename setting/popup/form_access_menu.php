<?php
$USER_ID=$_POST['user_id'];
?>
<table id="form_access_menu"></table>

<script>
    $(function(){
        $('#form_access_menu').datagrid({
            rownumbers:true,
            fit:true,
            striped:true,
            url :'setting/master/data_access_menu.php',
            queryParams: {
                user_id : <?php echo $USER_ID;?>
            },
            method : 'POST',
            fitColumns: true,
            columns:[[
                {field:'ck',checkbox:true},
                {field:'nama_group_menu',width:40,title:'Nama Group Menu'},
                {field:'nama_menu',width:100,title:'Nama Menu'}
            ]],
            onLoadSuccess:function(data){
                for (var i = 0; i < data.rows.length; ++i) {
                    if (data.rows[i]['status_menu'] == 1) $(this).datagrid('checkRow', i);
                }

            }
        });
    });
</script>

<style>
    input[type="checkbox"][name='ck'],.datagrid-header-check input[type="checkbox"]{
        opacity: 1;
        z-index: 1;
    }
</style>
