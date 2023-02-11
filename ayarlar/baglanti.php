<?php
error_reporting(0);
if($inc!=1) { die(); }
$v4_sistem_ayarlar_pr = array(
    "sunucu" => "localhost",
    "veritabani" => "panel",
    "kullanici" => "root",
    "parola" => ""
);

$baglanti = new PDO("mysql:host=".$v4_sistem_ayarlar_pr["sunucu"].";dbname=".$v4_sistem_ayarlar_pr["veritabani"].";charset=utf8", $v4_sistem_ayarlar_pr["kullanici"], $v4_sistem_ayarlar_pr["parola"]);

    try {
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return "1";
    }
    catch(PDOException $v4hata) {
    die();
    }
?>