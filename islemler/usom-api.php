<?php
error_reporting(0);
date_default_timezone_set("Europe/Istanbul");
require('siniflar/usom.class.php');

$apikey = getenv("API_KEY");
if($_GET["key"]!==$apikey) {
    die(json_encode(array("error_message" => "API KEY IS WRONG")));
}

$inc = 1;
include("ayarlar/baglanti.php");

$fraudsiteler = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE durum = 3 order by id asc");
$fraudsiteler->fetchAll(PDO::FETCH_ASSOC);
$fraudsiteler->execute();

if($fraudsiteler->rowCount()) {
    foreach($fraudsiteler as $siteveri) {
        $kontrol = \usom::check($siteveri["site_adresi"], 1);

        if($kontrol["status"]==0) {
            $guncelle = $baglanti->prepare("UPDATE eklenen_siteler SET durum = 5 WHERE id = :id");
            $guncelle->bindParam(":id", $siteveri["id"], PDO::PARAM_INT);
            $guncelle->execute();
        }
    }
}
?>
