<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;
if($inc!=1) { die(); }
header("Content-Type: application/json; charset=utf-8");

if($_SESSION["oturum_durum"]!=1) {
    die();
}

if($kullanici_yetkisi==0) {
session_destroy();  
}

if(isset($_POST["site"])) {
    if(empty(trim($_POST["site"] and $_POST["referans"]))) { exit; }

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $_POST["site"],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_REFERER => $_POST["referans"],
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_HEADER => 1,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));
    
    $response = curl_exec($curl);
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    
    curl_close($curl);
    
    $cikti = array(
        "id" => 1,
        "header" => htmlspecialchars($header)
    );
    die(json_encode($cikti));
    
}
?>