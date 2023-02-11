<?php
error_reporting(0);
if($inc!=1) { die(); }
if($_SESSION["oturum_durum"]==0) {
    header("Location: /".$sayfa_isimleri["giris-yap"]);
    die();
}

$ekbaslik = "Hesap Ayarları";
$menuadi = "hesapayarlari";
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
          <h1><i class="fa fa-cog"></i> Hesap Ayarları</h1>
        </div>
      </div>
      <div class="row">


      <div class="col-md-12">
          <div class="tile">
          <h3 class="tile-title">Bilgi Değiştirme</h3>
            <div class="tile-body">
              <form action="javascript:void(0)" id="bilgidegistirform">
                <div class="form-group">
                  <label class="control-label">Discord ID</label>
                  <input class="form-control" name="discord_id" rows="4" placeholder="discordid#0000" value="<?php echo htmlspecialchars($kullanici_discordid, ENT_QUOTES) ?>" required>
                </div>
            </div>
            <div class="tile-footer">
              <button class="btn btn-success" type="submit" id="bguncellebtn"><i class="fa fa-fw fa-lg fa-edit"></i> Güncelle</button>
            </div>
            </form>

        </div>
        </div>

      <div class="col-md-12">
          <div class="tile">
          <h3 class="tile-title">Parola Değiştirme</h3>
            <div class="tile-body">
              <form action="javascript:void(0)" id="paroladegistirform">
                <div class="form-group">
                  <label class="control-label">Eski Parola</label>
                  <input class="form-control" type="password" name="eski_parola" rows="4" placeholder="***********" required>
                </div>
                <div class="form-group">
                  <label class="control-label">Yeni Parola</label>
                  <input class="form-control" type="password" name="yeni_parola" rows="4" placeholder="***********" required>
                </div>
                <div class="form-group">
                  <label class="control-label">Yeni Parola(Doğrulama)</label>
                  <input class="form-control" type="password" name="yeni_parola_dogrula" rows="4" placeholder="***********" required>
                </div>
            </div>
            <div class="tile-footer">
              <button class="btn btn-success" type="submit" id="pguncellebtn"><i class="fa fa-fw fa-lg fa-edit"></i> Güncelle</button>
            </div>
            </form>

        </div>
        </div>
      </div>
    </main>
<script type="text/javascript">var menuadi = "<?php echo htmlspecialchars($menuadi) ?>";</script>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
<script type="text/javascript">
    $("a[menuadi="+menuadi+"]").attr("class", "app-menu__item active");

    $("#bilgidegistirform").submit(function() {
    $("#bguncellebtn").prop("disabled", true);
    $("#bguncellebtn").html('<i class="fa fa-spinner fa-spin"></i>');

    $.post("/postV4/bilgi-degistir", $("#bilgidegistirform").serialize(), function(cikti) {
        if(cikti.id==1) {
            $("#bguncellebtn").html('<i class="fa fa-check"></i> Güncellendi');
        } else {
        alert(cikti.mesaj);
        }
    });

    setTimeout(function() {
    $("#bguncellebtn").html('<i class="fa fa-fw fa-lg fa-edit"></i> Güncelle');
    $("#bguncellebtn").prop("disabled", false);
    }, 700);
    });

    $("#paroladegistirform").submit(function() {
    $("#pguncellebtn").prop("disabled", true);
    $("#pguncellebtn").html('<i class="fa fa-spinner fa-spin"></i>');

    $.post("/postV4/parola-degistir", $("#paroladegistirform").serialize(), function(cikti) {
        if(cikti.id==4) {
            $("#pguncellebtn").html('<i class="fa fa-check"></i> Güncellendi');
        } else {
        alert(cikti.mesaj);
        }
    });

    setTimeout(function() {
    $("#pguncellebtn").html('<i class="fa fa-fw fa-lg fa-edit"></i> Güncelle');
    $("#pguncellebtn").prop("disabled", false);
    }, 700);
    });
    </script>
  </body>
</html>