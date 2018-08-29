<?php
session_start();
$SESSION_USERNAME=isset($_SESSION['USERNAME']) ? $_SESSION['USERNAME']:"";
$SESSION_PASSWORD= isset($_SESSION['PASSWORD']) ? $_SESSION['PASSWORD']:"";
if ($SESSION_USERNAME && $SESSION_PASSWORD){
    include "template.php";
}else{
    echo "<script>window.location.href='login/';</script>";
}
