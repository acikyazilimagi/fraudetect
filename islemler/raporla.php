<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;
if($inc!=1) { die(); }

require('siniflar/usom.class.php');
header("Content-Type: application/json; charset=utf-8");

if(isset($_POST["site"])) {
    if(empty(trim($_POST["site"]))) { exit; }

    $siteadresi = $_POST["site"];
    $tur = 1;

    if(strstr($siteadresi, "http")) {
        $duzsiteadresi = parse_url($siteadresi)["host"];
    } else {
        $duzsiteadresi = $siteadresi;
    }

    $duzsiteadresi = preg_replace('/\s+/', '', $duzsiteadresi);

    if(!filter_var(gethostbyname($duzsiteadresi), FILTER_VALIDATE_IP)) {
        $cikti = array(
            "id" => 1,
            "mesaj" => 'Adres hatalı veya çalışmadığı için eklenemedi'
            );
        die(json_encode($cikti));  
    }

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
            "mesaj" => 'Adres daha önce bildirilmiş'
          );
        die(json_encode($cikti));
    }
    }

    $kontrol = \usom::check($duzsiteadresi, 1);

    if($kontrol["status"]==0) {
        $cikti = array(
            "id" => 3,
            "mesaj" => 'Adres zaten Türkiye içerisinde engellenmiştir'
          );
        die(json_encode($cikti));  
    } else {

     $suantarih = date("Y-m-d H:i:s");
     $ekleyenbilgi = array(
        "ekleyen_id" => 2,
        "ip_adresi" => gercek_ip()
     );
     $site_ekle = $baglanti->prepare("INSERT INTO eklenen_siteler(site_adresi, site_tam_adresi, ekleyen, durum, eklenme_tarihi) VALUES (:site_adresi, :site_tam_adresi, :ekleyen, :tur, :eklenme_tarihi)");
     $site_ekle->bindParam(":site_adresi", $duzsiteadresi, PDO::PARAM_STR);
     $site_ekle->bindParam(":site_tam_adresi", $siteadresi, PDO::PARAM_STR);
     $site_ekle->bindParam(":ekleyen", json_encode($ekleyenbilgi), PDO::PARAM_STR);
     $site_ekle->bindParam(":tur", $tur, PDO::PARAM_INT);
     $site_ekle->bindParam(":eklenme_tarihi", $suantarih, PDO::PARAM_STR);

     try {
     $site_ekle->execute();
     $cikti = array(
        "id" => 4,
        "mesaj" => null
    );
    die(json_encode($cikti));

     } catch(PDOException $v4hata) {
        $cikti = array(
            "id" => 5,
            "mesaj" => null
          );
        die(json_encode($cikti));     
     }

    }

}
?>
