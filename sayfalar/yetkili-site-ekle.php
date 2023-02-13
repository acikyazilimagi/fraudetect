<?php
error_reporting(0);
if($inc!=1) { die(); }
if($_SESSION["oturum_durum"]==0) {
    header("Location: /".$sayfa_isimleri["giris-yap"]);
    die();
}

$ekbaslik = "Yetkili Site Ekle";
$menuadi = "toplusiteekle";
?>
<!DOCTYPE html>
<html>
<?php include("yonergeler/head.php") ?>

<body class="app sidebar-mini">
    <header class="app-header">
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    </header>
<?php include("yonergeler/aside.php") ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-plus"></i> Yetkili Site Ekle</h1>
        </div>
      </div>
      <div class="row">

      <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <form action="javascript:void(0)" id="topluekleform">
                <div class="form-group">
                  <label class="control-label">Tür</label>
                  <select class="form-control" id="tur">
                    <option value="2">Şüpheli</option>
                    <option value="3">Fraud</option>
                    <option value="4">Whitelist</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Site Listesi(alt alta olmalıdır)</label>
                  <textarea class="form-control" id="siteler" rows="4" placeholder="ornek.com
https://ornek.net/test/" style="height: 198px;" required></textarea>
                </div>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit" id="baslatbtn"><i class="fa fa-fw fa-lg fa-play"></i> Başlat</button>
              <a onclick="location.reload()" class="btn btn-info" id="yenilebtn" style="color:white;display:none;"><i class="fa fa-fw fa-lg fa-refresh"></i> Yenile</a>
            </div>
            </form>
            <div id="bilgi_listesi" style="display:none;">
            <div class="form-group alert alert-dismissible alert-info" style="margin-top:20px; font-weight:bold;"><i class="fa fa-info-circle"></i> Eklenen: <span id="gonderilen">0</span>/<span id="toplam">200</span></div>
            </div>  

        </div>
        </div>
      </div>
    </main>
<script type="text/javascript">var menuadi = "<?php echo htmlspecialchars($menuadi) ?>";</script>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
<script type="text/javascript">
    $("a[menuadi="+menuadi+"]").attr("class", "app-menu__item active");

    $("#topluekleform").submit(function() {
    $("#baslatbtn").prop("disabled", true);
    $("#baslatbtn").html('<i class="fa fa-spinner fa-spin"></i>');
    var siteler = $("#siteler").val();
    var siteler_bol = siteler.split("\n");
    var eklenme_turu = $("#tur option:selected").val();
    $("#toplam").html(siteler_bol.length);
    $("#bilgi_listesi").show();

    var sira = 0;
    for(i=0; i<siteler_bol.length; i++) {
    (function(i){
    setTimeout(function() {
    $.post("/postV4/site-ekle", {"site":siteler_bol[i], "tur":eklenme_turu}, function(cikti) {
    $("#bilgi_listesi").append(cikti.mesaj);
    sira++;
    $("#gonderilen").html(sira);
    if($("#toplam").html()==sira) {
    $("#baslatbtn").remove();
    }
    });
    $("#yenilebtn").show();
    }, 3000);
    });
    }
    });
    </script>
  </body>
</html>
