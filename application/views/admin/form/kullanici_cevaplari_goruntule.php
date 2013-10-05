<div class="span9">
	<fieldset id="sorular">
		<legend style="font-weight:bold">
		<center><?php echo $form['yazilar'][0]['baslik']." ( ".$form['kullanici']." ) "; ?></center></legend>
	</fieldset>
	
	<div style="background-color:#ccc8cc;-moz-border-radius: 22px;
	-webkit-border-radius: 22px;
	border-radius: 22px;
	padding:10px">
	<?php echo $form['yazilar'][0]['bilgilendirme'];?>
	</div>
	
	<legend><center><strong>Sorular</strong></center></legend>
	

	<form action="{base_url}index.php/admin/form_kaydet" method="post">

	<?php
		$sayac = 0;
		foreach ($form['sorular'] as $soru){
			$sayac++;
			$id = $soru['id'];
			$sorumuz = $soru['soru'];
			$soru_turu = $soru['soru_turu'];
	?>

	<legend> 
		<div style="background-color:#ebe2eb;-moz-border-radius-topleft: 19px;-moz-border-radius-topright:18px;-moz-border-radius-bottomleft:5px;-moz-border-radius-bottomright:5px;-webkit-border-top-left-radius:19px;-webkit-border-top-right-radius:18px;-webkit-border-bottom-left-radius:5px;-webkit-border-bottom-right-radius:5px;border-top-left-radius:19px;
		border-top-right-radius:18px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;font-size:14px;
		padding:5px;line-height:1.8em">
		<?php echo "<strong>Soru $sayac -) </strong>$sorumuz";?>
		<?php echo "<input type='hidden' value='$id' name='cevaplar[]'>";?>
		</div>
	</legend>

	<?php
			if($soru_turu == 'coktan_secmeli'){
				echo "<select readonly>";
				foreach($soru['secenekler'] as $secenek){
					echo "<option value='$secenek'>$secenek</option>";
				}
				echo "</select> Cevap:".$soru['cevap'];
			}
			else{	
				echo "<input class='span9' value='".$soru['cevap']."'  type='text' readonly>";
			}

		}
	?>
	<br><center><a href="{base_url}" class="btn btn-large btn-primary">Anasayfa</a>
</div>
