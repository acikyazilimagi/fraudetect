<?php
sleep(1);
error_reporting(0);
if($inc!=1) { die(); }
header("Content-Type: application/json; charset=utf-8");
if(isset($_POST["kullaniciadi"])) {

    if(empty(trim($_POST["kullaniciadi"] and $_POST["parola"]))) {
        $cikti = array(
            "id" => 1,
            "mesaj" => null
          );
        die(json_encode($cikti));
    }

    if($_SESSION["oturum_durum"]==1) {
      die();
    }

    $kullaniciadi = $_POST["kullaniciadi"];
    $parola = $_POST["parola"];

    $kullanicikontrol = $baglanti->prepare("SELECT * FROM kullanicilar where kullaniciadi = :kullaniciadi");
    $kullanicikontrol->bindParam(":kullaniciadi", $kullaniciadi, PDO::PARAM_STR);
    $kullanicikontrol->fetchAll(PDO::FETCH_ASSOC);
    $kullanicikontrol->execute();

    if($kullanicikontrol->rowCount()) {
    foreach($kullanicikontrol as $kullaniciveri) {
    $kullanici_id = $kullaniciveri["id"];
    $kullanici_parola = $kullaniciveri["parola"];
    $kullanici_yetki_seviyesi = $kullaniciveri["yetki_seviyesi"];
    }

    if($kullanici_yetki_seviyesi==0) {
        $cikti = array(
            "id" => 3,
            "mesaj" => "Sistem tarafından yasaklandınız."
          );
        die(json_encode($cikti));
    }

    $sifreliparola = sifrele($parola);

    if($kullanici_parola!=$sifreliparola) {
    $cikti = array(
        "id" => 2,
        "mesaj" => 'Kullanıcı adı veya parola hatalı.'
    );
    die(json_encode($cikti));   
    } else {

    //oturum oluştur
    $bss = strtotime("+2 hours");
    $oturum_sonsure = date("Y-m-d H:i:s", $bss);
    $_SESSION["oturum_durum"] = 1;
    $_SESSION["oturum_bilgileri"] = array(
        "kullanici_id" => $kullanici_id,
        "oturum_suresi" => $oturum_sonsure
    );

    $cikti = array(
        "id" => 1,
        "mesaj" => null
    );
    die(json_encode($cikti));   

    }

    } else {
        $cikti = array(
            "id" => 2,
            "mesaj" => "Kullanıcı adı veya parola hatalı."
          );
        die(json_encode($cikti));
    }

}
?>