<?php
class Admin_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	//kayitli kullanicilari gorme
	public function kullanicilari_getir($limit=null){
		$this->db->order_by('id','desc');
		if(isset($limit)){$this->db->limit($limit,0);}
		$query = $this->db->get('kullanici');
		$sonuclar = array();		
		foreach ($query->result() as $row)
		{
			array_push($sonuclar,array('id' => $row->id,'isim' => ucwords(strtolower($row->isim)),'soyisim' => strtoupper($row->soyisim),'email' => $row->email,'zaman' => $row->zaman));
		}

		return $sonuclar;
	}
	public function admin_kontrol($email,$sifre){
		$sql = "SELECT * FROM  `admin` WHERE  `email` = '$email' and `sifre` = '$sifre'";
		$sorgu = $this->db->query($sql);
		$kontrol = $sorgu->num_rows($sorgu);
		return $kontrol;
	}
	public function oturum_ac($email){
		$session_bilgileri = array(
                   'yetki'     => 'admin',
                   'email'     => $email,
                   'logged_in' => TRUE
                );
		$this->session->set_userdata($session_bilgileri);
	}
	public function oturum_kapa(){
		$session_bilgileri = array('email' => '', 'yetki' => '', 'logged_in' => '');
		$this->session->unset_userdata($session_bilgileri);
	}
	public function oturum_bilgileri(){
		return $this->session->all_userdata();
	}
	
	public function oturum_kontrol(){
		$oturum = $this->session->all_userdata();
		if(isset($oturum['logged_in'])){
			if($oturum['yetki']=='admin'){
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
	public function guvenlik_kodu_gonder($email){
		$guvenlik_kodu = rand(10000000,99999999);
		$sql = "UPDATE  `universite`.`admin` SET  `dogrulama_kodu` =  '$guvenlik_kodu' WHERE `admin`.`email` ='$email';";
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
		$sql = "SELECT * FROM  `admin` WHERE  `email` = '$email' and `dogrulama_kodu` = '$guvenlik_kodu'";
		$sorgu = $this->db->query($sql);
		$kontrol = $sorgu->num_rows($sorgu);
		return $kontrol;	
	}
}
