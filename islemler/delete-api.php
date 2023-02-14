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

    $sil = $baglanti->prepare("DELETE FROM eklenen_siteler WHERE id = :id");
    $sil->bindParam(":id", $site_id, PDO::PARAM_INT);

    try {
    $sil->execute();
    if(file_exists("log/".date("Y-m-d")."-bot-silinenler.json")) {
        $silinenler = json_decode(file_get_contents("log/".date("Y-m-d")."-bot-silinenler.json"), true);
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
            "ip_adresi" => gercek_ip()
        )
    ));
    $log = fopen("log/".date("Y-m-d")."-bot-silinenler.json", "x+");
    fwrite($log, json_encode($silinenler));
    fclose($log);

    $cikti = array(
        "id" => 1,
        "mesaj" => "Silindi"
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