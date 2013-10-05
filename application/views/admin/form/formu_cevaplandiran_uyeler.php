			<fieldset>
			<legend><?php echo $sonuclar['baslik']; ?></legend>
	                                <table class="table table-hover">
					      <thead>
						<tr>
						  <th>Kullanıcı</th>
						  <th>Zaman</th>
						  <th>İncele</th>
						</tr>
					      </thead>
					      <tbody>
				<?php foreach($sonuclar['kullanicilar'] as $kullanici){ ?>
						<tr>
						  <td><?php echo $kullanici['kullanici'];?></td>
						  <td><?php echo $kullanici['zaman']; ?></td>
						  <td><form method="post" action="{base_url}index.php/admin/kullanici_cevaplari_goruntule"><input type="hidden" name="form_id" value="<?php echo $sonuclar['form_id']; ?>"><input type="hidden" name="user_id" value="<?php echo $kullanici['user_id']; ?>"><input type="submit" class="btn btn-small btn-primary" value="İncele"></form></td>
						 
						</tr>
				<?php } ?>
					   </tbody>
					    </table>

				</fieldset>
