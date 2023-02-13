<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;
if ($inc != 1) {
    die();
}
header("Content-Type: application/json; charset=utf-8");

if ($_SESSION["oturum_durum"] != 1) {
    die();
}

if ($kullanici_yetkisi != 2) {
    die();
}

if (isset($_POST["kullanici_id"])) {
    if (empty(trim($_POST["kullanici_id"] and $_POST["yeni_parola"]))) {
        exit;
    }
    if (!is_numeric($_POST["kullanici_id"])) {
        exit;
    }

    $kontrol = $baglanti->prepare("SELECT * FROM kullanicilar WHERE id = :id");
    $kontrol->bindParam(":id", $_POST["kullanici_id"], PDO::PARAM_INT);
    $kontrol->execute();

    if (!$kontrol->rowCount()) {
        $cikti = array(
            "id" => 1,
            "mesaj" => "Güncellenemedi, böyle bir id veritabanında yok."
        );
        die(json_encode($cikti));
    } else {
        foreach ($kontrol as $kullaniciverisi) {
            $k_yetki_seviyesi = $kullaniciverisi["yetki_seviyesi"];
        }
    }

    if ($k_yetki_seviyesi == 2) {
        $cikti = array(
            "id" => 2,
            "mesaj" => "Güncellenemedi, bu kullanıcıya yetkiniz bulunmuyor."
        );
        die(json_encode($cikti));
    }

    $guncelle = $baglanti->prepare("UPDATE kullanicilar SET parola = :yeniparola WHERE id = :id");
    $guncelle->bindParam(":yeniparola", sifrele($_POST["yeni_parola"]), PDO::PARAM_STR);
    $guncelle->bindParam(":id", $_POST["kullanici_id"], PDO::PARAM_INT);

    try {
        $guncelle->execute();
        $cikti = array(
            "id" => 1,
            "mesaj" => "Güncellendi"
        );
        die(json_encode($cikti));
    } catch (PDOException $v4hata) {
        $cikti = array(
            "id" => 3,
            "mesaj" => "Güncellenemedi, hata:" . $v4hata->getMessage()
        );
        die(json_encode($cikti));
    }
}
?>