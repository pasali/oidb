   <div class="row" style="margin-left:-100px" >
	<div class="span3 hidden-phone"></div>
	<div class="span8" id="form-login">
	<form id="signup" class="form-horizontal well" method="post" action="{base_url}index.php/pages/sign_up">
    <div style="color:red"><?php if(isset($bilgilendirme_mesaji)){echo $bilgilendirme_mesaji;} ?></div>
      <legend>Kayıt formu</legend>
	<div class="control-group">
		<label class="control-label">Ad:</label>
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on"><i class="icon-user"></i></span>
					<input type="text" class="input-xlarge"	id="fname" name="fname" >
				</div>
			</div>
		</div>
		<div class="control-group ">
		<label class="control-label">Soyad:</label>
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on"><i class="icon-user"></i></span>
					<input type="text" class="input-xlarge" id="lname" name="lname">
				</div>
			</div>
		</div>
		<div class="control-group">
		<label class="control-label">E-posta:</label>
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on"><i class="icon-envelope"></i></span>
					<input type="text" class="input-xlarge" id="email" name="email">
				</div>
			</div>	
		</div>
		<div class="control-group">
		<label class="control-label">Şifre:</label>
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on"><i class="icon-lock"></i></span>
					<input type="Password" id="passwd" class="input-xlarge" name="passwd" >
				</div>
			</div>
		</div>
		<div class="control-group">
		<label class="control-label">Şifre Tekrar:</label>
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on"><i class="icon-lock"></i></span>
					<input type="Password" id="conpasswd" class="input-xlarge" name="conpasswd">
				      </div>
			</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="input01"></label>
	      <div class="controls">
	       <button type="submit" class="btn btn-success" rel="tooltip" 
	       title="first tooltip">Kayıt Ol</button>
	       
	      </div>
	
	</div>
	
	  </form>
	<div class="span3 hidden-phone"></div>
	</div>
	</div>
	</div>


    </div><!--/.fluid-container-->

	<!-- Javascript placed at the end of the file to make the  page load faster -->

    <script src="{base_url}bootstrap/js/jquery.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-transition.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-alert.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-modal.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-tab.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-popover.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-button.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-collapse.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-carousel.js"></script>
    <script src="{base_url}bootstrap/js/bootstrap-typeahead.js"></script>
	
	<script type="text/javascript" src="{base_url}bootstrap/js/jquery.validate.js"></script>
	  <script type="text/javascript">
	  $(document).ready(function(){
			
			$("#signup").validate({
				rules:{
					fname:"required",
					lname:"required",
					email:{
							required:true,
							email: true
						},
					passwd:{
						required:true,
						minlength: 8
					},
					conpasswd:{
						required:true,
						equalTo: "#passwd"
					},
					gender:"required"
				},
				
				errorClass: "help-inline"
				
			});
		});
	  </script>


