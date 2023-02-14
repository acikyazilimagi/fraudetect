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

    if(empty(trim($_POST["site_id"]))) { exit; }

    if(!is_numeric($_POST["site_id"])) { exit; }

    $kontrol = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE id = :id");
    $kontrol->bindParam(":id", $_POST["site_id"], PDO::PARAM_INT);
    $kontrol->execute();

    if(!$kontrol->rowCount()) {
    $cikti = array(
        "id" => 3,
        "mesaj" => "Silinemedi, böyle bir id veritabanında yok."
    );
    die(json_encode($cikti));
    } else {
    foreach($kontrol as $siteveri) {
        $siteadresi = $siteveri["site_adresi"];
        $siteurl = $siteveri["site_tam_adresi"];
        $site_ekleyenbilgi = $siteveri["ekleyen"];
        $sitedurum = $siteveri["durum"];
        $site_eklenme_tarihi = $siteveri["eklenme_tarihi"];
    }

    if($sitedurum==5) {
    $cikti = array(
        "id" => 5,
        "mesaj" => "Silme yetkiniz bulunmuyor."
    );
    die(json_encode($cikti));
    }

    $sil = $baglanti->prepare("DELETE FROM eklenen_siteler WHERE id = :id");
    $sil->bindParam(":id", $_POST["site_id"], PDO::PARAM_INT);

    try {
    $sil->execute();
    if(file_exists("log/".date("Y-m-d")."-silinenler.json")) {
        $silinenler = json_decode(file_get_contents("log/".date("Y-m-d")."-silinenler.json"), true);
    } else {
        $silinenler = array();
    }

    array_push($silinenler, array(
        "silinen_alan_adi" => $siteadresi,
        "silinen_url" => $siteurl,
        "ekleyen_bilgi" => json_decode($site_ekleyenbilgi, true),
        "durum" => $sitedurum,
        "eklenme_tarihi" => $site_eklenme_tarihi,
        "silen_bilgi" => array(
            "kullanici_id" => $_SESSION["oturum_bilgileri"]["kullanici_id"],
            "kullanici_adi" => $kullanici_adi,
            "kullanici_isim" => $kullanici_isim,
            "kullanici_discordid" => $kullanici_discordid,
            "ip_adresi" => gercek_ip()
        )
    ));
    $log = fopen("log/".date("Y-m-d")."-silinenler.json", "x+");
    fwrite($log, json_encode($silinenler));
    fclose($log);

    $cikti = array(
        "id" => 1,
        "mesaj" => "Silindi"
    );
    die(json_encode($cikti));  
    } catch(PDOException $v4hata) {
    $cikti = array(
        "id" => 2,
        "mesaj" => "Silinemedi, hata:".$v4hata->getMessage()
    );
    die(json_encode($cikti));
    }

}

}
?>