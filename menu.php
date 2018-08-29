<?php
require 'koneksi_db/Koneksi.php';

$table_group_menu=TABLE_GROUP_MENU;
$table_menu=TABLE_MENU;
$table_access_menu=TABLE_ACCESS_MENU;

$USER_ID=$_SESSION['USER_ID'];
$query_access_menu="SELECT id_menu from $DB.$table_access_menu where user_id='$USER_ID'";
$ex_query_access_menu= mysqli_query($KONEKSI, $query_access_menu);
$res_ex_query_access_menu= mysqli_fetch_assoc($ex_query_access_menu);
$id_access_menu=$res_ex_query_access_menu['id_menu'];
?>
<!-- sidebar menu -->
 <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <?php
                $query2="SELECT c.id_group_menu FROM $DB.$table_access_menu AS c WHERE user_id='$USER_ID'";
                $ex_query2= mysqli_query($KONEKSI, $query2);
                $res_ex_query2= mysqli_fetch_assoc($ex_query2);
                $rows_query2= mysqli_num_rows($ex_query2);

                if ($rows_query2==0){
                    $id_group_menu="NULL";
                }else{
                    $id_group_menu=$res_ex_query2['id_group_menu'];
                }

                $query_group_menu="SELECT a.* FROM $DB.$table_group_menu AS a WHERE
                    a.id_group_menu IN ($id_group_menu)
                    and a.status_aktif='1'";
                $ex_query_group_menu=mysqli_query($KONEKSI,$query_group_menu);
                while($res_ex_query_group_menu= mysqli_fetch_assoc($ex_query_group_menu)){
                $nama_group_menu=$res_ex_query_group_menu['nama_group_menu'];
                $font_icon=$res_ex_query_group_menu['font_icon'];
                $id_group_menu=$res_ex_query_group_menu['id_group_menu'];
                ?>
                <li>
                    <a class="<?php echo $id_group_menu;?>">
                        <i class="<?php echo $font_icon;?>"></i>
                        <?php echo $nama_group_menu;?>

                    </a>
                    <ul class="nav child_menu">
                        <?php
                            $query_menu="select distinct a.path,a.nama_file,nama_menu,id_menu from $DB.$table_menu as a
                            where a.id_menu IN ($id_access_menu) AND a.id_group_menu=$id_group_menu
                            and a.status_aktif='1' order by a.id_group_menu,a.id_menu asc";
                            $ex_query_menu=mysqli_query($KONEKSI,$query_menu);
                            while($res_ex_query_menu=mysqli_fetch_array($ex_query_menu)){
                            $nama_menu=$res_ex_query_menu['nama_menu'];
                            $nama_file=$res_ex_query_menu['nama_file'];
                            $path_menu=$res_ex_query_menu['path'];
                        ?>
                        <li><a href='javascript:void(0)' style="color:#000;" data-path="<?php echo $path_menu;?>" class="list-group-item menu-kiri <?php echo $nama_file; ?>"><?php echo $nama_menu;?></a></li>

                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div>
 </div>
 <br><br><br>
 <!-- sidebar menu -->
