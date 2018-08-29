<?php
require_once '__setting.php';
$host_api = HOST_API;
$username = isset($_POST['username']) ? $_POST['username']:"";
$password = isset($_POST['password']) ? $_POST['password']:"";
$koneksi = isset($_POST['koneksi']) ? $_POST['koneksi']:"";

$akses_data_login = "$host_api/user/login";

$ch = curl_init($akses_data_login);
$data = array(
	'username' => $username,
	'password' => $password,
	'koneksi' => $koneksi
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'method' => 'POST',
    'Content-type: application/json',
));

curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response  = curl_exec($ch);

echo ($response);
exit();
echo $response;
curl_close($ch);
?>