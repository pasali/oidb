    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
	      <li class="nav-header">Menü</li>
<?php if($kullanici_giris){ ?> 
	<li><a href="{base_url}index.php/pages/son_formlar">Son Formlar</a></li>
	<li><a href="{base_url}index.php/pages/tum_formlar">Tüm Formlar</a></li>
  	<li><a href="{base_url}index.php/pages/cevaplanan_formlar">Cevaplanan formlar</a></li>
	<li><a href="{base_url}index.php/pages/cikis_yap">Çıkış Yap</a></li>
	
<?php } else{ ?>
	      <li><a href="{base_url}index.php/pages/">Anasayfa</a></li>
	<li><a href="{base_url}index.php/pages/kayitsiz_tum_formlar">Tüm Formlar</a></li>
	      <li><a href="{base_url}index.php/pages/sign_in_form">Giriş yap</a></li>
	      <li><a href="{base_url}index.php/pages/sign_up_form">Kayıt ol</a></li>
<?php } ?>
	    </ul>
          </div><!--/.well -->
        </div><!--/span-->
