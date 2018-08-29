<form method="POST" name="formAddGroupMenu">
    <table class="table table-striped table-hover">
        <tr>
             <th>Nama Group Menu</th>
        </tr>
        <tr>
            <td>
                <input class="form-control" required id="nama_group_menu" name="nama_group_menu" placeholder="Nama Group Menu">
            </td>
        </tr>
        <tr>
             <th>Font Icon Group Menu</th>
        </tr>
        <tr>
            <td>
                <input class="form-control" required id="font_icon" name="font_icon" value="fa fa-" placeholder="Font Icon Group Menu">
            </td>
        </tr>
        <tr>
             <th>Status Group Menu</th>
        </tr>
        <tr>
            <td>
                <select class="easyui-combobox" data-options="panelHeight:'auto',width:'100%'" id="status_aktif" name="status_aktif">
                    <option value="Aktif">Aktif</option>
                    <option value="Non Aktif">Non Aktif</option>
                </select>
            </td>
        </tr>
    </table>
<form>