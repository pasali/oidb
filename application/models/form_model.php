<?php
class Form_model extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}
	//kullanici cevapladigi forumlar
	public function cevaplanan_formlari_getir($user_id){
		$this->db->where('user_id',$user_id);
		$this->db->order_by("id", "desc");
		$query = $this->db->get('form_cevaplamalari');
		$sonuclar = array();		
		foreach ($query->result() as $row)
		{
			$form_id = $row->form_id;
			$this->db->where('id',$form_id);
			$query = $this->db->get('form');
			$sonuc = $query->row_array();
			array_push($sonuclar,array('id' => $form_id,'durum' => 'dolduruldu','baslik' => $sonuc['baslik']));	
		}
		return $sonuclar;
	}
	//tum forumlari getirme
	public function tum_formlari_getir($user_id=null,$limit=null){
		$this->db->order_by("id", "desc");
		$query = $this->db->get('form');
		$sonuclar = array();
		foreach ($query->result() as $row)
		{
			$form_id = $row->id;
			$this->db->where('form_id',$form_id);
			if($user_id){$this->db->where('user_id',$user_id);}
			if($limit){$this->db->limit($limit,0);}
			$query = $this->db->get('form_cevaplamalari');
			if(!$query->num_rows()){
				array_push($sonuclar,array('id' => $form_id,'durum' => 'doldurulmadi','baslik' => $row->baslik,'bilgilendirme' => $row->bilgilendirme));	
			}
			else{
				array_push($sonuclar,array('id' => $form_id,'durum' => 'dolduruldu','baslik' => $row->baslik,'bilgilendirme' => $row->bilgilendirme));	
			}
		}
		return $sonuclar;

	}
	//forum girdi esnasinda onBlur ile cevabin kaydedilmesi
	public function cevap_kaydet($form_id,$user_id,$soru_id,$cevap){
		$cevap = array(
			'form_id' => $form_id,
			'user_id' => $user_id,
			'soru_id' => $soru_id,
			'cevap' => "$cevap"
		);
		$this->db->insert('cevaplar', $cevap); 

	}
	public function kayitsiz_cevap_kaydet($form_id,$kayitsiz_form_cevaplama_id,$soru_id,$cevap){
		$cevap = array(
			'form_id' => $form_id,
			'kayitsiz_form_cevaplama_id' => $kayitsiz_form_cevaplama_id,
			'soru_id' => $soru_id,
			'cevap' => "$cevap"
		);
		$this->db->insert('kayitsiz_form_cevaplari', $cevap); 

	}
	public function kayitsiz_form_cevaplama_kaydet($form_id){

		$kaydedilecek = array(
			'form_id' => $form_id,
		);
		$this->db->insert('kayitsiz_form_cevaplamalari', $kaydedilecek);
		$this->db->order_by('id','desc');
		$query = $this->db->get('kayitsiz_form_cevaplamalari');
		$sonuc = $query->row_array();	
		return $sonuc['id'];	
	}
	//kullanici formu bitirdiginde,veritabanina bitirdiginin kaydedilmesi
	public function form_cevaplama_kaydet($form_id,$user_id){

		$kaydedilecek = array(
			'form_id' => $form_id,
			'user_id' => $user_id,
		);
		$this->db->insert('form_cevaplamalari', $kaydedilecek); 
	}

	//kullanici ve admin icin. Formu detayli gorme modeli
	public function form_getir($form_id){
			$sonuclar = array('yazilar' => array(),'sorular' => array(),'form_id' => $form_id);
			$query = $this->db->query("SELECT * FROM `form` where `id`=$form_id");
			
			foreach ($query->result() as $form_satir)
			{
			    array_push($sonuclar['yazilar'],array('baslik' => $form_satir->baslik,'bilgilendirme' => $form_satir->bilgilendirme));
			}
			$query = $this->db->query("SELECT * FROM  `sorular` WHERE  `form_id` =$form_id");
			$sonuclar['soru_sayisi'] = $query->num_rows();
			foreach ($query->result() as $soru_satir)
			{
			    $id = $soru_satir->id;
				$soru = $soru_satir->soru;
				$soru_turu = $soru_satir->soru_turu;
				if($soru_turu == "coktan_secmeli"){
					$sorumuz = array('id' => $id, 'soru' => $soru, 'soru_turu' => $soru_turu,'secenekler' => array());
					$query = $this->db->query("SELECT * FROM  `coktan_secmeli` WHERE  `soru_id` =$id");
					foreach ($query->result() as $secmeli_satir)
					{
						array_push($sorumuz['secenekler'],$secmeli_satir->secenek);
					}
				}
				else{	
					$sorumuz = array('id' => $id, 'soru' => $soru, 'soru_turu' => $soru_turu);
				}
				array_push($sonuclar['sorular'],$sorumuz);
			}
			return $sonuclar;			
	}
	public function form_getir_cevaplariyla($form_id,$user_id){
			$sonuclar = array('kullanici' => null,'yazilar' => array(),'sorular' => array());
			$query = $this->db->query("SELECT * FROM  `kullanici` WHERE  `id` =$user_id");
			$sonuc = $query->row_array();	
			$kullanici = ucwords(strtolower($sonuc['isim']));
			$kullanici .= " ";
			$kullanici .= strtoupper($sonuc['soyisim']);
			$sonuclar['kullanici'] = $kullanici;	
			
			$query = $this->db->query("SELECT * FROM `form` where `id`=$form_id");
			foreach ($query->result() as $form_satir)
			{
			    array_push($sonuclar['yazilar'],array('baslik' => $form_satir->baslik,'bilgilendirme' => $form_satir->bilgilendirme));
			}
			$query = $this->db->query("SELECT * FROM  `sorular` WHERE  `form_id` =$form_id");
			$sonuclar['soru_sayisi'] = $query->num_rows();
			foreach ($query->result() as $soru_satir)
			{
			        $soru_id = $soru_satir->id;
				
				$query = $this->db->query("SELECT * FROM  `cevaplar` WHERE  `user_id` =$user_id AND  `soru_id` =$soru_id LIMIT 0 , 1");
				$sonuc = $query->row_array();		

				$cevap = $sonuc['cevap'];
				$soru = $soru_satir->soru;
				$soru_turu = $soru_satir->soru_turu;
				if($soru_turu == "coktan_secmeli"){
					$sorumuz = array('id' => $soru_id, 'soru' => $soru, 'soru_turu' => $soru_turu,'secenekler' => array(),'cevap' => $cevap);
					$query = $this->db->query("SELECT * FROM  `coktan_secmeli` WHERE  `soru_id` =$soru_id");
					foreach ($query->result() as $secmeli_satir)
					{
						array_push($sorumuz['secenekler'],$secmeli_satir->secenek);
					}
				}
				else{	
					$sorumuz = array('id' => $soru_id, 'soru' => $soru, 'soru_turu' => $soru_turu,'cevap' => $cevap);
				}
				array_push($sonuclar['sorular'],$sorumuz);
			}
			return $sonuclar;			
	}
	public function dashboard_formlarini_getir($user_id){
		if($user_id){
			$this->db->order_by("id", "desc");	
			$query = $this->db->get('form');
			$sonuclar = array();
			foreach ($query->result() as $row)
			{
				$form_id = $row->id;
				$this->db->where('form_id',$form_id);
				$this->db->where('user_id',$user_id);
				$query = $this->db->get('form_cevaplamalari');
				if(!$query->num_rows()){
					array_push($sonuclar,array('id' => $form_id,'durum' => 'doldurulmadi','baslik' => $row->baslik,'bilgilendirme' => $row->bilgilendirme));	
				}
			}
			return $sonuclar;
		}
		else{	
			$this->db->order_by("id", "desc");
			$this->db->where('gizlilik','acik');	
			$query = $this->db->get('form');
			$sonuclar = array();
			foreach ($query->result() as $row)
			{
				$form_id = $row->id;
				$this->db->where('form_id',$form_id);
				array_push($sonuclar,array('id' => $form_id,'baslik' => $row->baslik,'bilgilendirme' => $row->bilgilendirme));	
			}
			return $sonuclar;

		}
	}
	public function kayitsiz_formlar(){
		$this->db->order_by("id", "desc");
		$query = $this->db->get('form');
		$sonuclar = array();
		foreach ($query->result() as $row)
		{
			array_push($sonuclar,array('id' => $row->id,'baslik' => $row->baslik,'bilgilendirme' => $row->bilgilendirme));	
		}
		return $sonuclar;

	}
}
