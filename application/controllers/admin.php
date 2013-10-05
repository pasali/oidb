<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->data['base_url'] = base_url();	
		if($this->admin_model->oturum_kontrol()){
			$oturum = $this->admin_model->oturum_bilgileri();
			$this->data['admin_email'] = $oturum['email'];
			$this->data['admin_giris'] = true;
		}
		else{
			$this->data['admin_email'] = "";
			$this->data['admin_giris'] = false;
		}
	}
	public function admin_kontrol(){
		if(!$this->data['admin_giris']){
			$url = base_url()."index.php/admin/sign_in_form";
			header("Location: $url");
		}
	}
	public function sayfa_getir($sayfa){
		$this->parser->parse('includes/admin/header',$this->data);	
		$this->parser->parse('includes/admin/admin_menu',$this->data);	
		$this->parser->parse($sayfa,$this->data);	
		$this->parser->parse('includes/admin/footer',$this->data);
	}
	public function sign_in_form(){	
		$this->parser->parse('admin/sign_in_form',$this->data);	
	}
	public function guvenlik_sayfasi(){
		$this->data['title'] = "Anasayfa";
		$email = $this->input->post('email');
		$sifre = $this->input->post('sifre');
		if($this->admin_model->admin_kontrol($email,$sifre)){	
			$this->data['email'] = $email;
			$this->admin_model->guvenlik_kodu_gonder($email);	
			$this->parser->parse('admin/guvenlik_kodu_giris',$this->data);
		}
		else{
			$this->data['bilgilendirme'] = "Lutfen bilgileri kontrol ediniz";
			$this->parser->parse('admin/sign_in_form',$this->data);		
		}
	}
	public function sign_in(){
		$email = $this->input->post('email',TRUE);
		$guvenlik_kodu = $this->input->post('guvenlik_kodu',TRUE);
		if($this->admin_model->guvenlik_kontrol($email,$guvenlik_kodu)){
			$this->admin_model->oturum_ac($email);
			$url = base_url()."index.php/admin/";
			header("Location: $url");
		}
		else{
			$this->data['email'] = $email;
			$this->data['hata'] = "Lutfen guvenlik kodunu kontrol ediniz";
			$this->parser->parse('admin/guvenlik_kodu_giris',$this->data);	
		}
	}
	public function index(){
		$this->admin_kontrol();
		$this->data['title'] = 'Admin Panel';
		$this->data['son_kullanicilar'] = $this->admin_model->kullanicilari_getir(2);	
		$this->data['son_formlar'] = $this->admin_form_model->formlari_getir(2);
		$this->data['son_doldurulan_formlar'] = $this->admin_form_model->son_doldurulan_formlari_getir(4);
		
		$this->sayfa_getir('admin/dashboard');
	}
	public function form_olustur(){
		$this->admin_kontrol();	
		$this->sayfa_getir('admin/form/form_olustur');
	}
    
	public function soru_ekle($form_id,$tur){
		$this->admin_kontrol();
		switch ($tur){
			case 'soru_cevap':
			   $soru_id = $this->admin_form_model->soru_ekle($form_id,'soru_cevap');
			   $cikti = "<form id='$soru_id'>";
			   $cikti .= "<input type='hidden' name='id' value='$soru_id'>";
			   $cikti .= "<input type='text' name='soru' onkeypress='return handleEnter(this, event)' class='span9' placeholder='Sorunuzu buraya yaziniz' onBlur='soru_kaydet($soru_id)'>";
			   $cikti .= "</form>";
	
			   echo $cikti;
			   break;
			case 'coktan_secmeli':
			   $soru_id = $this->admin_form_model->soru_ekle($form_id,'coktan_secmeli');
			   
			   $cikti = "<div id='soru'>";
			   $cikti .= "<form id='$soru_id'>";
			   $cikti .= "<input type='hidden' name='id' value='$soru_id'>";
			   $cikti .= "<input type='text' name='soru'  onkeypress='return handleEnter(this, event)'  class='span9' placeholder='Sorunuzu buraya yaziniz' onBlur='soru_kaydet($soru_id)'></form>";
			   $cikti .= "<button  class='btn btn-mini btn-primary' btn btn-small btn-primary' onClick='secenek_ekle($form_id,$soru_id)'>Yeni Secim Ekle</button></div>";

			   echo $cikti;
			   break;
		}
	}
	public function secenek_ekle($form_id,$soru_id){
		$this->admin_kontrol();
		$secenek_id = $this->admin_form_model->secenek_ekle($form_id,$soru_id);
		echo "<form style='margin-left:70px' id='secenek_$secenek_id'><input  type='hidden' name='secenek_id' value='$secenek_id'><input type='text' onkeypress='return handleEnter(this, event)' style='margin-top:-5px' name='secenek' placeholder='Secenegi giriniz' onBlur='secenek_kaydet($secenek_id)'></form>";
	}
	public function soru_kaydet(){
		$this->admin_kontrol();
		$id = $this->input->post('id',TRUE);
		$soru = $this->input->post('soru',TRUE);
		$this->admin_form_model->soru_kaydet($id,$soru);
	}
	public function secenek_kaydet(){
		$this->admin_kontrol();
		$secenek_id = $this->input->post('secenek_id',TRUE);
		$secenek = $this->input->post('secenek',TRUE);
		$this->admin_form_model->secenek_kaydet($secenek_id,$secenek);
	}
	public function kullanicilar(){
		$this->admin_kontrol();
		$this->data['kullanicilar'] = $this->admin_model->kullanicilari_getir();
		$this->sayfa_getir('admin/kullanicilar');		

	}
	public function formlar(){
		$this->admin_kontrol();
		$this->data['formlar'] = $this->admin_form_model->formlari_getir();
		$this->sayfa_getir('admin/form/formlar');	
	}
	public function son_formlar(){
		$this->admin_kontrol();
		$this->data['formlar'] = $this->admin_form_model->formlari_getir(12);
		$this->sayfa_getir('admin/form/formlar');	

	}
	public function form_incele(){
		$form_id = $this->input->get('form_id',true);
		if(!$form_id){
			$url = base_url()."index.php/admin";
			header( "Refresh: 0; url=".$url);
		}
		$this->admin_kontrol();
		$this->data['form'] = $this->form_model->form_getir($form_id);
		$this->sayfa_getir('admin/form/form_incele');
	}
	public function form_ekle(){
		$this->admin_kontrol();
		$baslik = $this->input->post('baslik',TRUE);
		$bilgilendirme = $this->input->post('bilgilendirme',TRUE);
		$gizlilik = $this->input->post('gizlilik');
		$id = $this->admin_form_model->form_kaydet($baslik,$bilgilendirme,$gizlilik);
		$this->data['id'] = $id;	
		$this->sayfa_getir('admin/form/form_soru_ekle');	
	}
	public function son_doldurulan_formlar(){
		$this->admin_kontrol();
		$this->data['formlar'] = $this->admin_form_model->son_doldurulan_formlari_getir(20);
		$this->sayfa_getir('admin/form/son_doldurulan_formlar');
	}
	public function tum_doldurulan_formlar(){
		$this->admin_kontrol();
		$this->data['formlar'] = $this->admin_form_model->son_doldurulan_formlari_getir();
		$this->sayfa_getir('admin/form/tum_doldurulan_formlar');	
	}
	public function kullanici_cevaplari_goruntule(){
		$this->admin_kontrol();
		$user_id = $this->input->post('user_id');
		$form_id = $this->input->post('form_id');
		$this->data['form'] = $this->form_model->form_getir_cevaplariyla($form_id,$user_id);
		$this->sayfa_getir('admin/form/kullanici_cevaplari_goruntule');	
	}
	public function formu_dolduran_uyeler(){
		$this->admin_kontrol();
		$form_id = $this->input->get('form_id',true);
		if(!$form_id){
			$url = base_url()."index.php/admin";
			header( "Refresh: 0; url=".$url);
		}
		$this->data['sonuclar'] = $this->admin_form_model->formu_cevaplandiran_uyeler($form_id);
		$this->sayfa_getir('admin/form/formu_cevaplandiran_uyeler');
	}
	public function kullanicinin_cevaplandirdigi_formlar(){
		$this->admin_kontrol();
		$user_id = $this->input->get('user_id',true);
		if(!$user_id){
			$url = base_url()."index.php/admin";
			header( "Refresh: 0; url=".$url);
		}
		$this->data['sonuclar'] = $this->admin_form_model->kullanicinin_cevaplandirdigi_formlar($user_id);
		$this->sayfa_getir('admin/form/kullanicinin_doldurdugu_formlar');
	}
	public function form_sil(){
		$this->admin_kontrol();
		$form_id = $this->input->get('form_id',true);
		if(!$form_id){
			$url = base_url()."index.php/admin";
			header( "Refresh: 0; url=".$url);
		}
		$this->admin_form_model->formu_sil($form_id);
		$this->data['formlar'] = $this->admin_form_model->formlari_getir();
		$this->sayfa_getir('admin/form/formlar');	
	}
	public function logout(){
		$this->admin_model->oturum_kapa();
		$this->admin_kontrol();
		$url = base_url()."index.php/admin/sign_in_form";
		header("Location: $url");
	}
	public function form_kaydetme_basarili(){
		$this->admin_kontrol();
		$this->data['bilgilendirme_mesaji'] = "Form kaydetme başarıyla gerçekleşmiştir.";
		$this->sayfa_getir('admin/form/bilgilendirme_basarili');
		$url = base_url()."index.php/admin";
		header( "Refresh: 2; url=".$url);	
	}
	public function form_to_excel(){
		$this->admin_kontrol();
		$form_id = $this->input->get('form_id',true);
		if(!$form_id){
			$url = base_url()."index.php/admin";
			header( "Refresh: 0; url=".$url);
		}
		$this->data['dosya_ismi'] = $this->admin_form_model->get_form_to_excel_dosya_ismi($form_id);
		$this->data['kayitsiz_sorular_cevaplar'] = $this->admin_form_model->kayitsizlar_form_to_excel_model($form_id);
		$this->data['kayitli_cevaplar'] = $this->admin_form_model->kayitlilar_form_to_excel_model($form_id);
		$this->parser->parse('admin/form/form_to_excel',$this->data);	
	}
}
