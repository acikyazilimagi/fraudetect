<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="/img/kullanici.png" height="59">
        <div>
          <p class="app-sidebar__user-name" style="margin-left:2px;"><?php echo htmlspecialchars($kullanici_adi) ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="/panel" menuadi="arayuz"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Arayüz</span></a></li>
        <li><a class="app-menu__item" href="/yetkili-site-ekle" menuadi="toplusiteekle"><i class="app-menu__icon fa fa-plus"></i><span class="app-menu__label">Yetkili Site Ekle</span></a></li>
        <?php
        if($kullanici_yetkisi==2) {
        ?>
        <li><a class="app-menu__item" href="/yetkili-ayarlari" menuadi="yetkiliayarlari"><i class="app-menu__icon fa fa-user-plus"></i><span class="app-menu__label">Yetkili Ayarları</span></a></li>
        <?php } ?>
        <li><a class="app-menu__item" href="/hesap-ayarlari" menuadi="hesapayarlari"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Hesap Ayarları</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview" id="araclar"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Araçlar</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="/cloacker-tespiti" menuadi="cloackertespit"><i class="icon fa fa-circle-o" style="margin-right:4px;"></i> Cloacker Tespiti</a></li>
          </ul>
        </li>
        <li><a class="app-menu__item" href="/dokumanlar" menuadi="dokumanlar"><i class="app-menu__icon fa fa-file-o"></i><span class="app-menu__label">Dökümanlar</span></a></li>
        <li><a class="app-menu__item" href="/cikis-yap"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Çıkış Yap</span></a></li>
      </ul>
    </aside>