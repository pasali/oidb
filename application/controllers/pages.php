<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	//Uye sessionu acik ya da kapali olmasi durumunda bilgileri aliyoruz constructor ile.
	public function __construct(){
		parent::__construct();
		$this->data['base_url'] = base_url();
		
		if($this->user_model->oturum_kontrol()){
			$this->data['oturum'] = $this->user_model->oturum_bilgileri();
			$this->data['kullanici'] = ucwords(strtolower($this->data['oturum']['isim']));
			$this->data['kullanici'] .= " ".(strtoupper($this->data['oturum']['soyisim']));
			$this->data['kullanici_giris'] = true;
		}
		else{	
			$this->data['kullanici'] = "";
			$this->data['kullanici_giris'] = false;	
		}	
	}
	public function sayfa_getir($sayfa){
		$this->parser->parse('includes/user/header',$this->data);	
		$this->parser->parse('includes/user/user_menu',$this->data);	
		$this->parser->parse($sayfa,$this->data);
	}
	//Login olmayan birinin sign_in ve sign_up ve static sayfalar disinda gezinmesini engelliyoruz
	public function login_kontrol(){
		if($this->data['kullanici_giris'] == false){
			$url = base_url()."index.php/pages/sign_in_form";
			header("Location: $url");
		}
	}	
	//dashboard,doldurumlamis son 4 formu getiriyor
	public function index(){	
		$this->data['title'] = "Anasayfa";
		if(isset($this->data['oturum']['id'])){
			$user_id = $this->data['oturum']['id'];
			$this->data['formlar'] = $this->form_model->dashboard_formlarini_getir($user_id);
			$this->data['title'] = "Anasayfa";	
			$this->sayfa_getir('user/dashboard');	
		}
		else{
			$user_id = null;
			$this->data['formlar'] = $this->form_model->dashboard_formlarini_getir($user_id);
			$this->data['title'] = "Anasayfa";	
			$this->sayfa_getir('user/kayitsiz_dashboard');	
		}
	}

	//login form
	public function sign_in_form(){	
		$this->data['title'] = "Giriş Yap";
		$this->sayfa_getir('/user/login/sign_in_form');	
	}
	public function guvenlik_sayfasi(){
		$this->data['title'] = "Güvenlik Sayfası";
		$email = $this->input->post('email',TRUE);
		$sifre = $this->input->post('sifre',TRUE);
		$sifre = do_hash($sifre);
		if($this->user_model->giris_kontrol($email,$sifre)){	
			$this->data['email'] = $email;
			$this->user_model->guvenlik_kodu_gonder($email);	
			$this->parser->parse('user/login/guvenlik_kodu_giris',$this->data);
		}
		else{
			$this->data['hata'] = "E-posta ve ya şifre hatalı!";	
			$this->sayfa_getir('/user/login/sign_in_form');	
		}
	}
	//oturum acma islemleri. Formdan gelen email ve sifre kontrol ediliyor ve varsa oturum aciliyor.
	public function sign_in(){
		$this->data['title'] = "Oturum Açılışı";
		$email = $this->input->post('email',TRUE);
		$guvenlik_kodu = $this->input->post('guvenlik_kodu',TRUE);
		if($this->user_model->guvenlik_kontrol($email,$guvenlik_kodu)){
			$this->user_model->oturum_ac($email);
			$url = base_url()."index.php/pages";
			header( "Refresh: 1; url=".$url);
		}
		else{
			$this->data['hata'] = "Güvenlik Kodu hatalı";	
			$this->parser->parse('user/login/guvenlik_kodu_giris',$this->data);
		}
	}
	//kayit formu
	public function sign_up_form(){
		$this->data['title'] = "Kayit Sayfasi";	
		$this->sayfa_getir('/user/login/sign_up_form');	
	}

	//kayit islemi tamamlaniyor.
	public function sign_up(){
		$isim = $this->input->post('fname',TRUE);
		$soyisim = $this->input->post('lname',TRUE);
		$email = $this->input->post('email',TRUE);
		$sifre = $this->input->post('passwd',TRUE);
		if(substr($email,-10,10) != 'omu.edu.tr'){
			$this->data['title'] = "Kayit Sayfasi";	
			$this->data['bilgilendirme_mesaji'] = "E-posta adresiniz <strong>'omu.edu.tr'</strong> uzantılı olmalı";	$this->sayfa_getir('/user/login/sign_up_form');	
		}
		else{
			if(!$this->user_model->uye_kayit_kontrol($email)){
				$this->data['title'] = "Kayit Sayfasi";	
				$this->data['bilgilendirme_mesaji'] = "Bu e-posta adresi daha önce alınmıştır";			$this->sayfa_getir('/user/login/sign_up_form');	

			}
			$ekle = $this->user_model->yeni_uye_kaydi($isim,$soyisim,$email,$sifre);
			if ($ekle){
				$this->data['bilgilendirme_mesaji'] = "Kullanıcı kaydı başarılı ile gerçekleşmiştir";
				$this->sayfa_getir('user/form/bilgilendirme_basarili');
				$url = base_url()."index.php/pages";
				header( "Refresh: 3; url=".$url);
			}
		}
	}

	//oturum kapatiliyor. Tum sessionlar model'de siliniyor.
	public function cikis_yap(){
		$this->user_model->oturum_kapa();
		$url = base_url()."index.php/pages";
		header( "Location: $url" );
	}

	//form doldurma sayfasi.
	public function form_doldur(){
		$this->login_kontrol();
		$form_id = $this->input->get('form_id',true);
		if(!$form_id){
			$url = base_url()."index.php/pages";
			header( "Refresh: 0; url=".$url);
		}
		$this->data['title'] = "Form Doldurma";
		$this->data['form'] = $this->form_model->form_getir($form_id);	
		$this->sayfa_getir('user/form/form_doldur');	
	}

	public function kayitsiz_form_doldur(){
		$this->data['title'] = "Form Doldurma";
		$form_id = $this->input->get('form_id',true);
		if(!$form_id){
			$url = base_url()."index.php/pages";
			header( "Refresh: 0; url=".$url);
		}
		$this->data['form'] = $this->form_model->form_getir($form_id);	
		$this->sayfa_getir('user/form/kayitsiz_form_doldur');	
	}

	//form inceleme sayfasi. Formdaki her girdi alani disabled,readonly.
	public function form_incele(){
		$this->login_kontrol();
		$this->data['title'] = "Form İncele";
		$form_id = $this->input->get('form_id',true);
		if(!$form_id){
			$url = base_url()."index.php/pages";
			header( "Refresh: 1; url=".$url);
		}
		$user_id = $this->data['oturum']['id'];
		$this->data['form'] = $this->form_model->form_getir_cevaplariyla($form_id,$user_id);	
		$this->sayfa_getir('user/form/form_incele');	
	}
	//form tamamlama
	public function formu_tamamla(){
		$this->data['title'] = "Form kaydı Başarılı";
		$this->login_kontrol();
		$this->data['bilgilendirme_mesaji'] = "Formunuzu başarılı bir şekilde doldurdunuz.";	
		$this->sayfa_getir('pages/static_pages/bilgilendirme');	
	}

	//kullanicinin cevapladigi formlari gordugu sayfa.
	public function cevaplanan_formlar(){
		$this->data['title'] = "Cevaplanan Formlar";
		$this->login_kontrol();
		$user_id = $this->data['oturum']['id'];
		$this->data['formlar'] = $this->form_model->cevaplanan_formlari_getir($user_id);
		$this->sayfa_getir('user/form/formlar');	
	}

	//son olarak kaydedilen 20 form
	public function son_formlar(){
		$this->data['title'] = "Son Formlar";
		$this->login_kontrol();
		$user_id = $this->data['oturum']['id'];
		$this->data['formlar'] = $this->form_model->tum_formlari_getir($user_id,20);	
		$this->sayfa_getir('user/form/formlar');	

	}
	//tum formlari gorme.
	public function tum_formlar(){
		$this->data['title'] = "Tüm Formlar";
		$this->login_kontrol();
		$user_id = $this->data['oturum']['id'];
		$this->data['formlar'] = $this->form_model->tum_formlari_getir($user_id);
		$this->sayfa_getir('user/form/formlar');	

	}
	public function form_kaydet(){
		$this->data['title'] = "Anasayfa";
		$user_id = $this->data['oturum']['id'];
		$form_id = $this->input->post('form_id',TRUE);
		$i=0;
		$id=0;
		$cevap="";
		foreach($this->input->post('cevaplar') as $cvp){
			$cvp = str_replace(array('.', ','), '' , $cvp);
			if($i%2 == 0){
				$id = $cvp;
			}
			else{
				$cevap=$cvp;
				$this->form_model->cevap_kaydet($form_id,$user_id,$id,$cevap);
			}
			$i++;
		}
		$this->form_model->form_cevaplama_kaydet($form_id,$user_id);
		$this->data['bilgilendirme_mesaji'] = "Form doldurma işlemi başarılı ile gercekleşmiştir";
		$this->sayfa_getir('user/form/bilgilendirme_basarili');
		$url = base_url()."index.php/pages";
		header( "Refresh: 3; url=".$url);
	}
	public function kayitsiz_form_kaydet(){
		$this->data['title'] = "Anasayfa";
		$form_id = $this->input->post('form_id',TRUE);
		$i=0;
		$id=0;
		$cevap="";
		$kayitsiz_form_cevaplama_id = $this->form_model->kayitsiz_form_cevaplama_kaydet($form_id);
		foreach($this->input->post('cevaplar') as $cvp){
			$cvp = str_replace(",", "+" , $cvp);

			if($i%2 == 0){
				$id = $cvp;
			}
			else{
				$cevap=$cvp;
				$this->form_model->kayitsiz_cevap_kaydet($form_id,$kayitsiz_form_cevaplama_id,$id,$cevap);
			}
			$i++;
		}
		$this->data['bilgilendirme_mesaji'] = "Tebrikler! Formu başarılı bir şekilde doldurdunuz";
		$this->sayfa_getir('user/form/bilgilendirme_basarili');	
		$url = base_url()."index.php/pages";
		header( "Refresh: 3; url=".$url);
	}
	public function kayitsiz_tum_formlar(){
		$this->data["title"] = "Tüm Formlar";
		$this->data['formlar'] = $this->form_model->kayitsiz_formlar();
		$this->sayfa_getir('user/form/kayitsiz_formlar');	
	}
	public function hakkinda()
	{
		$this->data["title"] = "Hakkında";
		$this->sayfa_getir("includes/hakkinda");
	}
	public function recover()
	{
		$this->data["title"] = "Şifremi Unuttum";
		$this->sayfa_getir("user/login/recover");
	}
	public function res_pass()
	{
		$email = $this->input->post('email');
		$this->user_model->resetpass($email);
	}
}
