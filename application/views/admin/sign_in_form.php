<html>
 <head>
<meta charset="utf-8">
    
 <link href="{base_url}bootstrap/docs/assets/css/bootstrap.css" rel="stylesheet">
 <link href="{base_url}bootstrap/docs/assets/css/bootstrap-responsive.css">
 <link href="{base_url}bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body><br><br><br><br><br>
	<div id="wrap">
		<div class="container">
			<div class="row">
				<div class="span3 hidden-phone"></div>
				<div class="span7" id="form-login">
					<form class="form-horizontal well" method="post" action="{base_url}index.php/admin/guvenlik_sayfasi">
						<fieldset>
							<legend>Admin Giriş Paneli</legend>
							
<?php
if(isset($bilgilendirme)){
	echo "<center><p class='text-error'><strong>$bilgilendirme</strong></p></center>";
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
										class="btn  btn-primary button-loading" data-loading-text="Loading...">Admin Paneline Giriş</button>
							</div>
						</fieldset>
					</form>


					<div class="span3 hidden-phone"></div>
				</div>
			</div>
		</div>

	</div>
	</body>
</html>
