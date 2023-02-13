<?php
error_reporting(0);
if ($inc != 1) {
  die();
}
if ($_SESSION["oturum_durum"] == 0) {
  header("Location: /" . $sayfa_isimleri["giris-yap"]);
  die();
}

if ($kullanici_yetkisi != 2) {
  exit;
}

$ekbaslik = "Yetkili Ayarlari";
$menuadi = "yetkiliayarlari";

if ($_GET["sayfa"]) {
  if (!is_numeric($_GET["sayfa"])) {
    exit;
  }
}

if (empty(trim($_GET["sayfa"]))) {
  $gosterilecek_sayfa = 1;
} else {
  $gosterilecek_sayfa = $_GET["sayfa"];
}

$gosterilecek = 10;
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
        <h1><i class="fa fa-user-plus"></i> Yetkili Ayarları</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Yetkililer <a class="btn btn-info btn-sm" onclick="$('#ekle').show()" style="color:white;margin-left:5px;"><i class="fa fa-plus"></i> Yetkili Ekle</a></h3>

          <div class="d-flex justify-content-center" style="margin-top:10px;">
            <div class="col-md-5" id="duzenle" style="display:none;">
              <div class="tile">
                <div class="tile-body">
                  <form action="javascript:void(0)" id="duzenleform">
                    <input type="hidden" name="kullanici_id" value="">
                    <div class="form-group">
                      <label class="control-label">Yeni Parola</label>
                      <input class="form-control" type="text" id="kullanici_adi" value="" disabled>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Yeni Parola</label>
                      <input class="form-control" type="password" placeholder="*********" name="yeni_parola" value="" required>
                    </div>
                </div>
                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="guncellebtn"><i class="fa fa-fw fa-lg fa-check"></i> Güncelle</button>
                  <button onclick="yasakla(0)" class="btn btn-danger" type="button" id="yasaklabtn"><i class="fa fa-fw fa-lg fa-ban"></i> Yasakla</button>
                </div>
                </form>

              </div>
            </div>
          </div>


          <div class="d-flex justify-content-center" style="margin-top:10px;">
            <div class="col-md-5" id="ekle" style="display:none;">
              <div class="tile">
                <div class="tile-body">
                  <form action="javascript:void(0)" id="ekleform">
                    <input type="hidden" name="kullanici_id" value="">
                    <div class="form-group">
                      <label class="control-label">Kullanıcı Adı</label>
                      <input class="form-control" type="text" name="kullanici_adi" value="">
                    </div>
                    <div class="form-group">
                      <label class="control-label">Parola</label>
                      <input class="form-control" type="password" placeholder="*********" name="parola" value="" required>
                    </div>
                    <div class="form-group">
                      <label class="control-label">İsim</label>
                      <input class="form-control" type="text" name="isim" value="" required>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Discord ID</label>
                      <input class="form-control" type="text" name="discord_id" value="" required>
                    </div>
                </div>
                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="eklebtn"><i class="fa fa-fw fa-lg fa-plus"></i> Ekle</button>
                </div>
                </form>

              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kullanıcı Adı</th>
                  <th>İsim</th>
                  <th>Discord ID</th>
                  <th>Yetki Seviyesi</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $toplamkullanicilar = $baglanti->prepare("SELECT * FROM kullanicilar order by id asc");
                $toplamkullanicilar->execute();
                $sayfa_sayisi = ceil($toplamkullanicilar->rowCount() / $gosterilecek);

                $ilk_kayit = ($gosterilecek_sayfa * $gosterilecek) - $gosterilecek;
                $kullanicilar = $baglanti->prepare("SELECT * FROM kullanicilar order by id asc limit :ilk_kayit, :gosterilecek");
                $kullanicilar->bindParam(":ilk_kayit", $ilk_kayit, PDO::PARAM_INT);
                $kullanicilar->bindParam(":gosterilecek", $gosterilecek, PDO::PARAM_INT);

                $kullanicilar->fetchAll(PDO::FETCH_ASSOC);
                $kullanicilar->execute();

                if ($kullanicilar->rowCount()) {
                  foreach ($kullanicilar as $kullaniciveri) {

                    if ($kullaniciveri["yetki_seviyesi"] == 1) {
                      $seviye = "Reporter";
                      $seviyeicon = "fa fa-user";
                      $renk = "secondary";
                    } elseif ($kullaniciveri["yetki_seviyesi"] == 2) {
                      $seviye = "Administrator";
                      $seviyeicon = "fa fa-user-plus";
                      $renk = "info";
                    } elseif ($kullaniciveri["yetki_seviyesi"] == 0) {
                      $seviye = "Yasaklı";
                      $seviyeicon = "fa fa-ban";
                      $renk = "danger";
                      $yasakliappend = "<del>";
                      $yasakliappendend = "</del>";
                    } else {
                      $yasakliappend = null;
                      $yasakliappend = null;
                    }

                    echo '<tr id="' . htmlspecialchars($kullaniciveri["id"]) . '_kullanici">
                        <td>' . htmlspecialchars($kullaniciveri["id"]) . '</td>
                        <td>' . $yasakliappend . '' . htmlspecialchars($kullaniciveri["kullaniciadi"]) . '' . $yasakliappendend . '</td>
                        <td>' . $yasakliappend . '' . htmlspecialchars($kullaniciveri["isim"]) . '' . $yasakliappendend . '</td>
                        <td>' . $yasakliappend . '' . htmlspecialchars($kullaniciveri["discordid"]) . '' . $yasakliappendend . '</td>
                        <td><a href="#" class="btn btn-' . $renk . ' btn-sm"><i class="' . $seviyeicon . '"></i> ' . $seviye . '</a></td>
                        <td><a href="#duzenle" onclick="duzenle(';
                    echo "'" . htmlspecialchars($kullaniciveri["id"], ENT_QUOTES) . "', '" . htmlspecialchars($kullaniciveri["kullaniciadi"], ENT_QUOTES) . "')" . '"';
                    echo 'style="color:white;" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i> Düzenle</a></td>
                      </tr>';
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="bs-component" style="margin-bottom: 15px;">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
              <div class="btn-group mr-2" role="group" aria-label="First group">
                <?php
                if ($_GET["durum"]) {
                  $durumappend = "durum=" . htmlspecialchars($_GET["durum"]) . "&";
                }
                for ($i = 1; $i <= $sayfa_sayisi; $i++) {
                  if ($i == $gosterilecek_sayfa) {
                    echo '<a href="?' . $durumappend . 'sayfa=' . $i . '" class="btn btn-info">' . $i . '</a>';
                  } else {
                    echo '<a href="?' . $durumappend . 'sayfa=' . $i . '" class="btn btn-secondary">' . $i . '</a>';
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>


  </main>
  <script type="text/javascript">
    var menuadi = "<?php echo htmlspecialchars($menuadi) ?>";
  </script>
  <script src="js/jquery.min.js" type="text/javascript"></script>
  <script src="js/main.js" type="text/javascript"></script>
  <script type="text/javascript">
    $("a[menuadi=" + menuadi + "]").attr("class", "app-menu__item active");

    function duzenle(id, kullaniciadi) {
      $("#duzenle").show();
      $("#kullanici_adi").val(kullaniciadi);
      $("input[name=kullanici_id]").val(id);
      $("#yasaklabtn").attr("onclick", "yasakla(" + id + ", 2)");
    }


    $("#duzenleform").submit(function() {
      $("#guncellebtn").prop("disabled", true);
      $.post("/postV4/kullanici-duzenle", $("#duzenleform").serialize(), function(cikti) {
        if (cikti.id == 1) {
          alert("Kullanıcı güncellendi");
          location.reload();
        } else {
          alert(cikti.mesaj);
          $("#guncellebtn").prop("disabled", false);
        }
      });
    });

    $("#ekleform").submit(function() {
      $("#eklebtn").prop("disabled", true);
      $.post("/postV4/kullanici-ekle", $("#ekleform").serialize(), function(cikti) {
        if (cikti.id == 1) {
          alert("Kullanıcı eklendi");
          location.reload();
        } else {
          alert(cikti.mesaj);
          $("#eklebtn").prop("disabled", false);
        }
      });
    });

    function yasakla(id, akabin) {
      $.post("/postV4/kullanici-yasakla", {
        "kullanici_id": id
      }, function(cikti) {
        if (cikti.id == 1) {
          alert("Yasaklandı!");
          location.reload();
        } else {
          alert(cikti.mesaj);
        }
      })
    }
  </script>
</body>

</html>