<?php
include "koneksi_db/Koneksi.php";
date_default_timezone_set('Etc/UTC');
$table_setting_email = TABLE_SETTING_EMAIL;

$query_email="SELECT * FROM $DB.$table_setting_email where id='1'";
$ex_query_email= mysqli_query($KONEKSI, $query_email);
$res_ex_query_email= mysqli_fetch_assoc($ex_query_email);
$host=$res_ex_query_email['host'];
$port=$res_ex_query_email['port'];
$username=$res_ex_query_email['username'];
$password=$res_ex_query_email['password'];

// $host = "mail.kreditmandiri.co.id";
// $port = "587";
// $username = "staf_tidev1@kreditmandiri.co.id";
// $password = "16K01M2017";

require 'asset/phpmailer/PHPMailerAutoload.php';
//$mail -> CharSet = "UTF-8";
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = $host;
$mail->Port = $port;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = $username;
//Password to use for SMTP authentication
$mail->Password = $password;
//Set who the message is to be sent from
// if($mail->smtpConnect()){
//     $mail->smtpClose();
//     //echo "<script>alert('Connected');</script>";
//     $data = "Connected : $host - $port - $username - $password";
// }
// else{
//     //echo "<script>alert('Connection Failed');</script>";
//     $data = "Connected Failed : $host - $port - $username - $password";
// }
// echo $data;
// exit();
