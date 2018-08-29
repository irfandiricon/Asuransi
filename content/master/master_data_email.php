<?php
$dpm_online = DB_DPM_ONLINE;
$table_parameter = TABLE_PARAMETER;
$parameter_asuransi_email_pusat = PARAMETER_ASURANSI_EMAIL_PUSAT;

$q1= "SELECT value FROM $dpm_online.$table_parameter where id='$parameter_asuransi_email_pusat'";
$ex_q1 = mysqli_query($KONEKSI, $q1);
$res_ex_q1 = mysqli_fetch_array($ex_q1);
$email_asuransi_pusat = explode(",",$res_ex_q1['value']);
