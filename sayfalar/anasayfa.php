<?php if($inc!=1) { die(); } ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="description" content="Fraudetect.net, afetler sonrasında halkımızın samimi duygularını suistimal eden kötü niyetli insanların engellenmesi amacıyla kurulmuş bir topluluk hizmetidir.">
<meta property="og:title" content="Fraud Detect  - Şüpheli Adres Bildirimi">
<meta property="og:description" content="Fraudetect.net, afetler sonrasında halkımızın samimi duygularını suistimal eden kötü niyetli insanların engellenmesi amacıyla kurulmuş bir topluluk hizmetidir.">
<meta property="og:type" content="website" />
<meta property="og:url" content="https://fraudetect.net">
<meta property="og:image" content="https://fraudetect.net/img/sosyal.svg">
<meta property="og:locale" content="tr_TR">
<title>Fraud Detect  - Şüpheli Adres Bildirimi</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="form-v4">
<div class="page-content">
<div class="form-v4-content">
<div class="form-left">
<h2><i class="fa fa-info-circle"></i> BILGILENDIRME</h2>
<p class="text-1"><strong>Fraudetect.net</strong>, afetler sonrasında halkımızın samimi duygularını suistimal eden kötü niyetli insanların engellenmesi amacıyla kurulmuş bir topluluk hizmetidir.</p>
<p class="text-2">Şikayet edebileceğiniz adres, hesap türleri: <strong>sahte bağış toplama</strong>, <strong>dolandırıcılık</strong>, <strong>bankacılık/oltalama</strong> ve benzeri.</p>
</div>
<form class="form-detail" action="javascript:void(0)" id="reportForm">
<h2>ADRES BİLDİR</h2>
<div class="form-row">
<label for="your_email"><i class="fa fa-link"></i> Şüpheli Adres</label>
<input type="text" name="site" class="input-text" value="" placeholder="https://supheli.adres" required autocomplete="off">
</div>
<div class="form-row-last" style="display:flex; justify-content:center;">
<button type="submit" name="bildir" class="register" id="bildirbtn"><i class="fa fa-plus-circle"></i> Bildir</button>
</div>
<div class="alert" id="hata" style="display:none;"><i class="fa fa-exclamation-circle"></i> Hata: <span id="hata_mesaji"></span></div>
<div class="form-row-last">
<a href="https://discord.gg/itdepremyardim" rel="nofollow" class="discord"><i class="fab fa-discord"></i></a>
<a href="https://github.com/" rel="nofollow" class="github" style="margin-left:5px;"><i class="fab fa-github"></i></a>
</div>
</form>
</div>
</div>
<script src="/js/jquery.min.js" type="text/javascript"></script>
<script src="/js/anasayfa.js" type="text/javascript"></script>
</body>
</html>