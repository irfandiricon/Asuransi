<script src="setting/setting_access_menu/index.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="dg_toolbar_keywoard" style="padding:10px;">
                <table cellpadding="0" cellspacing="0" style="width:100%">
                    <tr>
                        <td align="right">
                            <label><b>Filter Area Kerja</b></label>&nbsp;&nbsp;&nbsp;
                            <input id="parameter_area_kerja" name="parameter_area_kerja">
                            &nbsp;&nbsp;
                            <label><b>Kunci Pencarian</b></label>&nbsp;&nbsp;&nbsp;
                            <input id="parameter_keywoard" name="parameter_keywoard">
                        </td>
                    </tr>
                </table>
            </div>
            <table id="dg_access_menu" data-options="fitColumns:true"></table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#parameter_area_kerja').combobox({
            url:'setting/master/data_kode_kantor.php',
            panelHeight:'auto',
            width:200,
            height:30,
            valueField:'kode_kantor',
            textField:'nama_kantor',
            method : 'POST',
            queryParams : {
                addSemua : '1'
            },
            onChange : function (){
                doSearch();
            }
        });

        $('#parameter_keywoard').searchbox({
            prompt:'Masukan Kata Pencarian',
            searcher:doSearch,
            width:200,
            height:30,
        });
    });
</script>
