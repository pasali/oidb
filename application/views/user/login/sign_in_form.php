			<div class="row">
				<div class="span3 hidden-phone"></div>
				<div class="span7" id="form-login">
					<form class="form-horizontal well" method="post" action="{base_url}index.php/pages/guvenlik_sayfasi">
						<fieldset>
							<legend>Kullanıcı Giriş Paneli</legend>
							
<?php
if(isset($hata)){
	echo "<center><p class='text-error'><strong>$hata</strong></p></center>";
}?>
							
							<div class="control-group">
								<div class="control-label">
									<label>E-posta:</label>
								</div>
								<div class="controls">
									<input type="text" placeholder="eposta@eposta.com" name="email" class="input-large">
								</div>
							</div>

							<div class="control-group">
								<div class="control-label">
									<label>Şifre:</label>
								</div>
								<div class="controls">
									<input type="password" name="sifre" placeholder="şifreniz" class="input-large">
								</div>
							</div>

							<div class="control-group">
								<div class="controls">

									<button type="submit" id="submit"
										class="btn  btn-primary button-loading" data-loading-text="Loading...">Sisteme Giriş</button>
<a href="{base_url}index.php/pages/recover" class="btn btn-info"><i class="icon-white icon-exclamation-sign"></i> Şifremi Unuttum</a>		
</div>
						</fieldset>
					</form>


					<div class="span3 hidden-phone"></div>
				</div>
			</div>
