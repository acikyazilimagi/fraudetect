<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;

header("Content-Type: application/json; charset=utf-8");

$apikey = $_ENV["API_KEY"];
if($_GET["key"]!==$apikey) {
    die(json_encode(array("error_message" => "API KEY IS WRONG")));
}

if(isset($_GET["site"])) {
    $siteadresi = $_GET["site"];

    if(strstr($siteadresi, "http")) {
        $duzsiteadresi = parse_url($siteadresi)["host"];
    } else {
        $duzsiteadresi = $siteadresi;
    }

    $sitesorgu = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE site_adresi = :siteadresi");
    $sitesorgu->bindParam(":siteadresi", $duzsiteadresi, PDO::PARAM_STR);
    $sitesorgu->fetchAll(PDO::FETCH_ASSOC);
    $sitesorgu->execute();

    if(!$sitesorgu->rowCount()) {
    $cikti = array(
        "id" => 2,
        "mesaj" => 'Site veritabanında bulunamadı'
    );
    die(json_encode($cikti));
    } else {
    foreach($sitesorgu as $siteveri) {
        $site_id = $siteveri["id"];
    }

    $guncelle = $baglanti->prepare("UPDATE eklenen_siteler SET durum = 3 WHERE id = :id");
    $guncelle->bindParam(":id", $site_id, PDO::PARAM_INT);

     try {
     $guncelle->execute();
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
?>