<?php
$data=array();
$tahun=isset($_POST['bulan']) ? $_POST['bulan']: date('m')-1;
for ($i=1;$i<=12;$i++){
    if($i==1){
        $bulan="Januari";
    }elseif($i==2){
        $bulan="Februari";
    }elseif($i==3){
        $bulan="Maret";
    }elseif($i==4){
        $bulan="April";
    }elseif($i==5){
        $bulan="Mei";
    }elseif($i==6){
        $bulan="Juni";
    }elseif($i==7){
        $bulan="Juli";
    }elseif($i==8){
        $bulan="Agustus";
    }elseif($i==9){
        $bulan="September";
    }elseif($i==10){
        $bulan="Oktober";
    }elseif($i==11){
        $bulan="November";
    }elseif($i==12){
        $bulan="Desember";
    }
    $hasil[]=array("id" => $i,"bulan"=>$bulan);
}

echo json_encode($hasil);
