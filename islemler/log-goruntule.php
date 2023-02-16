<?php
error_reporting(E_ALL);
date_default_timezone_set("Europe/Istanbul");

$apikey = getenv("API_KEY");
if($_GET["key"]!==$apikey) {
    die(json_encode(array("error_message" => "API KEY IS WRONG")));
}

if($_SESSION["oturum_bilgileri"]["kullanici_id"]!=1) { die(json_encode(array("error_message" => "ERİŞİM ENGELİ"))); }

if(empty(trim($_GET["tarih"]))) { $listelenen = "Bugün"; $goruntule = file_get_contents(date("log/".date("Y-m-d")."-silinenler.json")); } else { $listelenen = htmlspecialchars($_GET["tarih"]); $goruntule = file_get_contents(date("log/".htmlspecialchars($_GET["tarih"])."-silinenler.json")); }

echo "Listelenen tarih: ".$listelenen."<br><br>";
foreach(json_decode($goruntule, true) as $kayit) {
    echo "Silinen alan adı: ".htmlspecialchars($kayit["silinen_alan_adi"])."<br>
Silinen URL: ".htmlspecialchars($kayit["silinen_url"])."<br>
Durum: ".htmlspecialchars($kayit["durum"])."<br>
Eklenme tarihi: ".htmlspecialchars($kayit["silinen_url"])."<br>
Silen bilgisi: ".htmlspecialchars($kayit["silen_bilgi"]["kullanici_adi"])." - IP: ".htmlspecialchars($kayit["silen_bilgi"]["ip_adresi"])."
<hr>";
}
?>