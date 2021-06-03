<?php

class urunler extends Controller  {
	
	
	function __construct() {

        parent::KutuphaneYukle(array("View","Bilgi","Pagination"));
		
	Session::init();	
	
	$this->Modelyukle('urunler');

	/*$this->view->goster("sayfalar/index",
	array(
	"data1" => $this->model->anasayfaUrunler("urunler","where durum=0 order by id desc"),	"data2" => $this->model->anasayfaUrunler("urunler","where durum=1 order by id desc")
	
	));*/
		
	}	
	
	
	function detay($id,$ad,$mevcutsayfa=false) {
		
		//** gelen id ye göre urunlere bağlanarak ilgili ürünün tüm verileri çekilecek ve sayfaya gönderilecek.
		
		
		$sonuc=$this->model->uruncek("urunler","where id=".$id);


		if(isset($sonuc[0]["katid"])):

		//$sonuc[0]["katid"]
		
		//and id!=".$id
		
		$this->View->goster("sayfalar/urundetay",
		array(
		"data1" => $sonuc,
		"data2" => $this->model->uruncek("urunler","where katid=".$sonuc[0]["katid"]." and id<>$id and stok < 200 order by stok asc LIMIT 10 "),
		"data3" =>$this->model->uruncek("urunler","where katid=".$sonuc[0]["katid"]." and id<>$id  LIMIT 3"),
		"data4" =>$this->model->uruncek("yorumlar","where urunid=$id and durum=1")  
		));
		
		// 	"data3" =>$this->model->uruncek("urunler","where katid=".$sonuc[0]["katid"]." and id<>$id and stok > 180 LIMIT 3")  
	
		// echo $id. " = ". $ad;



        else:

        $this->Bilgi->direktYonlen("/");

        endif;
	
	} //ÜRÜN DETAY
	
	function kategori($id,$ad,$mevcutsayfa=false) {
		
		$sonuc=$this->model->uruncek("urunler","where katid=".$id);
		$CocukKAtBul=$this->model->uruncek("alt_kategori","where id=".$id);
		//13

        $this->Pagination->paginationOlustur(count($sonuc),$mevcutsayfa,$this->model->tekliveri("ArayuzUrunlerGoruntuAdet"," from ayarlar"));

        if(count($sonuc)>0 && count($CocukKAtBul)>0):
		
		$this->View->goster("sayfalar/kategori",
		array(
		"data1" => $this->model->uruncek("urunler","where katid=".$id." LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
		"data2" => $this->model->uruncek("alt_kategori",
		"where cocuk_kat_id=".$CocukKAtBul[0]["cocuk_kat_id"]." and id<>$id"),
		"data3" =>$this->model->uruncek("urunler","where katid=".$id." and durum=1  LIMIT 5"),
        "toplamsayfa"=>$this->Pagination->toplamsayfa,
        "toplamveri"=>count($sonuc),
        "katid"=>$id,
        "katad"=>$ad
		));

        else:

            $this->Bilgi->direktYonlen("/");

        endif;
		
		
	}

	
}




?>