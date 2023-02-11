<?php
error_reporting(0);
if($inc!=1) { die(); }
if($_SESSION["oturum_durum"]==0) {
    header("Location: /".$sayfa_isimleri["giris-yap"]);
    die();
}

$ekbaslik = "Cloacker Tespiti";
$menuadi = "cloackertespit";
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
              <form action="javascript:void(0)" id="cloackerform">
              <div class="form-group">
                  <label class="control-label">Referans</label>
                  <select name="referans" class="form-control">
                    <option value="https://www.google.com">Google</option>
                    <option value="https://twitter.com">Twitter</option>
                    <option value="https://instagram.com">İnstagram</option>
                    <option value="https://yandex.com">Yandex</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label">Site Adresi(HTTP-HTTPS olmalıdır)</label>
                  <input class="form-control" id="site" name="site" rows="4" placeholder="https://ornek.net/test/" required>
                </div>
            </div>
            <div class="tile-footer">
              <button class="btn btn-primary" type="submit" id="baslatbtn"><i class="fa fa-fw fa-lg fa-play"></i> Çalıştır</button>
            </div>
            </form>
            <div id="cikti" style="margin-top:5px;display:none;"> 
            <pre id="cloacker_bilgi"></pre>
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
    $("#araclar").click();
    $("#araclar").attr("class", "app-menu__item active");

    $("#cloackerform").submit(function() {
    $("#baslatbtn").prop("disabled", true);
    $("#baslatbtn").html('<i class="fa fa-spinner fa-spin"></i>');
    var site = $("#site").val();
    $("#cikti").show();

    $.post("/postV4/cloacker-tespit", $("#cloackerform").serialize(), function(cikti) {
        $("#cloacker_bilgi").html(cikti.header);
    });

    $("#baslatbtn").html('<i class="fa fa-fw fa-lg fa-play"></i> Çalıştır');
    $("#baslatbtn").prop("disabled", false);
    });
    </script>
  </body>
</html>