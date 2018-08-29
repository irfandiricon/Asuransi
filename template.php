<?php
require_once "__setting.php";
$nama_aplikasi = NAMA_APLIKASI;
$SESSION_KONEKSI=isset($_SESSION['KONEKSI']) ? $_SESSION['KONEKSI']:"";
$SESSION_USERNAME=isset($_SESSION['USERNAME']) ? $_SESSION['USERNAME']:"";
$SESSION_PASSWORD=isset($_SESSION['PASSWORD']) ? $_SESSION['PASSWORD']:"";
$SESSION_NIK=isset($_SESSION['NIK']) ? $_SESSION['NIK']:"";

if ($SESSION_USERNAME && $SESSION_PASSWORD){

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "css.php";?>

     <script src="js/jquery.min.js"></script>
     <!-- <script src="js/bootstrap.min.js"></script> -->
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<BODY class="nav-md">
     <div class="container body">
          <div class="main_container">
               <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title navbar-fixed-top" style="border: 0; padding-left: 10px">
                            <a href="./" class="site_title">
                                <i class="fa fa-user"
                                    style="padding-left: 10px;padding-right: 10px;padding-top: 5px;padding-bottom: 5px"></i>
                                <span><font face="cambria"><?php echo $nama_aplikasi;?></font></span>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <br/><br/>
                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <img id="photo_profil" onerror="$(this).attr('src','http://103.234.254.186/foto_profil/not-photo.jpg')" alt="..." class="img-circle profile_img" src="http://103.234.254.186/foto_profil/not-photo.jpg">
                            </div>
                            <div class="profile_info" style="padding-left: 25px">
                                <span>Welcome,</span>
                                <span id="nama_user"></span>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->
                        <br />
                        <div id="menu_aplikasi">
                          <?php include "menu.php";?>
                        </div>
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav navbar-fixed-top">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                    </ul>
                                </li>
                               <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-envelope-o"></i>
                                        <!-- Total Pesan -->
                                        <span class="badge bg-green" id="total_notifikasi"></span>
                                        <!-- End Total Pesan -->
                                    </a>
                                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                        <li>
                                            <div class="text-center">
                                            <a onclick="AllViewNotifications()">
                                               <strong>See All Notifiations</strong>
                                               <i class="fa fa-angle-right"></i>
                                            </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
               </div>
               <!-- top navigation -->
               <!-- page content -->
               <div class="right_col" role="main">
                    <span id="dialog-notification"></span>
                    <div id="pp" style="position: fixed;margin-top:35px;"></div>
               </div>
               <!-- page content -->

                <!-- footer content -->
                <footer class="nav navbar-fixed-bottom">
                    <div class="sidebar-footer hidden-small">
                        <a href="logout.php">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                        <a href="javascript:void(0)" onclick="window.location.reload()">
                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                        </a>
                    </div>

                     <div class="pull-right">
                         Design Template by <a href="javascript:void(0)">Copyright&copy;IrCn2017</a>
                     </div>
                     <div class="clearfix"></div>
                </footer>
                <!-- footer content -->
          </div>


     </div>

     <style>
      .l-btn-text{
        padding-top: 3px;
        padding-left: 2px;
      }
     </style>

     <script src="js/fastclick.js"></script>
     <script src="js/custom.min.js"></script>
     <script type="text/javascript" src="easyUi/jquery.min.js"></script>
     <script type="text/javascript" src="easyUi/jquery.easyui.min.js"></script>
     <script type="text/javascript" src="easyUi/datagrid.detailview.js"></script>
     <script type="text/javascript" src="index.js"></script>
     <script type="text/javascript" src="js/jquery.timeago.js"></script>

<script>
    $(function(){

        $('body').append("</bo"+"dy>");

        var jabatan = localStorage.getItem('JABATAN');
        var group_menu = localStorage.getItem('GROUP_MENU');

        if(($.inArray(jabatan,["PIMPINAN CABANG","KEPALA KANTOR KAS","AREA MANAGER"])) >= 0 ||
            ($.inArray(group_menu,["IT","PUSAT"])) >= 0){
            var url = "content/mapping/index.php";
        }else if(($.inArray(jabatan,["HEAD MARKETING"])) >= 0 ){
            var url = "content/form_rekrut_regist_maintain_mb/index.php";
        }else{
            var url = "welcome.php";
        }

        $('#pp').panel({
            href : 'welcome.php',
            fit : true
        })
    });

    function noscroll() {
      window.scrollTo( 0, 0 );
    }
</script>
</html>
<?php
}else{
    header("location: ./");
}
