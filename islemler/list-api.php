<?php
date_default_timezone_set("Europe/Istanbul");
error_reporting(0);
$directory = __DIR__;

header("Content-Type: text/plain");

$apikey = $_ENV["LIST_API_KEY"];
if($_GET["key"]!==$apikey) {
    die(json_encode(array("error_message" => "API KEY IS WRONG")));
}

if(!is_numeric($_GET["id"])) { exit; }

$sitelerlistele = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE durum = :durum order by id asc");
$sitelerlistele->bindParam(":durum", $_GET["id"], PDO::PARAM_INT);
$sitelerlistele->execute();

if($sitelerlistele->rowCount()) {
    foreach($sitelerlistele as $siteverisi) {
        echo $siteverisi["site_tam_adresi"]."
";
    }
}
?>