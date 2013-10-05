
<?php
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename='$dosya_ismi.csv'");
	header("Pragma: no-cache");
	header("Expires: 0");
	$yazilacak = "*,";
	$yazilacak .= "İSİM,";
	$yazilacak .= "SOYİSİM,";
	foreach($kayitsiz_sorular_cevaplar['sorular'] as $soru){
		$yazilacak .= strtoupper($soru).",";
	}
	$yazilacak .= "\n";
	$sira = 1;

	foreach($kayitli_cevaplar as $kullanici_cevaplari){
		$yazilacak .= "\n";
		$yazilacak .= "$sira,".$kullanici_cevaplari['kullanici']['isim'].",".$kullanici_cevaplari['kullanici']['soyisim'].",";
		$sira++;
		foreach($kullanici_cevaplari['cevaplar'] as $cevaplar){
			$yazilacak .= ucfirst(strtolower($cevaplar)).",";
		}
		$yazilacak .= "\n";
	}
	foreach($kayitsiz_sorular_cevaplar['cevaplar'] as $kullanici_cevaplari){
		$yazilacak .= "$sira,*****,*****,";
		$sira++;
		foreach($kullanici_cevaplari as $cevaplar){
			$yazilacak .= ucfirst(strtolower($cevaplar)).",";
		}
		$yazilacak .= "\n";
	}
print $yazilacak;
?>
