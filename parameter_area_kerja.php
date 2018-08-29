<div id="dg_toolbar_area_kerja">
    <table cellpadding="0" cellspacing="0" style="width:100%">
        <tr>
            <td align="right">
                <label><b>Filter Area Kerja</b></label>&nbsp;&nbsp;&nbsp;
                <input id="parameter_area_kerja" value="" class="easyui-combobox" style="height:25px;width:200px;" name="parameter_area_kerja"
                data-options="
                    url:'setting/__json_data/parameter_area_kerja.php',
                    panelHeight:'auto',
                    width:'100%',
                    valueField:'kode_kantor',
                    textField:'nama_kantor',
                    method : 'POST',
                    queryParams : {
                        addSemua : '1'
                    },
                    onChange : function (){
                        doSearch();
                    }">
            </td>
        </tr>
    </table>
</div>