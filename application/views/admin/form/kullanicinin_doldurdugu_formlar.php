			<fieldset>
			<legend><?php echo $sonuclar['kullanici']; ?></legend>
	                                <table class="table table-hover">
					      <thead>
						<tr>
						  <th>Kullanıcı</th>
						  <th>Zaman</th>
						  <th>İncele</th>
						</tr>
					      </thead>
					      <tbody>
				<?php foreach($sonuclar['formlar'] as $form){ ?>
						<tr>
						  <td><?php echo $form['baslik'];?></td>
						  <td><?php echo $form['zaman']; ?></td>
						  <td><form method="post" action="{base_url}index.php/admin/kullanici_cevaplari_goruntule"><input type="hidden" name="form_id" value="<?php echo $form['form_id']; ?>"><input type="hidden" name="user_id" value="<?php echo $sonuclar['user_id']; ?>"><input type="submit" class="btn btn-small btn-primary" value="İncele"></form></td>
						 
						</tr>
				<?php } ?>
					   </tbody>
					    </table>

				</fieldset>
