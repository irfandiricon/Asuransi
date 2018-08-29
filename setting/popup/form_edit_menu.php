<form method="POST" name="formAddMenu">
    <table class="table table-striped table-hover">
        <tr>
             <th>Nama Menu</th>
        </tr>
        <tr>
            <td>
                <input class="form-control" required id="nama_menu" name="nama_menu" placeholder="Nama Menu">
            </td>
        </tr>
        <tr>
             <th>Path File</th>
        </tr>
        <tr>
            <td>
                <input class="form-control" required id="path" name="path" placeholder="Path File">
            </td>
        </tr>
        <tr>
             <th>Nama File</th>
        </tr>
        <tr>
            <td>
                <input class="form-control" required id="nama_file" name="nama_file" value='.php' placeholder="Nama File">
            </td>
        </tr>
        <tr>
             <th>Status Akrif</th>
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