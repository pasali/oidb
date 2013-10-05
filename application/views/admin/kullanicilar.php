			<fieldset>
			<legend>Kullanicilar</legend>
	                                <table class="table table-hover">
					      <thead>
						<tr>
						  <th>Id</th>
						  <th>Isim</th>
						  <th>Soyisim</th>
						  <th>E-posta</th>
						  <th>Doldurduğu Formlar</th>
						</tr>
					      </thead>
					      <tbody>
						{kullanicilar}
						<tr>
						  <td>{id}</td>
						  <td>{isim}</td>
						  <td>{soyisim}</td>
						  <td>{email}</td>
						
						  <td><a href="{base_url}index.php/admin/kullanicinin_cevaplandirdigi_formlar?user_id={id}" class="btn btn-small btn-primary" type="button">Doldordugu Formlar</a></td>
						</tr>
						{/kullanicilar}
					      </tbody>
					    </table>

				</fieldset>
