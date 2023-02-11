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

if(isset($_POST["kullanici_id"])) {
if(empty(trim($_POST["kullanici_id"]))) { exit; }
if(!is_numeric($_POST["kullanici_id"])) { exit; }

$kontrol = $baglanti->prepare("SELECT * FROM kullanicilar WHERE id = :id");
$kontrol->bindParam(":id", $_POST["kullanici_id"], PDO::PARAM_INT);
$kontrol->execute();

if(!$kontrol->rowCount()) {
$cikti = array(
    "id" => 1,
    "mesaj" => "Yasaklanamadı, böyle bir id veritabanında yok."
);
die(json_encode($cikti));
} else {
    foreach($kontrol as $kullaniciverisi) {
        $k_yetki_seviyesi = $kullaniciverisi["yetki_seviyesi"];
    }
}

if($k_yetki_seviyesi==2) { 
    $cikti = array(
        "id" => 2,
        "mesaj" => "Yasaklanamadı, bu kullanıcıya yetkiniz bulunmuyor."
    );
    die(json_encode($cikti));  
}

$guncelle = $baglanti->prepare("UPDATE kullanicilar SET yetki_seviyesi = 0 WHERE id = :id");
$guncelle->bindParam(":id", $_POST["kullanici_id"], PDO::PARAM_INT);

try {
$guncelle->execute();
$cikti = array(
    "id" => 1,
    "mesaj" => "Yasaklandı"
);
die(json_encode($cikti));
} catch(PDOException $v4hata) {
$cikti = array(
    "id" => 3,
    "mesaj" => "Yasaklanamadı, hata:".$v4hata->getMessage()
);
die(json_encode($cikti));
}

}
?>