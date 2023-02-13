<?php
session_start(); 
error_reporting(E_ALL);
date_default_timezone_set("Europe/Istanbul");

$islem_adi = @$_GET["islem_adi_v"];

$izinverilenler = array("api", "test-api");

foreach($izinverilenler as $izinverilen) {
if($islem_adi==$izinverilen) {
    $izinverilendurum = 1;
}
}

if($izinverilendurum!=1) {
if(empty(trim($_SERVER["HTTP_USER_AGENT"]))) {
die();
}

if(empty(trim($_SERVER["HTTP_REFERER"]))) {
    die();
}
}

$inc = 1;
include("ayarlar/fonksiyonlar.php");
include("ayarlar/baglanti.php");

if($_SESSION["oturum_durum"]==1) {
    $kullanicibilgisi = $baglanti->prepare("SELECT * FROM kullanicilar WHERE id = :kid limit 1");
    $kullanicibilgisi->bindParam(":kid", $_SESSION["oturum_bilgileri"]["kullanici_id"], PDO::PARAM_STR);
    $kullanicibilgisi->fetchAll(PDO::FETCH_ASSOC);
    $kullanicibilgisi->execute();
    
    if($kullanicibilgisi->rowCount()) {
        foreach($kullanicibilgisi as $kullaniciveri) {
            $kullanici_adi = $kullaniciveri["kullaniciadi"];
            $kullanici_parola = $kullaniciveri["parola"];
            $kullanici_yetkisi = $kullaniciveri["yetki_seviyesi"];
            $kullanici_isim = $kullaniciveri["isim"];
            $kullanici_discordid = $kullaniciveri["discordid"];
        }
    }
    
    if($kullanici_yetkisi==0) {
    session_destroy();  
    }
}

if(!file_exists("islemler/" . $islem_adi . ".php")) {
    die();
}

switch($islem_adi) {

    case $islem_adi:
    include("islemler/" . $islem_adi . ".php");
    break;

    default:
    echo "";
    break;

}
?>
