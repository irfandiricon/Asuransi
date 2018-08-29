<?php 
$user_id=isset($_POST['user_id']) ? $_POST['user_id']:"";
?>
<table id="all_notification" class="easyui-datagrid"
    data-options="rownumbers:true,fit:true,fitColumns:true,singleSelect:true,striped:true,
    url :'__json_data/data_all_notifikasi.php',
    queryParams: {
    	user_id : <?php echo $user_id;?>
	},
    method : 'POST',
    rownumbers:true,
    singleSelect:true,
    fitColumns: true,
    pagination:true,
    pageSize:10,
    columns:[
        [
        {field:'nama',halign:'center',width:200,title:'Nama',formatter: StatusNotification},
        {field:'subject',halign:'center',width : 500, title:'Subject',formatter: StatusNotification},
        {field:'waktu',halign:'center',width : 200, title:'Request Date',formatter: StatusNotification}
        ]
    ],
    onDblClickRow : function(index,row){
    	if(row.status==0){
    		viewNotification(row.id);
    	}
	},
    onLoadSuccess : function(data){
        //alert(JSON.stringify(data));
    }">
</table>

<script>
function StatusNotification(val,row){
    //console.log(JSON.stringify(row.status))
    if (row.status == 0){
        return '<span style="color:black;"><b>'+val+'</b></span>';
    } else {
        return val;
    }
}
</script>