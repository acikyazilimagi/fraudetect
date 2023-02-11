<?php
error_reporting(0);
if($inc!=1) { die(); }
if($_SESSION["oturum_durum"]==1) {
    header("Location: /panel");
    die();
}

$ekbaslik = "Giriş Yap";
?>
<!DOCTYPE html>
<html>
<?php include("yonergeler/head.php") ?>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="login-box">
        <form class="login-form" action="javascript:void(0)" id="girisform">
          <h3 class="login-head" style="margin-top:30px;"><i class="fa fa-lg fa-fw fa-user"></i></h3>
          <div class="form-group">
            <label class="control-label">KULLANICI ADI</label>
            <input class="form-control" type="text" name="kullaniciadi" placeholder="Kullanıcı Adı" value="<?php if($_COOKIE["kullaniciadi"]) { echo htmlspecialchars($_COOKIE["kullaniciadi"]); } ?>" autofocus required>
          </div>
          <div class="form-group">
            <label class="control-label">PAROLA</label>
            <input class="form-control" type="password" name="parola" placeholder="Parola" required>
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox" id="beni_hatirla"><span class="label-text">Beni Hatırla</span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" id="girisyapbtn"><i class="fa fa-sign-in fa-lg fa-fw"></i>GİRİŞ YAP</button>
          </div>
          <div class="form-group alert alert-dismissible alert-danger" id="hata" style="margin-top:20px; display:none;"></div>
        </form>
      </div>
    </section>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    <?php if($_COOKIE["kullaniciadi"]) {
    ?>
    $("#beni_hatirla").click();
    <?php
    }
    ?>
    $("#girisform").submit(function() {
    $("#girisyapbtn").prop("disabled", true);
    var data = $("#girisform").serialize();
    $.post("/postV4/giris-yap", data, function(cikti) {
        if(cikti.id==1) {
            if($("#beni_hatirla:checked").length==1) {
                document.cookie = "kullaniciadi="+$("input[name=kullaniciadi]").val()+"; path=/;";
            }
            window.location = "/panel";
        } else {
            $("#hata").show();
            $("#hata").html('<i class="fa fa-times"></i> '+cikti.mesaj);
        }
        $("#girisyapbtn").prop("disabled", false);
    });
    });
    </script>
  </body>
</html>