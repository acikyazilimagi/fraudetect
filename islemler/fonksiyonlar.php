<?php
function sifrele($veri) {
        $veri = md5($veri);
        $veri = sha1($veri);
        $veri = md5(sha1($veri));
        $veri = sha1(md5($veri));
        $veri = hash("whirlpool", $veri);
        $veri = md5($veri);
        return $veri;
}

function discord_mesaj($site) {
    $webhookurl = getenv("DISCORD_WEB_HOOK");
    
    $timestamp = date("c", strtotime("now"));
    
    $json_data = json_encode([
    
        "content" => "**SCAM** - ".htmlspecialchars($site),
        
    
        "username" => "Alert",
    
    
        "tts" => false
    
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    
    
    $ch = curl_init($webhookurl);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    
    $response = curl_exec( $ch );
    
    curl_close($ch);
    
    return true;
}

function gercek_ip() {
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
       return $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
}
?>
