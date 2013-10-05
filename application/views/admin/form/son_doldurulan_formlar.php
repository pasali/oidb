			<fieldset>
			<legend>Son Doldurulan Formlar</legend>
	                                <table class="table table-hover">
					      <thead>
						<tr>
						  <th>Kullanıcı</th>
						  <th>Form Başlık</th>
						  <th>Zaman</th>
						  <th>İncele</th>
						</tr>
					      </thead>
					      <tbody>
						{formlar}
						<tr>
						  <td>{kullanici}</td>
						  <td>{form_baslik}</td>
						  <td>{zaman}</td>
						  <td><form method="post" action="{base_url}index.php/admin/kullanici_cevaplari_goruntule"><input type="hidden" name="form_id" value="{form_id}"><input type="hidden" name="user_id" value="{user_id}"><input type="submit" class="btn btn-small btn-primary" value="İncele"></form></td>
						 
						</tr>
						{/formlar}
					      </tbody>
					    </table>

				</fieldset>
