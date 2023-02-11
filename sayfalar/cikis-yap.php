<?php
if($inc!=1) { die(); }
session_destroy();
header("Location: /".$sayfa_isimleri["giris-yap"]);
?>