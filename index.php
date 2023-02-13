<?php
/* v4r1able */
session_start(); 
error_reporting(0);
date_default_timezone_set("Europe/Istanbul");

if ($_SERVER['REQUEST_URI'] == "/") {
    header("Location: /anasayfa");
    die();
}

$sayfa_adi = @$_GET["sayfa_adi_v"];
$inc = 1;
include("ayarlar/baglanti.php");
include("ayarlar/fonksiyonlar.php");

if(!file_exists("sayfalar/" . $sayfa_adi . ".php")) {
    include("sayfalar/404.php");
}

$sayfa_isimleri = array(
    "giris-yap" => "fraud-login"
);

if($_SESSION["oturum_durum"]==1) {
    
$kullanicibilgisi = $baglanti->prepare("SELECT * FROM kullanicilar WHERE id = :kid limit 1");
$kullanicibilgisi->bindParam(":kid", $_SESSION["oturum_bilgileri"]["kullanici_id"], PDO::PARAM_STR);
$kullanicibilgisi->fetchAll(PDO::FETCH_ASSOC);
$kullanicibilgisi->execute();

if($kullanicibilgisi->rowCount()) {
    foreach($kullanicibilgisi as $kullaniciveri) {
        $kullanici_adi = $kullaniciveri["kullaniciadi"];
        $kullanici_parola = $kullaniciveri["parola"];
        $kullanici_yetkisi = $kullaniciveri["yetki_seviyesi"];
        $kullanici_isim = $kullaniciveri["isim"];
        $kullanici_discordid = $kullaniciveri["discordid"];
    }
}

if($kullanici_yetkisi==0) {
session_destroy();  
}

}

function minify_v4($buffer)
{
    $search = array(
        '/\>[^\S ]+/s', 
        '/[^\S ]+\</s',  
        '/(\s)+/s'     
        );
    $replace = array(
        '>',
        '<',
        '\\1'
        );
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}
ob_start("minify_v4");

switch ($sayfa_adi) {

    case $sayfa_adi:
    include("sayfalar/" . $sayfa_adi . ".php");
    break;

    default:
    include("sayfalar/404.php");
    break;

}

ob_end_flush();
?>
