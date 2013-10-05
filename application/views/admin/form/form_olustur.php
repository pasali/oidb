	<form action="{base_url}index.php/admin/form_ekle/" method="post">
	    <fieldset>
	      <legend>Yeni Form Oluştur</legend>
	      <label>Form Baslığı</label>
	      <input type="text" name="baslik" class="span8" placeholder="Formunuzun başlığını bu alana yazınız"><br><br>
	      <label>Form Bilgilendirme Yazısı</label>
	      <textarea class="span8" name="bilgilendirme" rows="5" placeholder="Formunuzun bilgilendirme yazısını bu alana yazınız"></textarea><br>
		<select name="gizlilik">
			<option value="acik">Açik(Kayıtsız kullanıcılar da doldurabilir)</option>
			<option value="kapali">Sadece kayıtlı kullanıcılar doldurabilir</option>
		</select>
	    <button type="submit" class="btn btn-primary">Sorulara Geç</button>
	  </fieldset>
	</form>
