<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;
if($inc!=1) { die(); }
header("Content-Type: application/json; charset=utf-8");

if($_SESSION["oturum_durum"]!=1) {
    die();
}

if($kullanici_yetkisi==0) {
session_destroy();  
}

if(isset($_POST["eski_parola"])) {
    if(empty(trim($_POST["eski_parola"] and $_POST["yeni_parola"] and $_POST["yeni_parola_dogrula"]))) { exit; }

    if(sifrele($_POST["eski_parola"])!=$kullanici_parola) {
    $cikti = array(
        "id" => 1,
        "mesaj" => "Eski parola hatalı."
    );
    die(json_encode($cikti));  
    }

    if($_POST["yeni_parola"]!=$_POST["yeni_parola_dogrula"]) {
    $cikti = array(
        "id" => 2,
        "mesaj" => "Parolalarınız eşleşmiyor."
    );
    die(json_encode($cikti));
    }

    if(strlen($_POST["yeni_parola"])<8) {
    $cikti = array(
        "id" => 5,
        "mesaj" => "Yeni parolanız 8 karakterden kısa olamaz."
    );
    die(json_encode($cikti));  
    }

    $yeni_parola = sifrele($_POST["yeni_parola"]);

    $guncelle = $baglanti->prepare("UPDATE kullanicilar SET parola = :yeniparola WHERE id = :id");
    $guncelle->bindParam(":yeniparola", $yeni_parola, PDO::PARAM_STR);
    $guncelle->bindParam(":id", $_SESSION["oturum_bilgileri"]["kullanici_id"], PDO::PARAM_INT);

    try {
    $guncelle->execute();
    $cikti = array(
        "id" => 3,
        "mesaj" => "Güncellendi"
    );
    die(json_encode($cikti));
    } catch(PDOException $v4hata) {
    $cikti = array(
        "id" => 4,
        "mesaj" => "Güncellenemedi, hata:".$v4hata->getMessage()
    );
    die(json_encode($cikti));
    }
}
?>