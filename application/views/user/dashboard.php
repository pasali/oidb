        <div class="span9">
<?php if(isset($formlar[0])){ ?>
          <div class="hero-unit">
	    <h3><?php echo substr($formlar[0]['baslik'],0,50)?>!</h3>
	    <p><?php echo substr($formlar[0]['bilgilendirme'],0,200);?> ...</p>
	    <p><a href="{base_url}index.php/pages/form_doldur?form_id=<?php echo $formlar[0]['id']; ?>" class="btn btn-primary btn-large">Devamı »</a></p>
          </div>
<?php } ?>
          <div class="row-fluid">

<?php if(isset($formlar[1])){ ?>
            <div class="span4">
	      <h2><?php echo substr($formlar[1]['baslik'],0,50);?></h2>
	      <p><?php echo substr($formlar[1]['bilgilendirme'],0,70);?> ...</p>
	      <p><a class="btn" href="{base_url}index.php/pages/form_doldur?form_id=<?php echo $formlar[1]['id']; ?>">detay »</a></p>
<?php if(isset($formlar[2])){ ?>
	    </div><!--/span-->
            <div class="span4">
	      <h2><?php echo substr($formlar[2]['baslik'],0,70);?></h2>
	      <p><?php echo substr($formlar[2]['bilgilendirme'],0,70);?> ... </p>
	      <p><a class="btn" href="{base_url}index.php/pages/form_doldur?form_id=<?php echo $formlar[2]['id']; ?>">detay »</a></p>
<?php if(isset($formlar[3])){ ?>
	    </div><!--/span-->
	    <div class="span4">
	      <h2><?php echo substr($formlar[3]['baslik'],0,70);?></h2>
	      <p><?php echo substr($formlar[3]['bilgilendirme'],0,70);?> ... </p>
	      <p><a class="btn" href="{base_url}index.php/pages/form_doldur?form_id=<?php echo $formlar[3]['id']; ?>">detay »</a></p>
            </div><!--/span-->
<?php }}} ?>
          </div><!--/row-->
      <hr>
    </div><!--/.fluid-container-->
