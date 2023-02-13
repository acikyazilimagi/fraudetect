<?php
error_reporting(0);
if ($inc != 1) {
    die();
}
$v4_sistem_ayarlar_pr = array(
    "sunucu" => $_ENV["MYSQL_HOST"],
    "veritabani" => $_ENV["MYSQL_NAME"],
    "kullanici" => $_ENV["MYSQL_USER"],
    "parola" => $_ENV["MYSQL_PASS"]
);

$baglanti = new PDO("mysql:host=" . $v4_sistem_ayarlar_pr["sunucu"] . ";port=3306;dbname=" . $v4_sistem_ayarlar_pr["veritabani"] . ";charset=utf8", $v4_sistem_ayarlar_pr["kullanici"], $v4_sistem_ayarlar_pr["parola"]);

try {
    $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $baglanti->setAttribute(PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT, false);
} catch (PDOException $v4hata) {
    die();
}
?>