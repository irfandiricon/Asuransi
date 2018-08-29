<?php
date_default_timezone_set('Etc/UTC');

$host=$_POST['host'];
$port=$_POST['port'];
$username=$_POST['username'];
$password=$_POST['password'];

require '../../asset/phpmailer/PHPMailerAutoload.php';
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
$mail->SMTPSecure = '';
//Whether to use SMTP authentication
$mail->SMTPAuth = false;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = $username;
//Password to use for SMTP authentication
$mail->Password = $password;

if($mail->smtpConnect()){
    $mail->smtpClose();
   echo "<script>alert('Connected');</script>";
}
else{
    echo "<script>alert('Connection Failed');</script>";
}
