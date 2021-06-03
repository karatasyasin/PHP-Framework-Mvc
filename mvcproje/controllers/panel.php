<?php

class panel extends Controller  {

    public $yetkikontrol,$aramadegeri;
	
	function __construct() {
        Session::init();

        parent::KutuphaneYukle(array("View","Form","Bilgi","Upload","Pagination","Dosyacikti","Mailislem"));

        Router::init();

        $this->Modelyukle('adminpanel');
        if (!Session::get("AdminAd") && !Session::get("Adminid")) :
            $this->giris();
            exit();
        else:
            $this->yetkikontrol=new PanelHariciFonksiyonlar();
        endif;

	} // construct

    function giris() {

        if (Session::get("AdminAd") && Session::get("Adminid")) :
            $this->Bilgi->direktYonlen("/panel/siparisler");
        else:
            $this->View->goster("YonPanel/sayfalar/index");
            //Router::SayfaYukleme("ADMİN",false,"index",false,null);
        endif;



    } // GİRİŞ SAYFASI

	function index() {

	    if ($this->yetkikontrol->yoneticiYetki==2):
            $this->urunler();
	    elseif ($this->yetkikontrol->yoneticiYetki==3):
            $this->uyeler();
        else:
            $this->siparisler();
        endif;




	} // VARSAYILAN OLARAK ÇALIŞIYOR

    //----------------------------------------------------

    function siparisler() {
        Router::SayfaYukleme("ADMİN","siparisYonetim","siparis","SpesifikVerial",
            [["data","siparis_no from siparisler"]]
        );


    } // SİPARİŞLERİN ANA EKRANI

    function kargoguncelle($islem,$sipno=false) {

        Router::Guncelle(
            [$islem,"ADMİN","siparisYonetim","siparis","Verial",
            [["KargoGuncelle","siparisler","where siparis_no=".$sipno]]],
            ["kargodurum"],
            ["select" => "durum"],
            "sipno",
            "siparis_no=",
            "siparisler",
            "siparisler",
            "KARGO GÜNCELLEME BAŞARILI", "KARGO GÜNCELLEME SIRASINDA HATA OLUŞTU."
        );



    } // KARGO DURUM GÜNCELLEME

    function siparisarama(){

        $this->yetkikontrol->YetkisineBak("siparisYonetim");

        if ($_POST):
            $aramatercih = $this->Form->get("aramatercih")->bosmu();
            $aramaverisi = $this->Form->get("aramaverisi")->bosmu();

            if (!empty($this->form->error)):
                $this->view->goster("YonPanel/sayfalar/siparis",
                    array(
                        "bilgi" => $this->Bilgi->hata("BİLGİ GİRİLMELİDİR","/panel/siparisler",1)
                    ));
            else:

                if ($aramatercih=="sipno"):
                    $this->View->goster("YonPanel/sayfalar/siparis",array(
                        "data"=>$this->model->arama("siparisler","siparis_no LIKE '".$aramaverisi."'")));

                elseif ($aramatercih=="uyebilgi"):

                    $bilgicek=$this->model->arama("uye_panel",
                        "id LIKE '%".$aramaverisi."%' or 
                        ad LIKE '%".$aramaverisi."%' or 
                        soyad LIKE '%".$aramaverisi. "%' or 
                        telefon LIKE '%".$aramaverisi."%'");


                if ($bilgicek):
                    $this->View->goster("YonPanel/sayfalar/siparis",array(
                        "data"=>$this->model->arama("siparisler","uyeid LIKE '".$bilgicek[0]["id"]."'"))
                    );


                else:
                    $this->View->goster("YonPanel/sayfalar/siparis",
                        array(
                            "bilgi" => $this->Bilgi->hata("HİÇBİR KRiTER UYUŞMADI","/panel/siparisler",1)
                        ));
                    endif;

                    endif;

            endif;

        else:
            $this->Bilgi->direktYonlen("/panel/siparisler");
        endif;


    } //SİPARİŞ ARAMA

    function siparisdetayliarama() {
        $this->yetkikontrol->YetkisineBak("siparisYonetim");

        if ($_POST) :
            $siparis_no=$this->Form->get("siparis_no",true);
            $uyebilgi=$this->Form->get("uyebilgi",true);
            $kargodurum=$this->Form->get("kargodurum",true);
            $odemeturu=$this->Form->get("odemeturu",true);
            $durum=$this->Form->get("durum",true);
            $tarih1=$this->Form->get("tarih1",true);
            $tarih2=$this->Form->get("tarih2",true);

            if (!empty($siparis_no)) : $this->aramadegeri.="<strong>Sipariş Numarası :</strong> ".$siparis_no;	endif;
            if (!empty($kargodurum)) :
                switch ($kargodurum):
                    case "0";
                        $this->aramadegeri.="<strong>Kargo Durumu :</strong> Tedarik Sürecinde ";
                        break;
                    case "1";
                        $this->aramadegeri.="<strong>Kargo Durumu :</strong> Paketleniyor ";
                        break;
                    case "2";
                        $this->aramadegeri.="<strong>Kargo Durumu :</strong> Kargolandı ";
                        break;
                endswitch;

            endif;
            if (!empty($odemeturu)) : $this->aramadegeri.="<strong>Ödeme Türü :</strong> ".$odemeturu." ";	endif;
            if (!empty($durum)) :
                switch ($durum):
                    case "0";
                        $this->aramadegeri.="<strong>Sipariş Durumu :</strong> İşlemde ";
                        break;
                    case "1";
                        $this->aramadegeri.="<strong>Sipariş Durumu :</strong> Tamamlanmış ";
                        break;
                    case "2";
                        $this->aramadegeri.="<strong>Sipariş Durumu :</strong> İade ";
                        break;

                endswitch;

            endif; // arama kriteri şekilleniyor


            if (!empty($tarih1) && !empty($tarih2)) :
                $tarihbilgisi="and	DATE(tarih) BETWEEN  '".$tarih1."' and '".$tarih2."'";
                $this->aramadegeri.="<strong>Başlangıç tarihi :</strong> ".$tarih1 ." <strong>Bitiş tarihi :</strong> ".$tarih2;
            endif;

            if (!empty($uyebilgi)) :
                $bilgicek=$this->model->arama("uye_panel",
                    "id LIKE '%".$uyebilgi."%' or 
			ad LIKE '%".$uyebilgi."%' or 
			soyad LIKE '%".$uyebilgi."%' or 
			telefon LIKE '%".$uyebilgi."%'");



                if ($bilgicek):
                    $this->View->goster("YonPanel/sayfalar/siparisdetayarama",array(
                        "data" => $this->model->arama("siparisler",
                            "uyeid='".$bilgicek[0]["id"]."' and
					siparis_no LIKE '%".$siparis_no."%' and
					kargodurum LIKE '%".$kargodurum."%' and
					odemeturu LIKE '%".$odemeturu."%' and
					durum LIKE '%".$durum."%' ".@$tarihbilgisi."
					"),
                        "aramakriter" => $this->aramadegeri
                    ));
                endif;


            elseif (!empty($siparis_no)) :
                $this->View->goster("YonPanel/sayfalar/siparisdetayarama",array(
                    "data" => $this->model->arama("siparisler","siparis_no LIKE ".$siparis_no),
                    "aramakriter" => $this->aramadegeri
                ));
            else :

                $this->View->goster("YonPanel/sayfalar/siparisdetayarama",array(
                    "data" => $this->model->arama("siparisler",
                        "kargodurum LIKE '%".$kargodurum."%' and
					odemeturu LIKE '%".$odemeturu."%' and
					durum LIKE '%".$durum."%' ".@$tarihbilgisi."
					"),
                    "aramakriter" => $this->aramadegeri
                ));
            endif;

        else:
            $this->View->goster("YonPanel/sayfalar/siparisdetayarama",array(
                "varsayilan" => true
            ));
        endif;
    } // SİPARİŞ  DETAYLI ARAMA

    function siparisExcelAl () {

        $this->yetkikontrol->YetkisineBak("siparisYonetim");
        $gelennumaralar=Session::get("numaralar");
        $this->model->ExcelAyarCek2("siparis_no,urunad,urunadet,urunfiyat,toplamfiyat,kargodurum,odemeturu,durum,tarih from siparisler where siparis_no IN(".$gelennumaralar.")");

        $this->Dosyacikti->Excelaktar("SİPARİŞLER",NULL,
            array(
                "Sipariş numarası",
                "Ürün ad",
                "Ürün adet",
                "Ürün fiyat",
                "Toplam Fiyat",
                "Kargo durum",
                "Ödeme Türü",
                "Durum",
                "Tarih"
            ),$this->model->icerikler[0]);

    } // SİPARİŞ EXCEL ÇIKTI

    function siparisiade() {

        Router::SayfaYukleme("ADMİN","siparisYonetim","siparisiade","SpesifikVerial",
            [["data","siparis_no from siparisler where durum=2"]]);


    } // SİPARİŞLERİN İADESİ

    //----------------------------------------------------

    function kategoriler() {

        Router::SayfaYukleme("ADMİN","kategoriYonetim","kategoriler","Verial",
            [["anakategori","ana_kategori","false"],
                ["cocukkategori","cocuk_kategori","false"],
                ["altkategori","alt_kategori","false"]]
        );

    } // KATEGORİLER GELİYOR

    function kategoriGuncelle($islem,$kriter=false,$id=false){

        Router::KategoriGuncelle(
            [$islem,"ADMİN","kategoriYonetim","kategoriguncelleme","Verial",
                [
                    ["data",$kriter."_kategori"," where id=".$id],
                    ["kriter",$kriter],
                    ["AnakategorilerTumu","ana_kategori","false"],
                    ["CocukkategorilerTumu","cocuk_kategori","false"]
                ]],
            ["input1" => "kriter","input2" => "katad","select1" => "anakatid","select2" => "cocukkatid"],
            "kayitid",
            "id=",
            "kategoriler",
            "KATEGORİ GÜNCELLEME BAŞARILI", "KATEGORİ GÜNCELLEME SIRASINDA HATA OLUŞTU."
        );

    } // KATEGORİLER GÜNCELLE

    function kategoriSil($kriter,$id){

        Router::Sil("ADMİN","kategoriYonetim","kategoriler","kategoriler",
            [$kriter."_kategori","id=".$id],
            "KATEGORİ SİLME BAŞARILI", "KATEGORİ SİLME SIRASINDA HATA OLUŞTU.");

    } //KATEGORİ SİL

    function kategoriEkle($islem,$kriter=false){
        $this->yetkikontrol->YetkisineBak("kategoriYonetim");

	    if ($islem=="ilk"):
            Router::SayfaYukleme("ADMİN","kategoriYonetim","kategoriekle","Verial",
                [["kriter",$kriter],
                    ["AnakategorilerTumu","ana_kategori","false"],
                    ["CocukkategorilerTumu","cocuk_kategori","false"]]
            );
	    else:

            if($_POST):
                $kriter=$this->Form->get("kriter")->bosmu();
                $katad=$this->Form->get("katad")->bosmu();

                @$anakatid=$_POST["anakatid"];
                @$cocukkatid=$_POST["cocukkatid"];

                if (!empty($this->form->error)):
                    $this->View->goster("YonPanel/sayfalar/kategoriekle",
                        array(
                            "bilgi" => $this->Bilgi->hata("KATEGORİ ADI GİRİLMELİDİR","/panel/kategoriler",1)
                        ));

                else:

                    if ($kriter=="ana"):

                        $sonuc=$this->model->Ekleme("ana_kategori",
                            array("ad"),
                            array($katad));

                    elseif ($kriter=="cocuk"):
                        $sonuc=$this->model->Ekleme("cocuk_kategori",
                            array("ana_kat_id","ad"),
                            array($anakatid,$katad));
                    elseif ($kriter=="alt"):
                        $sonuc=$this->model->Ekleme("alt_kategori",
                            array("cocuk_kat_id","ana_kat_id","ad"),
                            array($cocukkatid,$anakatid,$katad));
                    endif;







                    if ($sonuc):

                        $this->View->goster("YonPanel/sayfalar/kategoriekle",
                            array(
                                "bilgi" => $this->Bilgi->basarili("EKLEME BAŞARILI","/panel/kategoriler")
                            ));

                    else:

                        $this->View->goster("YonPanel/sayfalar/kategoriekle",
                            array(
                                "bilgi" => $this->Bilgi->hata("EKLEME SIRASINDA HATA OLUŞTU","/panel/kategoriler",1)
                            ));

                    endif;



                endif;


            else:
                $this->Bilgi->direktYonlen("/panel/kategoriler");
            endif;

        endif;



	} //KATEGORİ EKLE

    function kategoriarama(){

        $this->yetkikontrol->YetkisineBak("kategoriYonetim");

        if ($_POST):
            $aramatercih = $this->Form->get("aramatercih")->bosmu();
            $aramaverisi = $this->Form->get("aramaverisi")->bosmu();

            if (!empty($this->form->error)):
                $this->View->goster("YonPanel/sayfalar/kategoriler",
                    array(
                        "bilgi" => $this->Bilgi->hata("BİLGİ GİRİLMELİDİR","/panel/kategoriler",1)
                    ));
            else:

                if ($aramatercih=="ana"):
                    $bilgicek=$this->model->arama("ana_kategori",
                    "ad LIKE '%".$aramaverisi."%'");
                elseif ($aramatercih=="cocuk"):
                    $bilgicek=$this->model->joinislemi(
                        array("ana_kategori.ad As anakatad",
                            "cocuk_kategori.ad As cocukad",
                            "cocuk_kategori.id As cocukid"
                        ),
                        array("ana_kategori",
                            "cocuk_kategori"
                        ),
                        "ana_kategori.id=cocuk_kategori.ana_kat_id AND
                        cocuk_kategori.ad LIKE '%".$aramaverisi."%'"
                    );

                elseif ($aramatercih=="alt"):
                    $bilgicek=$this->model->joinislemi(
                        array("ana_kategori.ad As anakatad",
                            "cocuk_kategori.ad As cocukad",
                            "alt_kategori.ad As altad",
                            "alt_kategori.id As altid"
                        ),
                        array("ana_kategori",
                            "cocuk_kategori",
                            "alt_kategori"
                        ),
                        "(ana_kategori.id=cocuk_kategori.ana_kat_id) AND
                        (cocuk_kategori.id=alt_kategori.cocuk_kat_id) AND
                        alt_kategori.ad LIKE '%".$aramaverisi."%'"
                    );
                endif;

                    if ($bilgicek):
                        $this->View->goster("YonPanel/sayfalar/kategoriler",array(
                            "kategoriaramasonuc"=>$bilgicek,
                            "kelime"=>$aramaverisi,
                            "kategorimiz"=>$aramatercih
                            ));
                    else:
                        $this->View->goster("YonPanel/sayfalar/kategoriler",
                            array(
                                "bilgi" => $this->Bilgi->hata("HİÇBİR KRiTER UYUŞMADI","/panel/kategoriler",2)
                            ));
                    endif;

            endif;

        else:
            $this->Bilgi->direktYonlen("/panel/kategoriler");

        endif;


    } //KATEGORİ ARAMA

    //----------------------------------------------------

    function uyeler($mevcutsayfa=false){

        Router::SayfaYuklemePagi("Uyeler","ADMİN","uyeYonetim","uyeler",
            "uye_panel",$mevcutsayfa,"uyelerGoruntuAdet");



    } //UYELER GELİYOR

    function uyeGuncelle($islem,$id=false) {


        Router::Guncelle(
            [$islem,"ADMİN","uyeYonetim","uyeler","Verial",
                [["Uyeguncelle","uye_panel","where id=".$id]]],
            ["ad","soyad","mail","telefon","durum"],
            ["input1" => "ad","input2" => "soyad","input3" => "mail","input4" => "telefon","select" => "durum"],
            "uyeid",
            "id=",
            "uyeler",
            "uye_panel",
            "UYE GÜNCELLEME BAŞARILI", "UYE GÜNCELLEME SIRASINDA HATA OLUŞTU."
        );


    } // ÜYELER GÜNCELLE

    function uyeSil($id){

        Router::Sil("ADMİN","uyeYonetim","uyeler","uyeler",
            ["uye_panel","id=".$id],
            "UYE SİLME BAŞARILI", "UYE SİLME SIRASINDA HATA OLUŞTU.");

    } //UYE SİL

    function uyearama($kelime=false,$mevcutsayfa=false){

        $this->yetkikontrol->YetkisineBak("uyeYonetim");

        if ($_POST || isset($kelime)):

            if ($_POST):
                $aramaverisi = $this->Form->get("aramaverisi")->bosmu();
                $sorgum = !empty($this->form->error);
            else:
                $aramaverisi = $kelime;
                $sorgum = empty($kelime);


            endif;



            if ($sorgum):
                $this->View->goster("YonPanel/sayfalar/uyeler",
                    array(
                        "bilgi" => $this->Bilgi->hata("KRİTER GİRİLMELİDİR","/panel/uyeler",2)
                    ));
            else:

                    $bilgicek=$this->model->arama("uye_panel",
                        "id LIKE '%".$aramaverisi."%' or 
                        ad LIKE '%".$aramaverisi."%' or 
                        soyad LIKE '%".$aramaverisi. "%' or 
                        telefon LIKE '%".$aramaverisi."%'");

                $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("uyelerAramaAdet"," from ayarlar"));

                    if (count($bilgicek)>0):
                        $this->View->goster("YonPanel/sayfalar/uyeler",array(
                            "data"=>$this->model->arama("uye_panel",
                                "id LIKE '%".$aramaverisi."%' or 
                                    ad LIKE '%".$aramaverisi."%' or 
                                    soyad LIKE '%".$aramaverisi. "%' or 
                                    telefon LIKE '%".$aramaverisi."%'LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
                            "toplamsayfa"=>$this->Pagination->toplamsayfa,
                            "toplamveri"=>count($bilgicek),
                            "arama"=>$aramaverisi
                        ));
                    else:
                        $this->View->goster("YonPanel/sayfalar/uyeler",
                            array(
                                "bilgi" => $this->Bilgi->hata("HİÇBİR KRiTER UYUŞMADI","/panel/uyeler",1)
                            ));
                    endif;

            endif;

        else:
            $this->Bilgi->direktYonlen("/panel/uyeler");
        endif;


    } //UYE ARAMA

    function UyeadresBak($id) {

        Router::SayfaYukleme("ADMİN","uyeYonetim","uyeler","Verial",
            [["UyeadresBak","adresler","where uyeid=".$id]]
        );

    } // ÜYE ADRESLERİ

    function musteriyorumlar($mevcutsayfa=false){



        Router::SayfaYuklemePagi("Uyeler","ADMİN","uyeYonetim","musteriyorumlar",
            "yorumlar",$mevcutsayfa,"uyelerYorumAdet",
            ["urunler.urunad As urunad","yorumlar.*"],
            ["urunler","yorumlar"],
            "yorumlar.urunid=urunler.id order by durum asc LIMIT ");



        /*
        $this->yetkikontrol->YetkisineBak("uyeYonetim");

        $this->Pagination->paginationOlustur($this->model->sayfalama("yorumlar"),$mevcutsayfa,
            $this->model->tekliveri("uyelerYorumAdet"," from ayarlar"));

        $this->View->goster("YonPanel/sayfalar/musteriyorumlar",array(
            "data"=>$this->model->joinislemi(
                array(
                    "urunler.urunad As urunad",
                    "yorumlar.*"
                ),
                array(
                    "urunler",
                    "yorumlar"
                ),
                "yorumlar.urunid=urunler.id order by durum asc LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet
            ),
            "toplamsayfa"=>$this->Pagination->toplamsayfa,
            "toplamveri"=>$this->model->sayfalama("yorumlar")
        ));
        */


    } //UYELERİN YORUMLARI

    //----------------------------------------------------

    function urunler ($mevcutsayfa=false) {
        Router::SayfaYuklemePagi("Urunler","ADMİN","urunYonetim","urunler","urunler",$mevcutsayfa,"urunlerGoruntuAdet");

        /*
        $this->yetkikontrol->YetkisineBak("urunYonetim");

        $this->Pagination->paginationOlustur($this->model->sayfalama("urunler"),$mevcutsayfa,$this->model->tekliveri("urunlerGoruntuAdet"," from ayarlar"));

        $this->View->goster("YonPanel/sayfalar/urunler",array(

            "data" => $this->model->Verial("urunler"," LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
            "toplamsayfa"=>$this->Pagination->toplamsayfa,
            "toplamveri"=>$this->model->sayfalama("urunler"),
            "data2" => $this->model->Verial("ana_kategori",false)

        ));*/

    }  // ÜRÜNLER GELİYOR

    function urunGuncelle($islem,$id=false) {
        $this->yetkikontrol->YetkisineBak("urunYonetim");
        if ($islem=="ilk"):
            Router::SayfaYukleme("ADMİN","urunYonetim","urunler","Verial",
                [["Urunguncelle","urunler","where id=".$id],
                    ["data2","alt_kategori","false"],
                    ["AnakategorilerTumu","ana_kategori","false"],
                    ["CocukkategorilerTumu","cocuk_kategori","false"]]
            );
        else:
            if ($_POST) :

                $ana_kat_id=$this->form->get("ana_kat_id")->bosmu();
                $cocuk_kat_id=$this->form->get("cocuk_kat_id")->bosmu();


                $urunad=$this->Form->get("urunad")->bosmu();
                $katid=$this->Form->get("katid")->bosmu();
                $kumas=$this->Form->get("kumas")->bosmu();
                $uretimyeri=$this->Form->get("uretimyeri")->bosmu();
                $renk=$this->Form->get("renk")->bosmu();
                $fiyat=$this->Form->get("fiyat")->bosmu();
                $stok=$this->Form->get("stok")->bosmu();
                $durum=$this->Form->Selectboxget("durum");
                $urunaciklama=$this->Form->get("urunaciklama")->bosmu();
                $urunozellik=$this->Form->get("urunozellik")->bosmu();
                $urunekstra=$this->Form->get("urunekstra")->bosmu();
                $kayitid=$this->Form->get("kayitid")->bosmu();




                if ($this->Upload->uploadPostAl("res1")) : $this->Upload->UploadDosyaKontrol("res1");	endif;

                if ($this->Upload->uploadPostAl("res2")) : $this->Upload->UploadDosyaKontrol("res2");	endif;

                if ($this->Upload->uploadPostAl("res3")) : $this->Upload->UploadDosyaKontrol("res3");	endif;





                if (!empty($this->form->error)) :

                    $this->View->goster("YonPanel/sayfalar/urunler",
                        array(
                            "bilgi" => $this->Bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/urunler",2)
                        ));

                elseif (!empty($this->Upload->error)) :

                    $this->View->goster("YonPanel/sayfalar/urunler",
                        array(
                            "bilgi" => $this->Upload->error,
                            "yonlen" =>$this->Bilgi->sureliYonlen(3,"/panel/urunler")
                        ));



                else:




                    $sutunlar=array("ana_kat_id","cocuk_kat_id","katid","urunad","durum","aciklama","kumas","urtYeri","renk","fiyat","stok","ozellik","ekstraBilgi");

                    $veriler=array($ana_kat_id,$cocuk_kat_id,$katid,$urunad,$durum,$urunaciklama,$kumas,$uretimyeri,$renk,$fiyat,$stok,$urunozellik,$urunekstra);


                    if ($this->Upload->uploadPostAl("res1")) :
                        $sutunlar[]="res1";
                        $veriler[]=$this->Upload->Yukle("res1",true);
                    endif;

                    if ($this->Upload->uploadPostAl("res2")) :
                        $sutunlar[]="res2";
                        $veriler[]=$this->Upload->Yukle("res2",true);
                    endif;
                    if ($this->Upload->uploadPostAl("res3")) :
                        $sutunlar[]="res3";
                        $veriler[]=$this->Upload->Yukle("res3",true);
                    endif;



                    $sonuc=$this->model->Guncelle("urunler",
                        $sutunlar,
                        $veriler,"id=".$kayitid);




                    if ($sonuc):

                        $this->View->goster("YonPanel/sayfalar/urunler",
                            array(
                                "bilgi" => $this->Bilgi->basarili("ÜRÜN BAŞARIYLA GÜNCELLENDİ","/panel/urunler",2)
                            ));

                    else:

                        $this->View->goster("YonPanel/sayfalar/urunler",
                            array(
                                "bilgi" => $this->Bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU.","/panel/urunler",2)
                            ));

                    endif;



                endif;


            else:
                $this->Bilgi->direktYonlen("/panel/urunler");


            endif;
        endif;

    } // ÜRÜNLER GÜNCELLE

    function urunekle($islem) {

        $this->yetkikontrol->YetkisineBak("urunYonetim");

        if ($islem=="ilk"):
            Router::SayfaYukleme("ADMİN","urunYonetim","urunler","Verial",
                [["Urunekleme","true"],
                    ["data2","alt_kategori","false"]]
            );
        else:
            if ($_POST) :


                $urunad=$this->Form->get("urunad")->bosmu();
                $katid=$this->Form->get("katid")->bosmu();
                $kumas=$this->Form->get("kumas")->bosmu();
                $uretimyeri=$this->Form->get("uretimyeri")->bosmu();
                $renk=$this->Form->get("renk")->bosmu();
                $fiyat=$this->Form->get("fiyat")->bosmu();
                $stok=$this->Form->get("stok")->bosmu();
                $durum=$this->Form->get("durum")->bosmu();
                $urunaciklama=$this->Form->get("urunaciklama")->bosmu();
                $urunozellik=$this->Form->get("urunozellik")->bosmu();
                $urunekstra=$this->Form->get("urunekstra")->bosmu();

                $this->Upload->UploadResimYeniEkleme("res",3);



                if (!empty($this->form->error)) :

                    $this->View->goster("YonPanel/sayfalar/urunler",
                        array(
                            "bilgi" => $this->Bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/urunler",2)
                        ));

                elseif (!empty($this->Upload->error)) :

                    $this->View->goster("YonPanel/sayfalar/urunler",
                        array(
                            "bilgi" => $this->Upload->error
                        ));

                else:


                    $dosyayukleme=$this->Upload->Yukle();

                    $sonuc=$this->model->Ekleme("urunler",
                        array("katid","urunad","res1","res2","res3","durum","aciklama","kumas","urtYeri","renk","fiyat","stok","ozellik","ekstraBilgi"),
                        array($katid,$urunad,$dosyayukleme[0],$dosyayukleme[1],$dosyayukleme[2],$durum,$urunaciklama,$kumas,$uretimyeri,$renk,$fiyat,$stok,$urunozellik,$urunekstra));




                    if ($sonuc):

                        $this->View->goster("YonPanel/sayfalar/urunler",
                            array(
                                "bilgi" => $this->Bilgi->basarili("ÜRÜN BAŞARIYLA EKLENDİ","/panel/urunler",2)
                            ));

                    else:

                        $this->View->goster("YonPanel/sayfalar/urunler",
                            array(
                                "bilgi" => $this->Bilgi->hata("EKLEME SIRASINDA HATA OLUŞTU.","/panel/urunler",2)
                            ));

                    endif;



                endif;


            else:
                $this->Bilgi->direktYonlen("/panel/urunler");


            endif;
        endif;

    }	 // ÜRÜN EKLEME

    function urunSil($id) {
        Router::Sil("ADMİN","urunYonetim","urunler","urunler",
            ["urunler","id=".$id],
            "ÜRÜN SİLME BAŞARILI", "ÜRÜN SİLME SIRASINDA HATA OLUŞTU.");


    }  // ÜRÜNLER SİL

    function katgoregetir($katid=false,$mevcutsayfa=false) {

        $this->yetkikontrol->YetkisineBak("urunYonetim");

        if ($_POST) :

            $katid=$this->Form->get("katid")->bosmu();

            $bilgicek=$this->model->Verial("urunler","where katid=".$katid);

            $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerKategoriAdet"," from ayarlar"));


            if ($bilgicek):

                $this->View->goster("YonPanel/sayfalar/urunler",array(

                    "data" => $this->model->Verial("urunler","where katid=".$katid." LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
                    "toplamsayfa"=>$this->Pagination->toplamsayfa,
                    "toplamveri"=>count($bilgicek),
                    "katid"=>$katid,
                    "data2" => $this->model->Verial("ana_kategori",false)
                ));

            else:

                $this->View->goster("YonPanel/sayfalar/urunler",
                    array(
                        "bilgi" => $this->Bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/urunler",2)
                    ));
            endif;



        elseif(isset($katid)):

            $bilgicek=$this->model->Verial("urunler","where katid=".$katid);

            $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerKategoriAdet"," from ayarlar"));



            $this->View->goster("YonPanel/sayfalar/urunler",array(

                "data" => $this->model->Verial("urunler","where katid=".$katid." LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
                "toplamsayfa"=>$this->Pagination->toplamsayfa,
                "toplamveri"=>count($bilgicek),
                "katid"=>$katid,
                "data2" => $this->model->Verial("alt_kategori",false)
            ));


        else:
            $this->Bilgi->direktYonlen("/panel/urunler");

        endif;





    } // ÜRÜNLERi KATEGORİYE GÖRE GETİR

    function urunarama($kelime=false,$mevcutsayfa=false) {

        $this->yetkikontrol->YetkisineBak("urunYonetim");

        if ($_POST) :

            $aramaverisi=$this->Form->get("arama")->bosmu();

            if (!empty($this->form->error)) :

                $this->View->goster("YonPanel/sayfalar/urunler",
                    array(
                        "bilgi" => $this->Bilgi->hata("KRİTER GİRİLMELİDİR.","/panel/urunler",2)
                    ));


            else:



                $bilgicek=$this->model->arama("urunler",
                    "urunad LIKE '%".$aramaverisi."%' or 
			kumas LIKE '%".$aramaverisi."%'  or 
			urtYeri LIKE '%".$aramaverisi."%' or 
			stok LIKE '%".$aramaverisi."%'");

                $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerAramaAdet"," from ayarlar"));


                if (count($bilgicek)>0):



                    $this->View->goster("YonPanel/sayfalar/urunler",array(
                        "data"=>$this->model->arama("urunler",
                            "urunad LIKE '%".$aramaverisi."%' or 
                            kumas LIKE '%".$aramaverisi."%'  or 
                            urtYeri LIKE '%".$aramaverisi."%' or 
                            stok LIKE '%".$aramaverisi."%'
                            LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
                        "toplamsayfa"=>$this->Pagination->toplamsayfa,
                        "toplamveri"=>count($bilgicek),
                        "arama"=>$aramaverisi,
                        "data2" => $this->model->Verial("ana_kategori",false)
                    ));





                else:

                    $this->View->goster("YonPanel/sayfalar/urunler",
                        array(
                            "bilgi" => $this->Bilgi->hata("HİÇBİR KRİTER UYUŞMADI.","/panel/urunler",2)
                        ));
                endif;


            endif;



        elseif(isset($kelime)):

            $bilgicek=$this->model->arama("urunler",
                "urunad LIKE '%".$kelime."%' or 
			kumas LIKE '%".$kelime."%'  or 
			urtYeri LIKE '%".$kelime."%' or 
			stok LIKE '%".$kelime."%'");

            $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("urunlerAramaAdet"," from ayarlar"));


            $this->View->goster("YonPanel/sayfalar/urunler",array(
                "data"=>$this->model->arama("urunler",
                    "urunad LIKE '%".$kelime."%' or 
                            kumas LIKE '%".$kelime."%'  or 
                            urtYeri LIKE '%".$kelime."%' or 
                            stok LIKE '%".$kelime."%'
                            LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
                "toplamsayfa"=>$this->Pagination->toplamsayfa,
                "toplamveri"=>count($bilgicek),
                "arama"=>$kelime,
                "data2" => $this->model->Verial("ana_kategori",false)
            ));



        else:
            $this->Bilgi->direktYonlen("/panel/urunler");


        endif;





    } // ÜRÜNLER ARAMA

    //----------------------------------------------

    function bulten ($mevcutsayfa=false) {

        Router::SayfaYuklemePagi("Bulten","ADMİN","bultenYonetim","bulten","bulten",$mevcutsayfa,"bultenGoruntuAdet");
        /*
        $this->Pagination->paginationOlustur($this->model->sayfalama("bulten"),$mevcutsayfa,
            $this->model->tekliveri("bultenGoruntuAdet"," from ayarlar"));

        $this->yetkikontrol->YetkisineBak("bultenYonetim");

        $this->View->goster("YonPanel/sayfalar/bulten",array(

            "data"=>$this->model->Verial("bulten"," LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
            "toplamsayfa"=>$this->Pagination->toplamsayfa,
            "toplamveri"=>$this->model->sayfalama("bulten")

        ));*/



    }  // BÜLTEN GELİYOR

    function bultenExcelAl () {

        $this->model->ExcelAyarCek("bulten",false,"bulten");


	    $this->Dosyacikti->Excelaktar("Bulten Mailler",NULL,array("Mail Adres"),$this->model->icerikler);



    }  // BÜLTEN EXCEL ÇIKTI

    function bultenTxtAl () {


	    $this->Dosyacikti->txtolustur($this->model->Verial("bulten",false));



    }  // BÜLTEN TXT ÇIKTI

    function mailSil($id) {
        Router::Sil("ADMİN","bultenYonetim","bulten","bulten",
            ["bulten","id=".$id],
            "MAİL SİLME BAŞARILI", "MAİL SİLME SIRASINDA HATA OLUŞTU.");


    }  // BÜLTEN MAİL SİL

    function mailarama($kelime=false,$mevcutsayfa=false){

        $this->yetkikontrol->YetkisineBak("bultenYonetim");

        if ($_POST || isset($kelime)):

            if ($_POST):
                $aramaverisi = $this->Form->get("arama")->bosmu();
                $sorgum = !empty($this->form->error);
            else:
                $aramaverisi = $kelime;
                $sorgum = empty($kelime);
            endif;


            if ($sorgum):
                $this->View->goster("YonPanel/sayfalar/bulten",
                    array(
                        "bilgi" => $this->Bilgi->hata("MAİL GİRİLMELİDİR","/panel/bulten",2)
                    ));
            else:

                $bilgicek=$this->model->arama("bulten",
                    "mailadres LIKE '%".$aramaverisi."%'");

                $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("bultenGoruntuAdet"," from ayarlar"));



                if (count($bilgicek)>0):
                    $this->View->goster("YonPanel/sayfalar/bulten",array(
                        "data"=>$this->model->arama("bulten",
                            "mailadres LIKE '%".$aramaverisi."%'LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
                        "toplamsayfa"=>$this->Pagination->toplamsayfa,
                        "toplamveri"=>count($bilgicek),
                        "arama"=>$aramaverisi
                    ));

                else:
                    $this->View->goster("YonPanel/sayfalar/bulten",
                        array(
                            "bilgi" => $this->Bilgi->hata("HİÇBİR KRiTER UYUŞMADI","/panel/bulten",1)
                        ));
                endif;




            endif;

        else:
            $this->Bilgi->direktYonlen("/panel/bulten");
        endif;


    } // BÜLTEN MAİL ARAMA

    function tarihegoregetir($tarih1=false,$tarih2=false,$mevcutsayfa=false){

        $this->yetkikontrol->YetkisineBak("bultenYonetim");

        if ($_POST || (isset($tarih1)) and (isset($tarih2))):


            if ($_POST):
                $tar1 = $this->Form->get("tar1")->bosmu();
                $tar2 = $this->Form->get("tar2")->bosmu();
                $sorgum = !empty($this->form->error);
            else:
                $tar1 = $tarih1;
                $tar2 = $tarih2;
                $sorgum = empty($tarih1) && empty($tarih2);
            endif;


            if ($sorgum):
                $this->View->goster("YonPanel/sayfalar/bulten",
                    array(
                        "bilgi" => $this->Bilgi->hata("TARİHLER GİRİLMELİDİR","/panel/bulten",2)
                    ));
            else:


                $bilgicek=$this->model->Verial("bulten",
                    "where DATE(tarih) BETWEEN '".$tar1."' and '".$tar2."'");

                $this->Pagination->paginationOlustur(count($bilgicek),$mevcutsayfa,$this->model->tekliveri("bultenGoruntuAdet"," from ayarlar"));

                if (count($bilgicek)>0):
                    $this->View->goster("YonPanel/sayfalar/bulten",array(
                        "data"=>$this->model->Verial("bulten",
                            "where DATE(tarih) BETWEEN '".$tar1."' and '".$tar2."' 
                            LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
                        "toplamsayfa"=>$this->Pagination->toplamsayfa,
                        "toplamveri"=>count($bilgicek),
                        "tariharama"=>true,
                        "tarih1"=>$tar1,
                        "tarih2"=>$tar2
                    ));





                else:
                    $this->View->goster("YonPanel/sayfalar/bulten",
                        array(
                            "bilgi" => $this->Bilgi->hata("HİÇBİR KRiTER UYUŞMADI","/panel/bulten",1)
                        ));
                endif;




            endif;

        else:
            $this->Bilgi->direktYonlen("/panel/bulten");
        endif;


    } // BÜLTEN TARİHE GÖRE ARAMA

    function mailislemleri () {

        Router::SayfaYukleme("ADMİN","bultenYonetim","mailislemleri","Verial",
            [["gruplar","pazarlama_mail_gruplar","false"],
            ["sablonlar","pazarlama_mail_sablonlar","false"]]
        );
    }

    function mailgonderme () {

        if ($_POST) :

            $mailler=$this->Form->get("mailadresleri")->bosmu();
            $metin=$this->Form->get("metin")->bosmu();
            $baslik=$this->Form->get("baslik")->bosmu();

            $dizi=explode("\r",$mailler);
            /*
            Önce gelen mailleri bölüyorum.
            Tanımsız olan boşluk içeren dizi değerini kaybediyorum
            Kullanılabilir değer haline getiriyorum
            */
            if (count($dizi)>1) :

                if (in_array(null,$dizi) || in_array('',array_map('trim',$dizi))):
                    array_pop($dizi);
                endif;

            endif;



            $this->Mailislem->mailgonder($dizi,$baslik,$metin);

            $this->yetkikontrol->YetkisineBak("bultenYonetim");


            $this->View->goster("YonPanel/sayfalar/mailislemleri",array(
                "Bilgi" => $this->Bilgi->basarili("Mailler Başarıyla gönderildi","/panel/mailislemleri",2)
            ));

        else:
            $this->Bilgi->direktYonlen("/panel/mailislemleri");
        endif;


    }

    function slideryonetimi() {
        Router::SayfaYukleme("ADMİN","yoneticiYonetim","slider","Verial",
            [["sliderVerileri","slider","false"]]
        );

    } // SLİDER YONETİMİ

    function SliderBabaFonksiyon($islem,$id=false) {
        $this->yetkikontrol->YetkisineBak("yoneticiYonetim");

        switch ($islem) :

            case "silme":

                if (isset($id)) :
                    $sonuc=$this->model->Sil("slider","id=".$id);
                    if ($sonuc):
                        $this->View->goster("YonPanel/sayfalar/slider",
                            array(
                                "Bilgi" => $this->Bilgi->basarili("SİLME BAŞARILI","/panel/slideryonetimi",2)
                            ));
                    else:
                        $this->View->goster("YonPanel/sayfalar/slider",
                            array(
                                "Bilgi" => $this->Bilgi->hata("SİLME SIRASINDA HATA OLUŞTU","/panel/slideryonetimi",2)
                            ));
                    endif;

                else:

                    $this->View->goster("YonPanel/sayfalar/slideryonetimi",
                        array(
                            "Bilgi" => $this->Bilgi->hata("İD BİLGİSİ VERİLMELİDİR","/panel/slideryonetimi",2)
                        ));

                endif;

                break;

            case "guncellemeilk":

                if (isset($id)) :

                    $this->View->goster("YonPanel/sayfalar/slider",array(
                        "sliderGuncelle" => $this->model->Verial("slider","where id=".$id)
                    ));
                else:

                    $this->View->goster("YonPanel/sayfalar/slideryonetimi",
                        array(
                            "Bilgi" => $this->Bilgi->hata("İD BİLGİSİ VERİLMELİDİR","/panel/slideryonetimi",2)
                        ));

                endif;

                break;

            case "guncellemeson":

                if ($_POST) :

                    $sloganAlt=$this->Form->get("sloganAlt")->bosmu();
                    $sloganUst=$this->Form->get("sloganUst")->bosmu();
                    $sliderid=$this->Form->get("sliderid")->bosmu();

                    if ($this->Upload->uploadPostAl("resim")) : $this->Upload->UploadDosyaKontrol("resim");	endif;



                    if (!empty($this->Form->error)) :

                        $this->View->goster("YonPanel/sayfalar/slider",
                            array(
                                "Bilgi" => $this->Bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/slideryonetimi",2)
                            ));

                    elseif (!empty($this->Upload->error)) :
                        $this->View->goster("YonPanel/sayfalar/slider",
                            array(
                                "Bilgi" => $this->Upload->error,
                                "yonlen" =>$this->Bilgi->sureliYonlen(3,"/panel/slideryonetimi")
                            ));

                    else:
                        $sutunlar=array("sloganAlt","sloganUst");
                        $veriler=array($sloganAlt,$sloganUst);

                        if ($this->Upload->uploadPostAl("resim")) :
                            $sutunlar[]="resim";
                            $veriler[]=$this->Upload->Yukle("resim",true,"slider");
                        endif;


                        $sonuc=$this->model->Guncelle("slider",$sutunlar,$veriler,"id=".$sliderid);
                        if ($sonuc):
                            $this->View->goster("YonPanel/sayfalar/slider",
                                array(
                                    "Bilgi" => $this->Bilgi->basarili("SLİDER BAŞARIYLA GÜNCELLENDİ","/panel/slideryonetimi",2)
                                ));
                        else:
                            $this->View->goster("YonPanel/sayfalar/slider",
                                array(
                                    "Bilgi" => $this->Bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU","/panel/slideryonetimi",2)
                                ));
                        endif;

                    endif;

                else:
                    $this->Bilgi->direktYonlen("/panel/slideryonetimi");

                endif;

                break;

            case "eklemeilk":

                $this->View->goster("YonPanel/sayfalar/slider",
                    array("sliderEkleme" => true));

                break;

            case "eklemeSon":

                if ($_POST) :

                    $sloganAlt=$this->Form->get("sloganAlt")->bosmu();
                    $sloganUst=$this->Form->get("sloganUst")->bosmu();

                    if ($this->Upload->uploadPostAl("resim")) : $this->Upload->UploadDosyaKontrol("resim");	endif;

                    if (!empty($this->Form->error)) :

                        $this->View->goster("YonPanel/sayfalar/slider",
                            array(
                                "Bilgi" => $this->Bilgi->hata("Tüm alanlar doldurulmalıdır","/panel/slideryonetimi",2)
                            ));

                    elseif (!empty($this->Upload->error)) :

                        $this->View->goster("YonPanel/sayfalar/slider",
                            array(
                                "Bilgi" => $this->Upload->error
                            ));

                    else:

                        $sutunlar=array("sloganAlt","sloganUst");
                        $veriler=array($sloganAlt,$sloganUst);

                        if ($this->Upload->uploadPostAl("resim")) :
                            $sutunlar[]="resim";
                            $veriler[]=$this->Upload->Yukle("resim",true,"slider");
                        endif;


                        $sonuc=$this->model->Ekleme("slider",$sutunlar,$veriler);



                        if ($sonuc):

                            $this->View->goster("YonPanel/sayfalar/slider",
                                array(
                                    "Bilgi" => $this->Bilgi->basarili("SLİDER BAŞARIYLA EKLENDİ","/panel/slideryonetimi",2)
                                ));

                        else:

                            $this->View->goster("YonPanel/sayfalar/slider",
                                array(
                                    "Bilgi" => $this->Bilgi->hata("EKLEME SIRASINDA HATA OLUŞTU","/panel/slideryonetimi",2)
                                ));

                        endif;

                    endif;

                else:
                    $this->Bilgi->direktYonlen("/panel/slideryonetimi");

                endif;

                break;

        endswitch;

    }

    function renkyonetimi() {
        /*Router::SayfaYukleme("ADMİN","yoneticiYonetim","renkyonetimi","Verial",[
            ["renkdegistir","renkyonetimi","false"]	]);*/

        $this->yetkikontrol->YetkisineBak("yoneticiYonetim");
        Router::SayfaYukleme("ADMİN","yoneticiYonetim","renkyonetimi","Verial",[
            ["renkdegistir","renkyonetimi","false"]	]);


    } // RENK YÖNETİMİ


    function renkyonetimison() {

        $this->yetkikontrol->YetkisineBak("yoneticiYonetim");

        if ($_POST) :
            $header=$this->Form->get("header")->bosmu();
            $sepet=$this->Form->get("sepet")->bosmu();
            $kategoriic=$this->Form->get("kategoriic")->bosmu();
            $sepeteeklebuton=$this->Form->get("sepeteeklebuton")->bosmu();



            if (!empty($this->Form->error)) :
                $this->View->goster("YonPanel/sayfalar/renkyonetimi",
                    array(
                        "bilgi" => $this->Bilgi->hata("Renkler Boş Olamaz","/panel/renkyonetimi",1)
                    ));
            else:

                $sonuc=$this->model->Guncelle("renkyonetimi",
                    array("header","sepet","kategoriic","sepeteeklebuton"),	array($header,$sepet,$kategoriic,$sepeteeklebuton),"id=1");

                if ($sonuc):

                    $this->View->goster("YonPanel/sayfalar/renkyonetimi",
                        array(
                            "bilgi" => $this->Bilgi->basarili("Renkler Güncellendi","/panel/renkyonetimi",1)
                        ));

                else:

                    $this->View->goster("YonPanel/sayfalar/renkyonetimi",
                        array(
                            "bilgi" => $this->Bilgi->hata("Güncelleme sırasında hata oluştu","/panel/renkyonetimi",1)

                        ));

                endif;

            endif;


        else:
            $this->Bilgi->direktYonlen("/");
        endif;


    }  // RENK YÖNETİMİ GÜNCELLİYOR.

    //----------------------------------------------

    function sistemayar () {

        Router::SayfaYukleme("ADMİN","sistemayarYonetim","sistemayar","Verial",[
            ["sistemayar","ayarlar","false"]
        ]);

    }  // SİSTEM AYARLARI GELİYOR

    function ayarguncelle() {

        /*
        Router::Guncelle(null,
            ["title","sayfaAciklama","anahtarKelime","uyelerGoruntuAdet","uyelerAramaAdet","urunlerGoruntuAdet","urunlerAramaAdet","urunlerKategoriAdet","ArayuzUrunlerGoruntuAdet","uyeYorumAdet","bultenGoruntuAdet"],
            [
                "input13" =>"sayfatitle",
                "input14" =>"sayfaaciklama",
                "input15" =>"anahtarkelime",
                "input16" =>"uyeSayfaGorAdet",
                "input17" =>"uyeAramaAdet",
                "input18" =>"urunlerSayfaGorAdet",
                "input19" =>"urunlerAramaAdet",
                "input20" =>"urunlerKategoriAdet",
                "input21" =>"SiteUrunlerAdet",
                "input22" =>"uyeYorumAdet",
                "input23" =>"bultenGoruntuAdet"],
            "kayitid",
            "id=",
            "sistemayar",
            "ayarlar",
            ["AYARLAR GÜNCELLENDİ"],
            ["AYAR GÜNCELLEME SIRASINDA HATA OLUŞTU."],"ADMİN");
            */

        $this->yetkikontrol->YetkisineBak("sistemayarYonetim");

        if ($_POST) :



            $sayfatitle=$this->Form->get("sayfatitle")->bosmu();
            $sayfaaciklama=$this->Form->get("sayfaaciklama")->bosmu();
            $anahtarkelime=$this->Form->get("anahtarkelime")->bosmu();



            $uyeSayfaGorAdet=$this->Form->get("uyeSayfaGorAdet")->bosmu();
            $uyeAramaAdet=$this->Form->get("uyeAramaAdet")->bosmu();
            $urunlerSayfaGorAdet=$this->Form->get("urunlerSayfaGorAdet")->bosmu();
            $urunlerAramaAdet=$this->Form->get("urunlerAramaAdet")->bosmu();
            $urunlerKategoriAdet=$this->Form->get("urunlerKategoriAdet")->bosmu();
            $SiteUrunlerAdet=$this->Form->get("SiteUrunlerAdet")->bosmu();
            $uyeYorumAdet=$this->Form->get("uyeYorumAdet")->bosmu();
            $bultenGoruntuAdet=$this->Form->get("bultenGoruntuAdet")->bosmu();

            $kayitid=$this->Form->get("kayitid")->bosmu();


            if (!empty($this->form->error)) :

                $this->View->goster("YonPanel/sayfalar/sistemayar",
                    array(
                        "bilgi" => $this->Bilgi->hata("Tüm alanlar doldurulmalıdır.","/panel/sistemayar",2)
                    ));


            else:

                $sonuc=$this->model->Guncelle("ayarlar",
                    array("title","sayfaAciklama","anahtarKelime","uyelerGoruntuAdet","uyelerAramaAdet","urunlerGoruntuAdet","urunlerAramaAdet","urunlerKategoriAdet","ArayuzUrunlerGoruntuAdet","uyeYorumAdet","bultenGoruntuAdet"),
                    array($sayfatitle,$sayfaaciklama,$anahtarkelime,$uyeSayfaGorAdet,$uyeAramaAdet,$urunlerSayfaGorAdet,$urunlerAramaAdet,$urunlerKategoriAdet,$SiteUrunlerAdet,$uyeYorumAdet,$bultenGoruntuAdet),"id=".$kayitid);


                if ($sonuc):

                    $this->View->goster("YonPanel/sayfalar/sistemayar",
                        array(
                            "bilgi" => $this->Bilgi->basarili("SİSTEM AYARLARI BAŞARIYLA GÜNCELLENDİ.","/panel/sistemayar",2)
                        ));

                else:

                    $this->View->goster("YonPanel/sayfalar/sistemayar",
                        array(
                            "bilgi" => $this->Bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU.","/panel/sistemayar",2)
                        ));

                endif;



            endif;


        else:
            $this->Bilgi->direktYonlen("/panel/sistemayar");


        endif;






    }	 // SİSTEM AYARLARI GÜNCELLEME

    //----------------------------------------------

    function sistembakim () {

        Router::SayfaYukleme("ADMİN","sistembakimYonetim","bakim",false,
            [["sistembakim","true"]]);

    }  // SİSTEM BAKIM

    function bakimyap () {

        $this->yetkikontrol->YetkisineBak("sistembakimYonetim");

	    if ($_POST["sistembtn"]):

	    $bakim=$this->model->bakim(DB_NAME);

            if ($bakim):

                $this->View->goster("YonPanel/sayfalar/bakim",
                    array(
                        "bilgi" => $this->Bilgi->basarili("SİSTEM BAKIMI BAŞARIYLA YAPILDI.","/panel/sistembakim",2)
                    ));

            else:

                $this->View->goster("YonPanel/sayfalar/bakim",
                    array(
                        "bilgi" => $this->Bilgi->hata("BAKIM SIRASINDA HATA OLUŞTU.","/panel/sistembakim",2)
                    ));

            endif;
            else:
            $this->Bilgi->direktYonlen("/panel/sistembakim");
            endif;

    }  // SİSTEM BAKIM SONUÇ

    function veritabaniyedek () {

        Router::SayfaYukleme("ADMİN","sistembakimYonetim","yedek",false,
            [["veritabaniyedek","true"]]);


    }  // VERİTABANI YEDEK

    function dbyedekal($deger){
        $this->Dosyacikti->veritabaniyedekindir($deger);

    }

    function yedekal () {

        $this->yetkikontrol->YetkisineBak("sistembakimYonetim");

	    if ($_POST["sistembtn"]):

	    $yedek=$this->model->yedek(DB_NAME);

	    $yedektercih=$this->Form->radiobutonget("yedektercih");

        if ($yedek[0]):

            if ($yedektercih=="host"):

                $olustur=fopen(YEDEKYOL.date("d.m.Y").".sql","w+");
                fwrite($olustur,$yedek[1]);
                fclose($olustur);

                $this->View->goster("YonPanel/sayfalar/yedek",
                    array(
                        "bilgi" => $this->Bilgi->basarili("YEDEKLEME BAŞARIYLA YAPILDI.","/panel/veritabaniyedek",2)
                    ));


            else:

                $this->dbyedekal($yedek[1]);

            endif;



        else:

            $this->View->goster("YonPanel/sayfalar/yedek",
                array(
                    "bilgi" => $this->Bilgi->hata("YEDEKLEME SIRASINDA HATA OLUŞTU.","/panel/veritabaniyedek",2)
                ));
        endif;


        else:
        $this->Bilgi->direktYonlen("/panel/veritabaniyedek");
        endif;

    }  // VERİTABANI YEDEK SONUÇ

    //----------------------------------------------


    function cikis() {

        Session::destroy();
        $this->Bilgi->direktYonlen("/panel/giris");

    } // ÇIKIŞ

    function sifredegistir() {

        Router::SayfaYukleme("ADMİN",false,"sifreislemleri",false,
            [["sifredegistir",Session::get("Adminid")]]);


    } // ŞİFRE DEĞİŞTİRME FORMU

    function sifreguncelleSon() {

        if ($_POST) :

            $mevcutsifre=$this->Form->get("mevcutsifre")->bosmu();
            $yen1=$this->Form->get("yen1")->bosmu();
            $yen2=$this->Form->get("yen2")->bosmu();
            $yonid=$this->Form->get("yonid")->bosmu();

            $sifre=$this->Form->SifreTekrar($yen1,$yen2); // ŞİFRELİ YENİ HALİ ALIYORUM
            /*
            ÖNCE GELEN ŞFİREYİ SORGULAMAM LAZIM DOĞRUMU DİYE, EĞER MEVCUT ŞİFRE DOĞRU İSE
            DEVAM EDECEK HATALI İSE İŞLEM BİTECEK

            */

            $mevcutsifre=$this->Form->sifrele($mevcutsifre);

            if (!empty($this->form->error)) :
                $this->View->goster("YonPanel/sayfalar/sifreislemleri",
                    array(
                        "sifredegistir" => Session::get("Adminid"),
                        "bilgi" => $this->Bilgi->uyari("danger","Girilen bilgiler hatalıdır.")
                    ));

            else:



                $sonuc2=$this->model->GirisKontrol("yonetim","ad='".Session::get("AdminAd")."' and sifre='$mevcutsifre'");

                if ($sonuc2):

                    $sonuc=$this->model->Guncelle("yonetim",
                        array("sifre"),
                        array($sifre),"id=".$yonid);

                    if ($sonuc):


                        $this->View->goster("YonPanel/sayfalar/sifreislemleri",
                            array(
                                "bilgi" => $this->Bilgi->basarili("ŞİFRE DEĞİŞTİRME BAŞARILI","/panel/siparisler")
                            ));


                    else:

                        $this->View->goster("YonPanel/sayfalar/sifreislemleri",
                            array(
                                "sifredegistir" => Session::get("Adminid"),
                                "bilgi" => $this->Bilgi->uyari("danger","Şifre değiştirme sırasında hata oluştu.")
                            ));

                    endif;

                else:





                    $this->View->goster("YonPanel/sayfalar/sifreislemleri",
                        array(
                            "sifredegistir" => Session::get("Adminid"),
                            "bilgi" => $this->Bilgi->uyari("danger","Mevcut şifre hatalıdır.")
                        ));



                endif;

            endif;


        else:

            $this->Bilgi->direktYonlen("/");
        endif;



    } // YÖNETİCİ ŞİFRESİNİ GÜNCELLİYOR.

    //----------------------------------------------

    function yonetici () {

        Router::SayfaYukleme("ADMİN","yoneticiYonetim","yonetici","Verial",
            [["data","yonetim","false"]]
        );

    }  // YÖNETİCİLER GELİYOR

    function yonSil($id) {
        Router::Sil("ADMİN","yoneticiYonetim","yonetim","yonetim",
            ["yonetim","id=".$id],
            "YÖNETİCİ SİLME BAŞARILI", "YÖNETİCİ SİLME SIRASINDA HATA OLUŞTU.");

    }  // YÖNETİCİ SİL

    function yonekle($islem) {

        $this->yetkikontrol->YetkisineBak("yoneticiYonetim");

        if ($islem=="ilk"):

        $this->view->goster("YonPanel/sayfalar/yonetici",array(
            "yoneticiekle" => true
        ));

        elseif ($islem=="son"):

            if ($_POST) :

                $yonadi=$this->Form->get("yonadi")->bosmu();
                $sif1=$this->Form->get("sif1")->bosmu();
                $sif2=$this->Form->get("sif2")->bosmu();
                $sifre=$this->Form->SifreTekrar($sif1,$sif2);


                $siparisYonetim=$this->Form->Checkboxget("siparisYonetim");
                $kategoriYonetim=$this->Form->Checkboxget("kategoriYonetim");
                $uyeYonetim=$this->Form->Checkboxget("uyeYonetim");
                $urunYonetim=$this->Form->Checkboxget("urunYonetim");
                $muhasebeYonetim=$this->Form->Checkboxget("muhasebeYonetim");
                $yoneticiYonetim=$this->Form->Checkboxget("yoneticiYonetim");
                $bultenYonetim=$this->Form->Checkboxget("bultenYonetim");
                $sistemayarYonetim=$this->Form->Checkboxget("sistemayarYonetim");
                $sistembakimYonetim=$this->Form->Checkboxget("sistembakimYonetim");
                $yetki=$this->Form->Selectboxget("yetki");




                if (!empty($this->form->error)) :
                    $this->View->goster("YonPanel/sayfalar/yonetici",
                        array(
                            "bilgi" => $this->Bilgi->hata("Girilen bilgiler hatalıdır.","/panel/yonetici")
                        ));

                else:


                    $sonuc=$this->model->Ekleme("yonetim",
                        array("ad","sifre","yetki","siparisYonetim","kategoriYonetim","uyeYonetim","urunYonetim","muhasebeYonetim","yoneticiYonetim","bultenYonetim","sistemayarYonetim","sistembakimYonetim"),
                        array($yonadi,$sifre,$yetki,$siparisYonetim,$kategoriYonetim,$uyeYonetim,$urunYonetim,$muhasebeYonetim,$yoneticiYonetim,$bultenYonetim,$sistemayarYonetim,$sistembakimYonetim));

                    if ($sonuc):


                        $this->View->goster("YonPanel/sayfalar/yonetici",
                            array(
                                "bilgi" => $this->Bilgi->basarili("Yeni yönetici eklendi","/panel/yonetici")
                            ));



                    else:

                        $this->View->goster("YonPanel/sayfalar/yonetici",
                            array(
                                "bilgi" => $this->Bilgi->hata("Ekleme sırasında hata oluştu","/panel/yonetici")
                            ));



                    endif;

                endif;


            else:

                $this->Bilgi->direktYonlen("/");
            endif;


        endif;


    }	 // YÖNETİCİ EKLEME

    function yonguncelle($islem,$yonid=false) {

        Router::Guncelle(
            [$islem,"ADMİN","yoneticiYonetim","yonetici","Verial",
                [["YoneticiGuncelle","yonetim","where id=".$yonid]]
            ],	["ad","yetki","siparisYonetim","kategoriYonetim","uyeYonetim","urunYonetim","muhasebeYonetim","yoneticiYonetim","bultenYonetim","sistemayarYonetim","sistembakimYonetim"],
            [
                "input1" =>"yonadi",
                "select1" => "yetki",
                "check1" =>"siparisYonetim",
                "check2" =>"kategoriYonetim",
                "check3" =>"uyeYonetim",
                "check4" =>"urunYonetim",
                "check5" =>"muhasebeYonetim",
                "check6" =>"yoneticiYonetim",
                "check7" =>"bultenYonetim",
                "check8" =>"sistemayarYonetim",
                "check9" =>"sistembakimYonetim"],
            "yonid",
            "id=",
            "yonetici",
            "yonetim",
            "YÖNETİCİ GÜNCELLEME BAŞARILI", "YÖNETİCİ GÜNCELLEME SIRASINDA HATA OLUŞTU."
        );

        /*
        $this->yetkikontrol->YetkisineBak("yoneticiYonetim");

        if ($islem=="ilk"):


            $this->View->goster("YonPanel/sayfalar/yonetici",array(
                "YoneticiGuncelle" => $this->model->Verial("yonetim","where id=".$yonid)
            ));


        elseif ($islem=="son"):

            if ($_POST) :

                $yonadi=$this->Form->get("yonadi")->bosmu();

                $siparisYonetim=$this->Form->Checkboxget("siparisYonetim");
                $kategoriYonetim=$this->Form->Checkboxget("kategoriYonetim");
                $uyeYonetim=$this->Form->Checkboxget("uyeYonetim");
                $urunYonetim=$this->Form->Checkboxget("urunYonetim");
                $muhasebeYonetim=$this->Form->Checkboxget("muhasebeYonetim");
                $yoneticiYonetim=$this->Form->Checkboxget("yoneticiYonetim");
                $bultenYonetim=$this->Form->Checkboxget("bultenYonetim");
                $sistemayarYonetim=$this->Form->Checkboxget("sistemayarYonetim");
                $sistembakimYonetim=$this->Form->Checkboxget("sistembakimYonetim");
                $yetki=$this->Form->Selectboxget("yetki");
                $yoneticiId=$this->Form->get("yonid")->bosmu();




                if (!empty($this->form->error)) :
                    $this->View->goster("YonPanel/sayfalar/yonetici",
                        array(
                            "bilgi" => $this->Bilgi->hata("Girilen bilgiler hatalıdır.","/panel/yonetici")
                        ));

                else:


                    $sonuc=$this->model->Guncelle("yonetim",
                        array("ad","yetki","siparisYonetim","kategoriYonetim","uyeYonetim","urunYonetim","muhasebeYonetim","yoneticiYonetim","bultenYonetim","sistemayarYonetim","sistembakimYonetim"),
                        array($yonadi,$yetki,$siparisYonetim,$kategoriYonetim,$uyeYonetim,$urunYonetim,$muhasebeYonetim,$yoneticiYonetim,$bultenYonetim,$sistemayarYonetim,$sistembakimYonetim),
                        "id=".$yoneticiId);

                    if ($sonuc):


                        $this->View->goster("YonPanel/sayfalar/yonetici",
                            array(
                                "bilgi" => $this->Bilgi->basarili("Yönetici Güncelleme Başarılı","/panel/yonetici")
                            ));



                    else:

                        $this->View->goster("YonPanel/sayfalar/yonetici",
                            array(
                                "bilgi" => $this->Bilgi->hata("Güncelleme sırasında hata oluştu","/panel/yonetici")
                            ));



                    endif;

                endif;


            else:

                $this->Bilgi->direktYonlen("/");
            endif;


        endif;
        */

    }	 // YÖNETİCİ GÜNCELLE

    //----------------------------------------------

    function bankabilgileri(){

        Router::SayfaYukleme("ADMİN","muhasebeYonetim","bankabilgileri","Verial",
            [["data","bankabilgileri","false"]]
        );
    } // BANKA BİLGİLERİ GELİYOR

    //çift kontrol ( bankaGuncelle, bankaguncelleSon ) yerine tek kontrol ( bankaGuncelle ) kullanıldı.
    function bankaGuncelle($islem,$id=false) {

        Router::Guncelle(
            [$islem,"ADMİN","muhasebeYonetim","bankabilgileri","Verial",
                [["BankaGuncelle","bankabilgileri","where id=".$id]]],
            ["banka_ad","hesap_ad","hesap_no","iban_no"],
            ["input1" =>"banka_ad",
                "input2" => "hesap_ad",
                "input3" =>"hesap_no",
                "input4" =>"iban_no"],
            "bankaid",
            "id=",
            "bankabilgileri",
            "bankabilgileri",
            "BANKA BİLGİLERİNİ GÜNCELLEME BAŞARILI","BANKA BİLGİLERİNİ GÜNCELLEME SIRASINDA HATA OLUŞTU."
        );

        /*
        $this->yetkikontrol->YetkisineBak("muhasebeYonetim");

        if ($islem=="ilk"):

            $this->View->goster("YonPanel/sayfalar/bankabilgileri",array(
                "bankaGuncelle" => $this->model->Verial("bankabilgileri","where id=".$id)
            ));
        elseif ($islem=="son"):

            if($_POST):
                $banka_ad=$this->Form->get("banka_ad")->bosmu();
                $hesap_ad=$this->Form->get("hesap_ad")->bosmu();
                $hesap_no=$this->Form->get("hesap_no")->bosmu();
                $iban_no=$this->Form->get("iban_no")->bosmu();
                $bankaid=$this->Form->get("bankaid")->bosmu();


                if (!empty($this->form->error)):
                    $this->View->goster("YonPanel/sayfalar/bankabilgileri",
                        array(
                            "bilgi" => $this->Bilgi->hata("TÜM ALANLAR DOLDURULMALIDIR.","/panel/bankabilgileri",2)
                        ));

                else:

                    $sonuc=$this->model->Guncelle("bankabilgileri",
                        array("banka_ad","hesap_ad","hesap_no","iban_no"),
                        array($banka_ad,$hesap_ad,$hesap_no,$iban_no),"id=".$bankaid);

                    if ($sonuc):

                        $this->View->goster("YonPanel/sayfalar/bankabilgileri",
                            array(
                                "bilgi" => $this->Bilgi->basarili("HESAP GÜNCELLEME BAŞARILI","/panel/bankabilgileri",2)
                            ));

                    else:

                        $this->View->goster("YonPanel/sayfalar/bankabilgileri",
                            array(
                                "bilgi" => $this->Bilgi->hata("GÜNCELLEME SIRASINDA HATA OLUŞTU","/panel/bankabilgileri",2)
                            ));

                    endif;



                endif;


            else:
                $this->Bilgi->direktYonlen("/panel/bankabilgileri");
            endif;

        endif;
        */




    } // BANKA BİLGİLERİ GÜNCELLE

    function bankaSil($id){
        Router::Sil("ADMİN","muhasebeYonetim","bankabilgileri","bankabilgileri",
            ["bankabilgileri","id=".$id],
            "BANKA SİLME BAŞARILI", "BANKA SİLME SIRASINDA HATA OLUŞTU.");


    } // BANKA BİLGİLERİ SİL

    function bankaEkle($islem,$id=false) {



        Router::Ekle(
            [$islem,"ADMİN","muhasebeYonetim","bankabilgileri",false,
                [["bankaEkle","true"]]],
            ["banka_ad","hesap_ad","hesap_no","iban_no"],
            ["input1" =>"banka_ad",
                "input2" => "hesap_ad",
                "input3" =>"hesap_no",
                "input4" =>"iban_no"],
            "bankabilgileri",
            "bankabilgileri",
            "BANKA BİLGİLERİNİ EKLEME BAŞARILI","BANKA BİLGİLERİNİ EKLEME SIRASINDA HATA OLUŞTU."
        );


    } // BANKA BİLGİsi EKLE

    function muhaseberapor() {
        $this->yetkikontrol->YetkisineBak("siparisYonetim");

        if ($_POST) :



            $odemeturu=$this->Form->get("odemeturu",true);
            $durum=$this->Form->get("durum",true);
            $tarih1=$this->Form->get("tarih1",true);
            $tarih2=$this->Form->get("tarih2",true);



            if (!empty($this->Form->error)) :
                $this->View->goster("YonPanel/sayfalar/muhaseberapor",
                    array(
                        "Bilgi" => $this->Bilgi->hata("Boş alan olmamalıdır","/panel/muhaseberapor",1)
                    ));
            else:
                $this->aramadegeri.="<strong>Ödeme Türü :</strong> ".$odemeturu;
                switch ($durum):
                    case "0";
                        $this->aramadegeri.="<strong> Sipariş Durumu :</strong> İşlemde";
                        break;
                    case "1";
                        $this->aramadegeri.="<strong> Sipariş Durumu :</strong> Tamamlanmış";
                        break;
                    case "2";
                        $this->aramadegeri.="<strong> Sipariş Durumu :</strong> İade";
                        break;
                    case "3";
                        $this->aramadegeri.="<strong> Sipariş Durumu :</strong> İade Onaylanmış";
                        break;
                endswitch;
                $this->aramadegeri.="<strong> Başlangıç Tarihi :</strong> ".$tarih1;
                $this->aramadegeri.="<strong> Bitiş Tarihi :</strong> ".$tarih2;




                $sorgumuz=$this->model->arama("siparisler",
                    "odemeturu LIKE '%".$odemeturu."%' and
			durum LIKE '%".$durum."%'  and	DATE(tarih) BETWEEN  '".$tarih1."' and '".$tarih2."'");

                if ($sorgumuz) :
                    $this->View->goster("YonPanel/sayfalar/muhaseberapor",array(
                        "data" => $sorgumuz,
                        "aramakriter" => $this->aramadegeri
                    ));

                else:

                    $this->View->goster("YonPanel/sayfalar/muhaseberapor",array(
                        "Hata" => true
                    ));

                endif;



            endif;



        else:
            $this->View->goster("YonPanel/sayfalar/muhaseberapor",array(
                "varsayilan" => true
            ));
        endif;
    } // MUHASEBE RAPOR ARAMA

    function muhasebeExcelAl () {

        $this->yetkikontrol->YetkisineBak("siparisYonetim");

        $idler=Session::get("idler");
        $this->model->ExcelAyarCek2("urunad,urunadet,urunfiyat,toplamfiyat,odemeturu from siparisler where id IN(".$idler.")");

        $this->Dosyacikti->Excelaktar("MUHASEBE RAPORLAR",NULL,
            array(
                "Ürün ad",
                "Ürün adet",
                "Ürün fiyat",
                "Toplam Fiyat",
                "Ödeme Türü"
            ),$this->model->icerikler[0]);

    } // SİPARİŞ EXCEL ÇIKTI

}




?>