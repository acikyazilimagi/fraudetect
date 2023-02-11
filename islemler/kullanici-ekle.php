<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;
if($inc!=1) { die(); }
header("Content-Type: application/json; charset=utf-8");

if($_SESSION["oturum_durum"]!=1) {
    die();
}

if($kullanici_yetkisi!=2) {
die();
}

if(isset($_POST["kullanici_adi"])) {
if(empty(trim($_POST["kullanici_adi"] and $_POST["parola"] and $_POST["isim"] and $_POST["discord_id"]))) { exit; }

$kontrol = $baglanti->prepare("SELECT * FROM kullanicilar WHERE kullaniciadi = :kadi");
$kontrol->bindParam(":kadi", $_POST["kullanici_adi"], PDO::PARAM_STR);
$kontrol->execute();

if($kontrol->rowCount()) {
$cikti = array(
    "id" => 4,
    "mesaj" => "Eklenemedi, bu kullanıcı adı kullanılıyor."
);
die(json_encode($cikti));
}

$ekle = $baglanti->prepare("INSERT INTO kullanicilar(kullaniciadi, parola, isim, discordid, yetki_seviyesi) VALUES (:kullaniciadi, :parola, :isim, :discordid, 1)");
$ekle->bindParam(":kullaniciadi", $_POST["kullanici_adi"], PDO::PARAM_STR);
$ekle->bindParam(":isim", $_POST["isim"], PDO::PARAM_STR);
$ekle->bindParam(":discordid", $_POST["discord_id"], PDO::PARAM_STR);
$ekle->bindParam(":parola", sifrele($_POST["parola"]), PDO::PARAM_STR);

try {
$ekle->execute();
$cikti = array(
    "id" => 1,
    "mesaj" => "Eklendi"
);
die(json_encode($cikti));
} catch(PDOException $v4hata) {
$cikti = array(
    "id" => 3,
    "mesaj" => "Eklenemedi, hata:".$v4hata->getMessage()
);
die(json_encode($cikti));
}

}
?>