<?php
class Admin_form_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	//form olusturmada. onBlur ile soru ekleme
	public function soru_ekle($form_id,$tur){
		$soru = array(
			'form_id' => $form_id,
			'soru' => "",
			'soru_turu' => "$tur"
		);
		$kontrol = $this->db->insert('sorular', $soru); 
		if($kontrol){
			$sql = "SELECT * FROM  `sorular` WHERE  `form_id` = '$form_id' order by id desc LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$id = $sonuc['id'];
			return $id;
		}
		else{
			return false;
		}
	}

	//form olusturmada. onBlur ile secenek ekleme
	public function secenek_ekle($form_id,$soru_id){
		$soru = array(
			'form_id' => $form_id,
			'soru_id' => $soru_id,
			'secenek' => "",
		);
		$kontrol = $this->db->insert('coktan_secmeli', $soru); 
		if($kontrol){
			$sql = "SELECT * FROM  `coktan_secmeli` WHERE  `soru_id` = '$soru_id' order by id desc LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$id = $sonuc['id'];
			return $id;
		}
		else{
			return false;
		}
	}
	//form olusturmada. onBlur ile soru girildikten sonra kaydedilmesi
	public function soru_kaydet($soru_id,$soru){
		$data = array(
		       'soru' => $soru
           	 );
		$this->db->where('id', $soru_id);
		$this->db->update('sorular', $data); 
	}

	//form olusturmada. onBlur ile secenek girildikten sonra kaydedilmesi
	public function secenek_kaydet($secenek_id,$secenek){
		$sql ="UPDATE  `coktan_secmeli` SET  `secenek` =  '$secenek' WHERE  `id` =$secenek_id";
		$sorgu = $this->db->query($sql);
	}
	public function formlari_getir($limit=null){
		$this->db->order_by('id','desc');
		if(isset($limit)){ $this->db->limit($limit,0);}
		$query = $this->db->get('form');
		$sonuclar = array();		
		foreach ($query->result() as $row)
		{
			array_push($sonuclar,array('id' => $row->id,'baslik' => $row->baslik,'bilgilendirme' => $row->bilgilendirme,'zaman' => $row->zaman));
		}

		return $sonuclar;
	}	

	
	//form olusturmaya baslamadan once bilgilerin kaydedilmesi,id alinmasi
	public function form_kaydet($baslik,$bilgilendirme,$gizlilik){
		
		$form = array(
			'baslik' => $baslik,
			'bilgilendirme' => "$bilgilendirme",
			'gizlilik' => $gizlilik,
		);
		$kontrol = $this->db->insert('form', $form); 
		if($kontrol){
			$sql = "SELECT * FROM  `form` order by id desc LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$id = $sonuc['id'];
			return $id;
		}
		else{
			return false;
		}
	}
	public function son_doldurulan_formlari_getir($limit=null){
		if(isset($limit)){ $this->db->limit($limit,0);}
		$this->db->order_by('id','desc');
		$query = $this->db->get('form_cevaplamalari');
		$sonuclar = array();
		foreach ($query->result() as $cevaplamalar)
		{
			$form_id = $cevaplamalar->form_id;
			$user_id = $cevaplamalar->user_id;
			$zaman = $cevaplamalar->zaman;
			$sql = "SELECT * FROM  `kullanici` WHERE  `id` = '$user_id' LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$kullanici = ucwords(strtolower($sonuc['isim']));
			$kullanici .= " ";
			$kullanici .= strtoupper($sonuc['soyisim']);

			$sql = "SELECT * FROM  `form` WHERE  `id` = '$form_id' LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$baslik = ucwords(strtolower($sonuc['baslik']));

			array_push($sonuclar,array('form_id' => $form_id, 'user_id' => $user_id, 'kullanici' => $kullanici,'form_baslik' => $baslik,'zaman' => $zaman));
	
		}
		return $sonuclar;
	}	
	public function formu_cevaplandiran_uyeler($form_id){
		$this->db->order_by('id','desc');
		$this->db->where('form_id',$form_id);
		$query = $this->db->get('form_cevaplamalari');
		$sonuclar = array('form_id' => $form_id, 'baslik' => null,'kullanicilar' => array());
		foreach ($query->result() as $cevaplamalar)
		{
			$form_id = $cevaplamalar->form_id;
			$user_id = $cevaplamalar->user_id;
			$zaman = $cevaplamalar->zaman;
			$sql = "SELECT * FROM  `kullanici` WHERE  `id` = '$user_id' LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$kullanici = ucwords(strtolower($sonuc['isim']));
			$kullanici .= " ";
			$kullanici .= strtoupper($sonuc['soyisim']);

			$sql = "SELECT * FROM  `form` WHERE  `id` = '$form_id' LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			if(!isset($sonuclar['baslik'])){
				$sonuclar['baslik'] = ucwords(strtolower($sonuc['baslik']));
			}
			array_push($sonuclar['kullanicilar'],array('user_id' => $user_id, 'kullanici' => $kullanici,'zaman' => $zaman));
	
		}
		return $sonuclar;
	}
	public function kullanicinin_cevaplandirdigi_formlar($user_id){
		$this->db->order_by('id','desc');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('form_cevaplamalari');
		$sonuclar = array('user_id' => $user_id,'kullanici' => null,'formlar' => array());
		foreach ($query->result() as $cevaplamalar)
		{
			$form_id = $cevaplamalar->form_id;
			$zaman = $cevaplamalar->zaman;
			$sql = "SELECT * FROM  `kullanici` WHERE  `id` = '$user_id' LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$kullanici = ucwords(strtolower($sonuc['isim']));
			$kullanici .= " ";
			$kullanici .= strtoupper($sonuc['soyisim']);
			if(!isset($sonuclar['kullanici'])){
				$sonuclar['kullanici'] = $kullanici;
			}
			$sql = "SELECT * FROM  `form` WHERE  `id` = '$form_id' LIMIT 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$baslik = ucwords(strtolower($sonuc['baslik']));
			array_push($sonuclar['formlar'],array('form_id' => $form_id, 'baslik' => $baslik,'zaman' => $zaman));
	
		}
		return $sonuclar;
	}
	public function formu_sil($id){
		$this->db->delete('form', array('id' => $id)); 
		$this->db->delete('form_cevaplamalari', array('form_id' => $id)); 
		$this->db->delete('cevaplar', array('form_id' => $id)); 
		$this->db->delete('coktan_secmeli', array('form_id' => $id)); 
		$this->db->delete('kayitsiz_form_cevaplamalari', array('form_id' => $id)); 
		$this->db->delete('kayitsiz_form_cevaplari', array('form_id' => $id)); 
		$this->db->delete('sorular', array('form_id' => $id)); 
	}
	public function kayitsizlar_form_to_excel_model($form_id){
		$this->db->where('form_id',$form_id);
		$query = $this->db->get('sorular');
		$sorular = array();
		$cevaplar = array();
		foreach ($query->result() as $soru)
		{
			array_push($sorular,$soru->soru);		
		}
		$this->db->where('form_id',$form_id);
		$query = $this->db->get('kayitsiz_form_cevaplamalari');
		foreach ($query->result() as $cevaplama)
		{
			$cevaplama_id = $cevaplama->id;	
			$this->db->where('form_id',$form_id);
			$this->db->where('kayitsiz_form_cevaplama_id',$cevaplama_id);
			$query = $this->db->get('kayitsiz_form_cevaplari');
			$kullanici_cevaplari = array();
			foreach ($query->result() as $cevap)
			{
				array_push($kullanici_cevaplari,$cevap->cevap);
			}
			array_push($cevaplar,$kullanici_cevaplari);
		}
		return array('sorular' => $sorular,'cevaplar' => $cevaplar);
	}
	public function kayitlilar_form_to_excel_model($form_id){
		$cevaplar = array();
		$this->db->where('form_id',$form_id);
		$query = $this->db->get('form_cevaplamalari');
		foreach ($query->result() as $cevaplama)
		{
			$user_id = $cevaplama->user_id;	
			$this->db->where('form_id',$form_id);
			$this->db->where('user_id',$user_id);
			$query = $this->db->get('cevaplar');
			$kullanici_cevaplari = array();
			$kullanici = array();
			$sql = "SELECT * FROM  `kullanici` WHERE  `id` = $user_id LIMIT 0 , 1";
			$sorgu = $this->db->query($sql);
			$sonuc = $sorgu->row_array();
			$kullanici['isim'] = $sonuc['isim'];
			$kullanici['soyisim'] = $sonuc['soyisim'];
			foreach ($query->result() as $cevap)
			{
				array_push($kullanici_cevaplari,$cevap->cevap);
			}
			array_push($cevaplar,array('kullanici' => $kullanici,'cevaplar' => $kullanici_cevaplari));
		}
		return $cevaplar;
	}	
	public function get_form_to_excel_dosya_ismi($form_id){
		$sql ="SELECT * FROM  `form` WHERE  `id` = $form_id LIMIT 0 , 1";
		$sorgu = $this->db->query($sql);
		$sonuc = $sorgu->row_array();
		$baslik = $sonuc['baslik'];
		setlocale(LC_ALL, 'en_US.UTF8');
		return  iconv("UTF-8", "ASCII//TRANSLIT//IGNORE", substr(urlencode($baslik),0,50));
	}
}
