<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8">
    <meta charset="utf-8">
    <title>{title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

     <link href="http://localhost/web_dokuman/bootstrap/docs/assets/css/bootstrap.css" rel="stylesheet">
    <link href="http://localhost/web_dokuman/bootstrap/docs/assets/css/bootstrap-responsive.css" 
    rel="stylesheet">

      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	  <style type="text/css">
	  #footer {
	  margin-left: 400px;
	  }
	  </style>

    <!-- Le styles -->
    <link href="http://localhost/web_dokuman/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="http://twitter.github.io/bootstrap/assets/ico/favicon.png">
  </head>

  <body>






	<div id="wrap">
		<div class="container">
			<div class="row">
				<div class="span3 hidden-phone"></div>
				<div class="span7" id="form-login">
					<form class="form-horizontal well" method="post" action="{base_url}index.php/pages/sign_in">
						<fieldset>
							<legend>E-postanıza gönderilen kodu giriniz.</legend>
							
<?php
if(isset($hata)){
	echo "<center><p class='text-error'><strong>$hata</strong></p></center>";
}?>
							<input type="hidden" name="email" value="{email}">
							<div class="control-group">
								<div class="control-label">
									<label>Güvenlık Kodu:</label>
								</div>
								<div class="controls">
									<input type="text" placeholder="********" name="guvenlik_kodu" class="input-large">
								</div>
							</div>
							<div class="control-group">
								<div class="controls">

									<button type="submit" id="submit"
										class="btn  btn-primary button-loading" data-loading-text="Loading...">Sisteme Giriş</button>
								</div><br><center><a href="#">Mail adresinize guvenlik kodu gonderilmiştir. Mailinizdeki kodu giriniz.</a></center>
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
