<?php
error_reporting(0);
if ($inc != 1) {
  die();
}
if ($_SESSION["oturum_durum"] == 0) {
  header("Location: /" . $sayfa_isimleri["giris-yap"]);
  die();
}

if ($_GET["durum"]) {
  if (!is_numeric($_GET["durum"])) {
    exit;
  }
}

$menuadi = "arayuz";

$eklenen_siteler_pending = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE durum = 1");
$eklenen_siteler_pending->execute();
$eklenen_siteler_supheli = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE durum = 2");
$eklenen_siteler_supheli->execute();
$eklenen_siteler_fraud = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE durum = 3");
$eklenen_siteler_fraud->execute();
$eklenen_siteler_fraud_usom = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE durum = 5");
$eklenen_siteler_fraud_usom->execute();

$eklenen_siteler = $baglanti->prepare("SELECT * FROM eklenen_siteler");
$eklenen_siteler->execute();

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
  <!-- Navbar-->
  <header class="app-header">
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <ul class="app-nav">
      <form action="" method="GET">
        <li class="app-search">
          <input class="app-search__input" type="search" name="arama" placeholder="Site araması yap" value="<?php if ($_GET["arama"]) {
                                                                                                              echo htmlspecialchars($_GET["arama"], ENT_QUOTES);
                                                                                                            } ?>" required>
          <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>
      </form>
    </ul>
  </header>
  <?php include("yonergeler/aside.php") ?>
  <main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="fa fa-dashboard"></i> Arayüz</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-list fa-3x"></i>
          <div class="info">
            <h4>Toplam</h4>
            <p><b><?php echo htmlspecialchars(number_format($eklenen_siteler->rowCount())) ?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-clock-o fa-3x"></i>
          <div class="info">
            <h4>Bekleyen</h4>
            <p><b><?php echo htmlspecialchars(number_format($eklenen_siteler_pending->rowCount())) ?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-link fa-3x"></i>
          <div class="info">
            <h4>Şüpheli</h4>
            <p><b><?php echo htmlspecialchars(number_format($eklenen_siteler_supheli->rowCount())) ?></b></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
          <div class="info">
            <h4>Fraud</h4>
            <p><b style="color:red;"><?php echo htmlspecialchars(number_format($eklenen_siteler_fraud->rowCount())) ?></b><b>/<?php echo htmlspecialchars(number_format($eklenen_siteler_fraud_usom->rowCount())) ?></b></p>
          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="col-md-12">
        <div class="tile">
          <h3 class="tile-title">Eklenen Siteler <a onclick="location.reload()" style="cursor:pointer; color:#17a2b8;"><i class="fa fa-refresh"></i></a></h3>
          <div style="margin-bottom:8px; text-align:center;">
            <a href="?durum=1" class="btn btn-warning"><i class="fa fa-clock-o"></i> PENDING<?php if ($_GET["durum"] == 1) {
                                                                                              echo " - LISTELENIYOR";
                                                                                            } ?></a><a href="?durum=2" class="btn btn-secondary" style="margin-left:5px;"><i class="fa fa-user-secret"></i> ŞÜPHELİ<?php if ($_GET["durum"] == 2) {
                                                                                                                                                                                                                                                                            echo " - LISTELENIYOR";
                                                                                                                                                                                                                                                                          } ?></a><a href="?durum=3" class="btn btn-danger" style="margin-left:5px;"><i class="fa fa-times-circle"></i> FRAUD<?php if ($_GET["durum"] == 3) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " - LISTELENIYOR";
                                                                                                                                                                                                                                                                                                                                                                                                                                                  } ?></a> <a href="?durum=4" class="btn btn-success"><i class="fa fa-check"></i> WHITELIST<?php if ($_GET["durum"] == 4) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo " - LISTELENIYOR";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  } ?></a>
          </div>

          <div class="d-flex justify-content-center" style="margin-top:10px;">
            <div class="col-md-5" id="duzenle" style="display:none;">
              <div class="tile">
                <div class="tile-body">
                  <form action="javascript:void(0)" id="duzenleform">
                    <input type="hidden" id="site_id" value="">
                    <div class="form-group">
                      <label class="control-label">Site Adresi</label>
                      <input class="form-control" type="text" id="site_adresi" value="" disabled>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Durum</label>
                      <select class="form-control" id="durum">
                        <option value="2">Şüpheli</option>
                        <option value="3">Fraud</option>
                        <option value="4">Whitelist</option>
                      </select>
                    </div>
                </div>
                <div class="tile-footer">
                  <button class="btn btn-success" type="submit" id="guncellebtn"><i class="fa fa-fw fa-lg fa-check"></i> Güncelle</button>
                  <button onclick="sil(0)" class="btn btn-danger" type="button" id="silbtn"><i class="fa fa-fw fa-lg fa-trash"></i> Sil</button>
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
                  <th>Site Adresi</th>
                  <th>Eklenme Adresi</th>
                  <th>Ekleyen</th>
                  <th>Durum</th>
                  <th>İşlem</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($_GET["arama"]) {
                  $aranacakveri = "%" . $_GET["arama"] . "%";
                  $toplamsiteler = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE site_adresi LIKE :aranacakveri order by id desc");
                  $toplamsiteler->bindParam(":aranacakveri", $aranacakveri, PDO::PARAM_STR);
                  $toplamsiteler->execute();
                  $sayfa_sayisi = ceil($toplamsiteler->rowCount() / $gosterilecek);

                  $ilk_kayit = ($gosterilecek_sayfa * $gosterilecek) - $gosterilecek;
                  $siteler = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE site_adresi LIKE :aranacakveri order by id desc limit :ilk_kayit, :gosterilecek");
                  $siteler->bindParam(":aranacakveri", $aranacakveri, PDO::PARAM_STR);
                  $siteler->bindParam(":ilk_kayit", $ilk_kayit, PDO::PARAM_INT);
                  $siteler->bindParam(":gosterilecek", $gosterilecek, PDO::PARAM_INT);
                } else {
                  if (!empty(trim($_GET["durum"]))) {
                    $durumid = $_GET["durum"];
                    $durumlar = array(1, 2, 3, 4);
                    foreach ($durumlar as $durum_veri) {
                      if ($durumid == $durum_veri) {
                        $durum_dogrulama = 1;
                      }
                    }
                    if ($durum_dogrulama != 1) {
                      exit;
                    }

                    $toplamsiteler = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE durum = :durum order by id desc");
                    $toplamsiteler->bindParam(":durum", $durumid, PDO::PARAM_INT);
                    $toplamsiteler->execute();
                    $sayfa_sayisi = ceil($toplamsiteler->rowCount() / $gosterilecek);

                    $ilk_kayit = ($gosterilecek_sayfa * $gosterilecek) - $gosterilecek;

                    $siteler = $baglanti->prepare("SELECT * FROM eklenen_siteler WHERE durum = :durum order by id desc limit :ilk_kayit, :gosterilecek");
                    $siteler->bindParam(":durum", $durumid, PDO::PARAM_INT);
                    $siteler->bindParam(":ilk_kayit", $ilk_kayit, PDO::PARAM_INT);
                    $siteler->bindParam(":gosterilecek", $gosterilecek, PDO::PARAM_INT);
                  } else {
                    $toplamsiteler = $baglanti->prepare("SELECT * FROM eklenen_siteler order by id desc");
                    $toplamsiteler->execute();
                    $sayfa_sayisi = ceil($toplamsiteler->rowCount() / $gosterilecek);

                    $ilk_kayit = ($gosterilecek_sayfa * $gosterilecek) - $gosterilecek;
                    $siteler = $baglanti->prepare("SELECT * FROM eklenen_siteler order by id desc limit :ilk_kayit, :gosterilecek");
                    $siteler->bindParam(":ilk_kayit", $ilk_kayit, PDO::PARAM_INT);
                    $siteler->bindParam(":gosterilecek", $gosterilecek, PDO::PARAM_INT);
                  }
                }

                $siteler->fetchAll(PDO::FETCH_ASSOC);
                $siteler->execute();

                if ($siteler->rowCount()) {
                  foreach ($siteler as $siteveri) {
                    $ekleyen_bilgisi = json_decode($siteveri["ekleyen"], true);
                    if ($ekleyen_bilgisi["ekleyen_id"] == 1) {
                      $yetkilibul = $baglanti->prepare("SELECT * FROM kullanicilar WHERE id = :id");
                      $yetkilibul->bindParam(":id", $ekleyen_bilgisi["yetkili_id"], PDO::PARAM_INT);
                      $yetkilibul->execute();

                      if ($yetkilibul->rowCount()) {
                        foreach ($yetkilibul as $yetkiliveri) {
                          $yetkilinick = $yetkiliveri["kullaniciadi"];
                        }
                      } else {
                        $yetkilinick = "Bulunamadı";
                      }

                      $ekleyen = "Yetkili(" . htmlspecialchars($yetkilinick) . ")";
                      $ekleyenicon = "fa fa-user-plus";
                    } elseif ($ekleyen_bilgisi["ekleyen_id"] == 2) {
                      $ekleyen = "Form Bildirisi";
                      $ekleyenicon = "fa fa-wpforms";
                    } elseif ($ekleyen_bilgisi["ekleyen_id"] == 3) {
                      $ekleyen = "BOT";
                      $ekleyenicon = "fa fa-desktop";
                    }


                    if ($siteveri["durum"] == 1) {
                      $durum = "Bekleniyor";
                      $durumicon = "fa fa-clock-o";
                      $renk = "warning";
                    } elseif ($siteveri["durum"] == 2) {
                      $durum = "Şüpheli";
                      $durumicon = "fa fa-user-secret";
                      $renk = "secondary";
                    } elseif ($siteveri["durum"] == 3) {
                      $durum = "Fraud";
                      $durumicon = "fa fa-times-circle";
                      $renk = "danger";
                    } elseif ($siteveri["durum"] == 4) {
                      $durum = "Whitelist";
                      $durumicon = "fa fa-check";
                      $renk = "success";
                    } elseif ($siteveri["durum"] == 5) {
                      $durum = "Engellendi";
                      $durumicon = "fa fa-shield";
                      $renk = "info";
                    }

                    if ($siteveri["durum"] == 5) {
                      $usomappend = "<del>";
                      $usomappendend = "</del>";
                    }

                    $siteadresihtml = htmlspecialchars($siteveri["site_adresi"]);
                    if (!strstr($siteveri["site_tam_adresi"], "http")) {
                      $httpappend = "http://";
                    }

                    echo '<tr id="' . htmlspecialchars($siteveri["id"]) . '_site">
                        <td>' . htmlspecialchars($siteveri["id"]) . '</td>
                        <td>' . $usomappend . '<a href="http://' . htmlspecialchars($siteveri["site_adresi"]) . '" class="btn btn-primary btn-sm" rel="nofollow noopener noreferrer" target="_blank"><i class="fa fa-globe"></i> ' . htmlspecialchars(substr($siteveri["site_adresi"], 0, 30), ENT_QUOTES) . '</a>' . $usomappendend . '</td>
                        <td>' . $usomappend . '<a href="' . $httpappend . '' . htmlspecialchars($siteveri["site_tam_adresi"], ENT_QUOTES) . '" rel="nofollow noopener noreferrer" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-link"></i> ' . htmlspecialchars(substr($siteveri["site_tam_adresi"], 0, 30), ENT_QUOTES) . '</a>' . $usomappendend . '</td>
                        <td><a href="#" class="btn btn-info btn-sm"><i class="' . $ekleyenicon . '"></i> ' . $ekleyen . '</a></td>
                        <td><a href="?durum=' . htmlspecialchars($siteveri["durum"]) . '" class="btn btn-' . $renk . ' btn-sm"><i class="' . $durumicon . '"></i> ' . $durum . '</a></td>
                        <td><a href="#duzenle" onclick="duzenle(';
                    echo "'" . htmlspecialchars($siteveri["id"], ENT_QUOTES) . "', '" . htmlspecialchars($siteveri["site_adresi"], ENT_QUOTES) . "')" . '"';
                    echo 'style="color:white;" class="btn btn-secondary btn-sm"><i class="fa fa-edit"></i> Düzenle</a> <a onclick="sil(';
                    echo "'" . htmlspecialchars(($siteveri["id"])) . "', 1)" . '"';
                    echo 'style="color:white;" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Sil</a></td>
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

                if ($_GET["arama"]) {
                  $aramaappend = "arama=" . htmlspecialchars($_GET["arama"]) . "&";
                }
                for ($i = 1; $i <= $sayfa_sayisi; $i++) {
                  if ($i == $gosterilecek_sayfa) {
                    echo '<a href="?' . $aramaappend . '' . $durumappend . 'sayfa=' . $i . '" class="btn btn-info">' . $i . '</a>';
                  } else {
                    echo '<a href="?' . $aramaappend . '' . $durumappend . 'sayfa=' . $i . '" class="btn btn-secondary">' . $i . '</a>';
                  }

                  if ($i == 29) {
                    break;
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
  </main>
  <script src="js/jquery.min.js" type="text/javascript"></script>
  <script src="js/main.js" type="text/javascript"></script>
  <script type="text/javascript">
    var menuadi = "<?php echo htmlspecialchars($menuadi) ?>";
    $("a[menuadi=" + menuadi + "]").attr("class", "app-menu__item active");

    function duzenle(id, site_adresi) {
      $("#duzenle").show();
      $("#site_adresi").val(site_adresi);
      $("#site_id").val(id);
      $("#silbtn").attr("onclick", "sil(" + id + ", 2)");
    }


    $("#duzenleform").submit(function() {
      $("#guncellebtn").prop("disabled", true);
      $.post("/postV4/site-duzenle", {
        "site_id": $("#site_id").val(),
        "durum": $("#durum option:selected").val()
      }, function(cikti) {
        if (cikti.id == 1) {
          alert("Site durumu güncellendi");
          location.reload();
        } else {
          alert(cikti.mesaj);
          $("#guncellebtn").prop("disabled", false);
        }
      });
    });

    function sil(id, akabin) {
      $.post("/postV4/site-sil", {
        "site_id": id
      }, function(cikti) {
        if (cikti.id == 1) {
          alert("Silindi!");
          $("#" + id + "_site").remove();
          if (akabin == 2) {
            $("#duzenle").hide();
          }
        } else {
          alert(cikti.mesaj);
        }
      })
    }
  </script>
</body>

</html>