<script src="{base_url}jquery.min.js"></script>
<script>
var soru= 1;
$(document).ready(function(){
  $("#yeni_soru_button").click(function(){
    $("#yeni_soru_button").fadeOut('fast');
    $("#soru_cevap_button").fadeIn();
    $("#coktan_secmeli_button").fadeIn();
  });
	
  $("#soru_cevap_button").click(function(){
    $("#soru_cevap_button").fadeOut();
    $("#coktan_secmeli_button").fadeOut(); 
    $('#ekleniyor').fadeIn();
	$.ajax({
		type: 'POST',
		url: '{base_url}index.php/admin/soru_ekle/{id}/soru_cevap',
		data: $('form').serialize(),
		success: function(ajaxCevap) {
			$('#sorularimiz').append("<legend> Soru "+soru+"-) </legend>");
			soru = soru+1;
			$('#sorularimiz').append(ajaxCevap);
		}
	});
        $('#ekleniyor').fadeOut();
    $("#yeni_soru_button").fadeIn('fast');
  });


  $("#coktan_secmeli_button").click(function(){
    $("#soru_cevap_button").fadeOut();
    $("#coktan_secmeli_button").fadeOut();
    $('#ekleniyor').fadeIn();
	$.ajax({
		type: 'POST',
		url: '{base_url}index.php/admin/soru_ekle/{id}/coktan_secmeli',
		data: $('form').serialize(),
		success: function(ajaxCevap) {
			$('#sorularimiz').append("<legend> Soru "+soru+"-) </legend>");
			soru = soru+1;
			$('#sorularimiz').append(ajaxCevap);
		}
	});
        $('#ekleniyor').fadeOut();
    $("#yeni_soru_button").fadeIn('fast');
  });
});
                
function handleEnter (field, event) {
        var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
        if (keyCode == 13) {
            var i;
            for (i = 0; i <field.form.elements.length; i++)
                if (field == field.form.elements[i])
                    break;
            i = (i + 1) % field.form.elements.length;
            field.form.elements[i].focus();
            return false;
        } 
        else
        return true;
    }      
 
function secenek_ekle(form_id,soru_id){
	$.ajax({
		type: 'POST',
		url: '{base_url}index.php/admin/secenek_ekle/'+form_id+'/'+soru_id,
		data: $('form').serialize(),
		success: function(ajaxCevap) {
			$('#'+soru_id).append(ajaxCevap);
		}
	});
  }
function soru_kaydet(soru_id){
	$.ajax({
		type: 'POST',
		url: '{base_url}index.php/admin/soru_kaydet/',
		data: $('#'+soru_id).serialize(),
	});
  }
function secenek_kaydet(secenek_id){
	$.ajax({
		type: 'POST',
		url: '{base_url}index.php/admin/secenek_kaydet/',
		data: $('#secenek_'+secenek_id).serialize(),
	});
  }
</script>
  
<br>
<fieldset id="sorularimiz" style="margin-left:70px">
<legend>Forma Sorular Ekle</legend>
</fieldset>


<div  style="margin-left:70px;margin-right:70px" id="yeni_soru">
	<div id="ekleniyor"></div>
	<button class="btn btn-small btn-primary" id="yeni_soru_button">Yeni Soru Ekle</button>
	<button  class="btn btn-small btn-primary" style="display:none" id="soru_cevap_button">Soru-Cevap</button>
	<button  class="btn btn-small btn-primary" style="display:none" id="coktan_secmeli_button" onclick="soru_secim(coktan secmeli)">Çoktan Secçeli</button>
	<br><br><br><center><a href="{base_url}index.php/admin/form_kaydetme_basarili" class="btn btn-large btn-primary">Formu Tamamla</a></center>
</div>

