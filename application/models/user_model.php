<?php
class User_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	//Eger uye kaydi basarili olursa 1,basarisiz olursa 0 donuyor.
	public function yeni_uye_kaydi($isim,$soyisim,$email,$sifre){
		
		$uye = array(
			'isim' => $isim,
			'soyisim' => $soyisim,
			'email' => $email,
			'sifre' => do_hash($sifre));
		$kontrol = $this->db->insert('kullanici', $uye); 
		return $kontrol;
	}

	//eger o email adresine sahip uye var ise 0, yok ise 1 return ediyoruz.
	public function uye_kayit_kontrol($email){
		$sql = "SELECT * FROM  `kullanici`WHERE  `email` =  '$email'";
		$sorgu = $this->db->query($sql);
		$kontrol = $sorgu->num_rows($sorgu);
		//Eger kontrol 0'dan buyuk ise,yani email varsa
		if($kontrol){
			return false;
		}
		//Eger kontrol 0 ise, yani yoksa
		else{
			return true;
		}
	}

	//uye girisi email,sifre kontrol.Eger uye varsa, 1 donecek. Yoksa 0.
	public function giris_kontrol($email,$sifre){
		$sql = "SELECT * FROM  `kullanici` WHERE  `email` = '$email' and `sifre` = '$sifre'";
		$sorgu = $this->db->query($sql);
		$kontrol = $sorgu->num_rows($sorgu);
		return $kontrol;
	}

	//Login.Session'larin acilmasi. Oturum acilmasi.
	public function oturum_ac($email){
		$sql = "SELECT * FROM  `kullanici` WHERE  `email` = '$email' LIMIT 1";
		$sorgu = $this->db->query($sql);
		$sonuc = $sorgu->row_array();
		$id = $sonuc['id'];
		$isim = $sonuc['isim'];
		$soyisim = $sonuc['soyisim'];
		$session_bilgileri = array(
                   'id'  => $id,
                   'isim'  => $isim,
                   'soyisim'  => $soyisim,
                   'email'     => $email,
		   'yetki' => 'kullanici',
                   'logged_in' => TRUE
               );
		$this->session->set_userdata($session_bilgileri);
	}
	
	//Log out. Kullanici oturumunu sonlandirma.
	public function oturum_kapa(){
		$session_bilgileri = array('id' => '', 'isim' => '', 'soyisim' => '', 'email' => '', 'logged_in' => '');
		$this->session->unset_userdata($session_bilgileri);
	}
	
	// array return ediyor. ['id' => id, 'isim' => isim, 'soyisim' => soyisim, 'email' => email, 'logged_in' =>1 ] gibi.
	public function oturum_bilgileri(){
		return $this->session->all_userdata();
	}
	
	//kullanici oturum acmis mi acmamis mi onu kontrol ediyor. aciksa true,degilse false donduruyor.
	public function oturum_kontrol(){
		$oturum = $this->session->all_userdata();
		if(isset($oturum['logged_in'])){
			if($oturum['yetki'] == 'kullanici'){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

	//google ile mail gonderme. 
	public function guvenlik_kodu_gonder($email){
		$guvenlik_koduguvenlik_kodu = rand(10000000,99999999);
		$sql = "UPDATE  `universite`.`kullanici` SET  `dogrulama_kodu` =  '$guvenlik_kodu' WHERE `kullanici`.`email` ='$email'";
		$sorgu = $this->db->query($sql);
		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'omuwebmail@gmail.com',
		    'smtp_pass' => 'levend03',
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from('omuwebmail@gmail.com','Omu Web Bilgi Toplama Sistemi');
		$this->email->to($email);
		$this->email->subject("19 Mayıs Üniversitesi Bilgi İşlem Daire Başkanlığı");
		$this->email->message($guvenlik_kodu);
		if($this->email->send()){
			return true;	
		}else{
			return false;
		}
	}
	public function guvenlik_kontrol($email,$guvenlik_kodu){
		$sql = "SELECT * FROM  `kullanici` WHERE  `email` = '$email' and `dogrulama_kodu` = '$guvenlik_kodu'";
		$sorgu = $this->db->query($sql);
		$kontrol = $sorgu->num_rows($sorgu);
		return $kontrol;	
	}
	public function resetpass($email)
	{
		$sorgu = $this->db->query("select * from `kullanici` where `email` = '$email'");
	       	if ($sorgu->num_rows > 0) {
			$user = $sorgu->result()[0];
			/* Şifre yeniliyoruz */
			
	       	}
	}
}
