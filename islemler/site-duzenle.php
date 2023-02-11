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

if(isset($_POST["site_id"])) {

    if(empty(trim($_POST["site_id"] and $_POST["durum"]))) { exit; }

    if(!is_numeric($_POST["site_id"])) { exit; }
    if(!is_numeric($_POST["durum"])) { exit; }
    $durumlar = array(2, 3, 4);
    foreach($durumlar as $durum_veri) {
        if($_POST["durum"]==$durum_veri) {
            $durum_dogrulama = 1;
        }
    }

    if($durum_dogrulama!=1) { exit; }

    $kontrol = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE id = :id");
    $kontrol->bindParam(":id", $_POST["site_id"], PDO::PARAM_INT);
    $kontrol->execute();

    if(!$kontrol->rowCount()) {
    $cikti = array(
        "id" => 3,
        "mesaj" => "Güncellenemedi, böyle bir id veritabanında yok."
    );
    die(json_encode($cikti));
    } else {
        foreach($kontrol as $siteveri) {
            $siteadresi = $siteveri["site_tam_adresi"];
            $site_durumu = $siteveri["durum"];
        }
    }

    if($kullanici_yetkisi==1) {

    if($site_durumu==3) {
        $erisimengeli = 1;
    } elseif($site_durumu==4) {
        $erisimengeli = 1;
    } elseif($site_durumu==5) {
        $erisimengeli = 1;
    }

    } elseif($kullanici_yetkisi==2) {

    if($site_durumu==5) {
        $erisimengeli = 1;
    } 
    
    }

    if($erisimengeli==1) {
    $cikti = array(
        "id" => 4,
        "mesaj" => "Silme yetkiniz bulunmuyor."
    );
    die(json_encode($cikti));
    }

    $guncelle = $baglanti->prepare("UPDATE eklenen_siteler SET durum = :yenidurum WHERE id = :id");
    $guncelle->bindParam(":yenidurum", $_POST["durum"], PDO::PARAM_INT);
    $guncelle->bindParam(":id", $_POST["site_id"], PDO::PARAM_INT);

    try {
    $guncelle->execute();
    if($_POST["durum"]==3) {
    discord_mesaj($siteadresi);
    }
    $cikti = array(
        "id" => 1,
        "mesaj" => "Güncellendi"
    );
    die(json_encode($cikti));
    } catch(PDOException $v4hata) {
    $cikti = array(
        "id" => 2,
        "mesaj" => "Güncellenemedi, hata:".$v4hata->getMessage()
    );
    die(json_encode($cikti));
    }

}
?>