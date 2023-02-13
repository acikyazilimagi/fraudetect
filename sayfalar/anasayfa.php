<?php if($inc!=1) { die(); } ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Fraudetect.net, afetler sonrasında halkımızın samimi duygularını suistimal eden kötü niyetli insanların engellenmesi amacıyla kurulmuş bir topluluk hizmetidir.">
    <meta name="keywords" content="fraudetect, fraud detect, şüpheli adres bildirimi, zararlı adres bildirimi, adres bildir, site bildir">
    <meta property="og:title" content="Fraud Detect  - Şüpheli Adres Bildirimi">
    <meta property="og:description" content="Fraudetect.net, afetler sonrasında halkımızın samimi duygularını suistimal eden kötü niyetli insanların engellenmesi amacıyla kurulmuş bir topluluk hizmetidir.">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://fraudetect.net">
    <meta property="og:image" content="https://fraudetect.net/img/banner.png">
    <meta property="og:locale" content="tr_TR">
    <title>Fraud Detect - Şüpheli Adres Bildirimi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://leventemre.com/app/fraud-main.css">
</head>

<body translate="no">

    <div class="section">
        <div class="container">
            <div class="row full-height justify-content-center">
                <div class="col-12 text-center align-self-center py-5">
                    <div class="section pb-5 pt-5 pt-sm-2 text-center">
                        <a href="/anasayfa" style="color:white;">
                            <h1 class="mb-0 pb-3">FRAUDETECT</h1>
                        </a>
                        <div class="card-3d-wrap mx-auto">
                            <div class="card-3d-wrapper">
                                <div class="card-front">
                                    <div class="center-wrap">
                                        <div class="arayuz">
                                            <div class="adres-form">
                                                <form id="reportForm" action="javascript:void()">
                                                    <div class="section text-center">
                                                        <h4 class="mb-4 pb-3 adres-baslik">Adres Bildirimi</h4>
                                                        <div class="form-group">
                                                            <input type="text" name="site" class="form-style" placeholder="https://supheli.adres" autocomplete="off" required>
                                                            <i class="input-icon fa fa-link"></i>
                                                        </div>
                                                        <div><button type="submit" class="btn mt-4" id="bildirbtn"><i class="fa fa-plus-circle" style="margin-right:2px;"></i> bildir</button>
                                                            <div class="hata" id="hata_mesaji" style="display:none;"></div>
                                                        </div>
                                                        <div style="display:flex;justify-content:center;margin-top:2rem;">
                                                            <p class="mb-0 mt-4 text-center"><a href="https://github.com/acikkaynak/fraudetect" target="_blank" rel="nofollow" class="link">
                                                                    <h4><i class="fab fa-github"></i></h4>
                                                                </a></p>
                                                            <p class="mb-0 mt-4 text-center" style="margin-left:6px;"><a href="https://discord.gg/itdepremyardim" target="_blank" rel="nofollow" class="link">
                                                                    <h4><i class="fab fa-discord"></i></h4>
                                                                </a></p>
                                                        </div>
                                                        <div>
                                                            <div class="section text-center">
                                                                <div class="bilgi">
                                                                    <strong>Fraudetect.net</strong>, afetler sonrasında halkımızın samimi duygularını suistimal eden kötü niyetli insanların engellenmesi amacıyla kurulmuş bir topluluk hizmetidir.
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

</body>
<script src="/js/jquery.min.js" type="text/javascript"></script>
<script src="/js/mainpage.js" type="text/javascript"></script>

</html>