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

if(isset($_POST["discord_id"])) {
    if(empty(trim($_POST["discord_id"]))) { exit; }

    $guncelle = $baglanti->prepare("UPDATE kullanicilar SET discordid = :dcid WHERE id = :id");
    $guncelle->bindParam(":dcid", $_POST["discord_id"], PDO::PARAM_STR);
    $guncelle->bindParam(":id", $_SESSION["oturum_bilgileri"]["kullanici_id"], PDO::PARAM_INT);

    try {
    $guncelle->execute();
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