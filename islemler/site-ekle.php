<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;
if($inc!=1) { die(); }

require('siniflar/usom.class.php');
header("Content-Type: application/json; charset=utf-8");

if($_SESSION["oturum_durum"]!=1) {
    die();
}

if($kullanici_yetkisi==0) {
session_destroy();  
}

if(isset($_POST["site"])) {
    if(empty(trim($_POST["site"] and $_POST["tur"]))) { exit; }

    $siteadresi = $_POST["site"];
    $tur = $_POST["tur"];

    if(!is_numeric($tur)) { exit; }

    $turler = array(2, 3, 4);
    foreach($turler as $tur_veri) {
        if($tur==$tur_veri) {
            $tur_dogrulama = 1;
        }
    }

    if($tur_dogrulama!=1) { exit; }

    if(strstr($siteadresi, "http")) {
        $duzsiteadresi = parse_url($siteadresi)["host"];
    } else {
        $duzsiteadresi = $siteadresi;
    }

    $duzsiteadresi = preg_replace('/\s+/', '', $duzsiteadresi);

    $sosyalmedyalistesi = array("instagram.com", "facebook.com", "twitter.com");
    $wwwkaldir = str_replace("www.", "", $duzsiteadresi);

    foreach($sosyalmedyalistesi as $sosyalmedyasite) {
        if($wwwkaldir==$sosyalmedyasite) {
            $sorgulamaiptal = 1;
        }
    }

    if($sorgulamaiptal!=1) {
    $sitesorgu = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE site_adresi = :siteadresi");
    $sitesorgu->bindParam(":siteadresi", $duzsiteadresi, PDO::PARAM_STR);
    $sitesorgu->fetchAll(PDO::FETCH_ASSOC);
    $sitesorgu->execute();

    if($sitesorgu->rowCount()) {
        foreach($sitesorgu as $siteveri) {
            $site_eklenme_tarihi = $siteveri["eklenme_tarihi"];
        }

        $cikti = array(
            "id" => 2,
            "mesaj" => '<div class="form-group alert alert-dismissible alert-warning" style="margin-top:20px;"><i class="fa fa-times"></i> '.htmlspecialchars($siteadresi).' adresi daha önce '.htmlspecialchars($site_eklenme_tarihi).' tarihinde eklenmiştir</div>'
          );
        die(json_encode($cikti));
    }
    }

    $kontrol = \usom::check($duzsiteadresi, 1);

    if($kontrol["status"]==0) {
        $cikti = array(
            "id" => 3,
            "mesaj" => '<div class="form-group alert alert-dismissible alert-warning" style="margin-top:20px;"><i class="fa fa-times"></i> '.htmlspecialchars($siteadresi).' adresi USOM listesinde bulunuyor</div>'
          );
        die(json_encode($cikti));  
    } else {

     $suantarih = date("Y-m-d H:i:s");
     $ekleyenbilgi = array(
        "ekleyen_id" => 1,
        "yetkili_id" => $_SESSION["oturum_bilgileri"]["kullanici_id"]
     );
     $site_ekle = $baglanti->prepare("INSERT INTO eklenen_siteler(site_adresi, site_tam_adresi, ekleyen, durum, eklenme_tarihi) VALUES (:site_adresi, :site_tam_adresi, :ekleyen, :tur, :eklenme_tarihi)");
     $site_ekle->bindParam(":site_adresi", $duzsiteadresi, PDO::PARAM_STR);
     $site_ekle->bindParam(":site_tam_adresi", $siteadresi, PDO::PARAM_STR);
     $site_ekle->bindParam(":ekleyen", json_encode($ekleyenbilgi), PDO::PARAM_STR);
     $site_ekle->bindParam(":tur", $tur, PDO::PARAM_INT);
     $site_ekle->bindParam(":eklenme_tarihi", $suantarih, PDO::PARAM_STR);

     try {
     $site_ekle->execute();
     discord_mesaj($siteadresi);
     $cikti = array(
        "id" => 4,
        "mesaj" => '<div class="form-group alert alert-dismissible alert-success" style="margin-top:20px;"><i class="fa fa-check"></i> '.htmlspecialchars($siteadresi).' adresi eklendi</div>'
    );
    die(json_encode($cikti));

     } catch(PDOException $v4hata) {
        $cikti = array(
            "id" => 5,
            "mesaj" => '<div class="form-group alert alert-dismissible alert-danger" style="margin-top:20px;"><i class="fa fa-times"></i> VERITABANI HATASI OLUŞTU! '.htmlspecialchars($siteadresi).' adresi eklenemedi</div>'
          );
        die(json_encode($cikti));     
     }

    }

}
?>