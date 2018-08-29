<?php 
include "../koneksi_db/Koneksi.php";

$id=isset($_POST['id']) ? $_POST['id']:"";
$user_id=isset($_POST['user_id']) ? $_POST['user_id']:"";

$query[]="SELECT subject,pesan FROM $DB.ace_notifikasi where id='$id'";
$query[]="UPDATE $DB.ace_notifikasi SET status='1' where id='$id'";

$ex_query=mysqli_multi_query($KONEKSI, join(";",$query));
$rs = mysqli_store_result($KONEKSI);
$result=mysqli_fetch_assoc($rs);
$subject=$result['subject'];
$pesan=$result['pesan'];
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-3">
                <b>Subject</b>
            </div>
            <div class="col-md-9">
                <input value="<?php echo $subject;?>" readonly class="form-control"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <b>Pesan</b>
            </div>
            <div class="col-md-9">
                <textarea readonly style="height: 200px;" class="form-control"><?php echo $pesan;?></textarea> 
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .col-md-3,.col-md-9{
        padding-top: 10px;
    }
</style>