<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;
require('siniflar/usom.class.php');

header("Content-Type: application/json; charset=utf-8");

$apikey = $_ENV["API_KEY"];
if($_GET["key"]!==$apikey) {
    die(json_encode(array("error_message" => "API KEY IS WRONG")));
}

if(isset($_GET["site"])) {
    $siteadresi = $_GET["site"];
    $tur = 1;

    if(!is_numeric($tur)) { exit; }

    if(strstr($siteadresi, "http")) {
        $duzsiteadresi = parse_url($siteadresi)["host"];
    } else {
        $duzsiteadresi = $siteadresi;
    }

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
            "mesaj" => ''.htmlspecialchars($siteadresi).' adresi daha önce '.htmlspecialchars($site_eklenme_tarihi).' tarihinde eklenmiştir'
          );
        die(json_encode($cikti));
    } else {

    $kontrol = \usom::check($duzsiteadresi, 1);

    if($kontrol["status"]==0) {
        $cikti = array(
            "id" => 3,
            "mesaj" => ''.htmlspecialchars($siteadresi).' adresi USOM listesinde bulunuyor'
          );
        die(json_encode($cikti));  
    } else {

     $suantarih = date("Y-m-d H:i:s");
     $ekleyenbilgi = array(
        "ekleyen_id" => 3
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
        "mesaj" => ''.htmlspecialchars($siteadresi).' adresi eklendi'
    );
    die(json_encode($cikti));  

     } catch(PDOException $v4hata) {
        $cikti = array(
            "id" => 5,
            "mesaj" => 'VERITABANI HATASI OLUŞTU! '.htmlspecialchars($siteadresi).' adresi eklenemedi'
          );
        die(json_encode($cikti));     
     }

    }

    }

}
?>