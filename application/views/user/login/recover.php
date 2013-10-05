			<div class="row">
				<div class="span3 hidden-phone"></div>
				<div class="span7" id="form-login">
					<form class="form-horizontal well" method="post" action="{base_url}index.php/pages/res_pass">
						<fieldset>
							<legend>Şifre Yenileme Paneli</legend>
							
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
								<div class="controls">

									<button type="submit" id="submit"
										class="btn  btn-primary button-loading" data-loading-text="Loading...">Yeni Şifre Gönder</button>
</div>
						</fieldset>
					</form>


					<div class="span3 hidden-phone"></div>
				</div>
			</div>
