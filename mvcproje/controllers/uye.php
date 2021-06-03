<?php

class uye extends Controller  {
	
	
	function __construct() {

        Session::init();
        parent::KutuphaneYukle(array("View","Form","Bilgi","Pagination","Captcha","Mailislem","Token"));

	    $this->Modelyukle('uye');

	}	
	

	
	function giris() {

	$this->View->goster("sayfalar/giris",
        array("captcha"=>$this->Captcha->kaynak,
            "token"=>$this->Token->kodolustur()));
		
	} // GİRİŞ SAYFASI
	
	function hesapOlustur() {
	$this->View->goster("sayfalar/uyeol",
        array("captcha"=>$this->Captcha->kaynak,
            "token"=>$this->Token->kodolustur()));
		
	} // HESAP OLUŞTUR SAYFASI
	
	function kayitkontrol() {
	
	if ($_POST) :		
	$ad=$this->Form->get("ad")->bosmu();
	$soyad=$this->Form->get("soyad")->bosmu();
	$mail=$this->Form->get("mail")->bosmu();
	$sifre=$this->Form->get("sifre")->bosmu();
	$sifretekrar=$this->Form->get("sifretekrar")->bosmu();
	$telefon=$this->Form->get("telefon")->bosmu();
	$guvenlik=$this->Form->get("guvenlik")->bosmu();
    $token=$this->Form->get("token")->bosmu();
    $this->Form->GercektenMailmi($mail);
	$sifre=$this->Form->SifreTekrar($sifre,$sifretekrar);
	

	
	if (!empty($this->Form->error)) :


    elseif ($guvenlik!=Session::get("kod")) :

        $this->View->goster("sayfalar/uyeol",
	array(
        "bilgi" =>$this->Bilgi->hata("Güvenlik kodu hatalıdır","/uye/hesapolustur",1)));

    elseif ($token!=Session::get("token")) :
        $this->View->goster("sayfalar/uyeol",
            array(
                "bilgi" =>$this->Bilgi->hata("Yetkisiz kontrol hatası var.","/uye/uyeol",1)));

	else:
	
	$sonuc=$this->model->Ekleİslemi("uye_panel",
	array("ad","soyad","mail","sifre","telefon"),
	array($ad,$soyad,$mail,$sifre,$telefon));
	
		if ($sonuc):
	
	
		$this->View->goster("sayfalar/uyeol",
		array("bilgi" =>$this->Bilgi->basarili("KAYIT BAŞARILI","/uye/giris",1)));
		
		
		
		else:
		
		$this->View->goster("sayfalar/uyeol",
		array("bilgi" => 
		$this->Bilgi->uyari("danger","Kayıt esnasında hata oluştu")));
		
		
		
		
		endif;
	
	endif;
		
		else:	
	
	$this->Bilgi->direktYonlen("/");
	endif;
	
	
		
	} 	// KAYIT KONTROL		
	
	function cikis() {
			
			Session::destroy();			
			$this->Bilgi->direktYonlen("/magaza");
		
	} // ÇIKIŞ	
	
	function giriskontrol() {
	if ($_POST) :		

        if ($_POST["giristipi"]=="uye"):

        $ad=$this->Form->get("ad")->bosmu();
        $sifre=$this->Form->get("sifre")->bosmu();
        $token=$this->Form->get("token")->bosmu();
        $guvenlik=$this->Form->get("guvenlik")->bosmu();


            if (!empty($this->form->error)) :
                $this->View->goster("sayfalar/giris",
                array("bilgi" => $this->Bilgi->uyari("danger","Ad ve şifre boş olamaz")));
            elseif ($guvenlik!=Session::get("kod")) :
                $this->View->goster("sayfalar/giris",
                             array(
                                 "bilgi" =>$this->Bilgi->hata("Güvenlik kodu hatalıdır","/uye/giris",1)));
            elseif ($token!=Session::get("token")) :
                $this->View->goster("sayfalar/giris",
                            array(
                                "bilgi" =>$this->Bilgi->hata("Yetkisiz kontrol hatası var.","/uye/giris",3)));
            else:
            $sifre=$this->Form->sifrele($sifre);
            $sonuc=$this->model->GirisKontrol("uye_panel","ad='$ad' and sifre='$sifre' and durum=1");
	
            if ($sonuc):


                $this->Bilgi->direktYonlen("/uye/panel");

                Session::init();
                Session::set("kulad",$sonuc[0]["ad"]);
                Session::set("uye",$sonuc[0]["id"]); // üyenin id'si taşıyacagım
                                        // 10 skfjsmfj5754154hfdsf
                                    //$this->form->sifrele($sifre);

            else:

                $this->View->goster("sayfalar/giris",
                array("bilgi" => $this->Bilgi->hata("Kullanıcı adı veya şifresi hatalıdır","/uye/giris",1)));

            endif;

        endif; //hatanın

                elseif ($_POST["giristipi"]=="yon"):


                    $AdminAd=$this->Form->get("AdminAd")->bosmu();
                    $Adminsifre=$this->Form->get("Adminsifre")->bosmu();


                    if (!empty($this->form->error)) :
                        $this->View->goster("YonPanel/sayfalar/index",
                            array("bilgi" => $this->Bilgi->uyari("danger","Ad ve şifre boş olamaz")));


                    else:
                        $Adminsifre=$this->Form->sifrele($Adminsifre);
                        $sonuc=$this->model->GirisKontrol("yonetim","ad='$AdminAd' and sifre='$Adminsifre'");

                        if ($sonuc):


                            $this->Bilgi->direktYonlen("/panel/siparisler");

                            Session::init();
                            Session::set("AdminAd",$sonuc[0]["ad"]);
                            Session::set("Adminid",$sonuc[0]["id"]); // yöneticinin id'si taşıcam
                        // 10 skfjsmfj5754154hfdsf
                        //$this->form->sifrele($sifre);

                        else:

                            $this->View->goster("YonPanel/sayfalar/index",
                                array("bilgi" =>
                                    $this->Bilgi->uyari("danger","Kullanıcı adı veya şifresi hatalıdır")));

                        endif;

                    endif; //hatanın


            endif;
            else:

        $this->Bilgi->direktYonlen("/");
        endif;
	
	
	
		
	} // GİRİŞ KONTROL
	
	//*********** ÜYENİN PANELİNİ SAĞLAYAN FONKSİYONLAR


    function sifresifirlama($kriter=false,$kodumuz=false) {

        if ($kriter=="son"):

            if ($_POST) :

                $mailadres=$this->Form->get("mailadres")->bosmu();

                if (!empty($this->Form->error)) :
                    $this->View->goster("sayfalar/sifremiunuttum",
                        array("Bilgi" => $this->Bilgi->hata("Mail Adresi boş olmamalıdır.","/uye/sifresifirlama")));

                else:

                    $sonuc=$this->model->VerileriAl("uye_panel","where mail='$mailadres'");


                    if (count($sonuc)>0):
                        // kod üretebilirim
                        $kodumuz=substr(sha1(mt_rand(1,99999)),4,9);
                        Session::set("kod",$kodumuz);
                        Session::set("uyemailadres",$mailadres);

                        $linkicerik='<html>
				<head><title>Üyelik Aktivasyon</title></head>
					<body>
				Linke tıklayarak şifrenizi sıfırlayabiliriz.<br><b>Doğrulama Link :</b><hr>
				
<a href="'.URL.'/uye/sifresifirlama/dogrulama/'.$kodumuz.'">ŞİFREYİ SIFIRLA</a>
				</body>							
		</html>';




                        $this->Mailislem->mailgonder(array($mailadres),"Üyelik Aktivasyon",$linkicerik,true);

                        $this->View->goster("sayfalar/sifremiunuttum",
                            array("kodgirme"=>true,
                                "Bilgi" => $this->Bilgi->uyari("success","Mail adresinize kod gönderildi")));
                    else:
                        $this->View->goster("sayfalar/sifremiunuttum",
                            array("Bilgi" => $this->Bilgi->hata("Böyle bir kayıt yok","/uye/sifresifirlama")));
                    endif;

                endif;

            else:

                $this->Bilgi->direktYonlen("/");

            endif;

        elseif ($kriter=="dogrulama"):

            if (Session::get("denemehakki")):

                if (Session::get("denemehakki")==3):
                    Session::destroy();
                    $this->Bilgi->direktYonlen("/");
                else:
                    Session::set("denemehakki",Session::get("denemehakki")+1);
                    $this->View->goster("sayfalar/sifremiunuttum",
                        array("koddurum"=>true));
                endif;




            else:

                if ($kodumuz):

                    // BURADA LİNK İLE GELEN KOD KARŞILAŞTIRILIYOR

                    if (Session::get("kod")==$kodumuz):
                        $this->View->goster("sayfalar/sifremiunuttum",
                            array("koddurum"=>true));
                    else:
                        $this->View->goster("sayfalar/sifremiunuttum",
                            array("Bilgi" => $this->Bilgi->hata("Kod Hatalı","/uye/sifresifirlama/son")));
                    endif;

                else:


                    if ($_POST) :

                        $kod=$this->Form->get("kod")->bosmu();

                        if (!empty($this->Form->error)) :
                            $this->View->goster("sayfalar/sifremiunuttum",
                                array("Bilgi" => $this->Bilgi->hata("Kod boş olmamalıdır.","/uye/sifresifirlama/son")));

                        else:

                            if (Session::get("kod")==$kod):
                                $this->View->goster("sayfalar/sifremiunuttum",
                                    array("koddurum"=>true));
                            else:
                                $this->View->goster("sayfalar/sifremiunuttum",
                                    array("Bilgi" => $this->Bilgi->hata("Kod Hatalı","/uye/sifresifirlama/son")));
                            endif;

                        endif;

                    else:

                        $this->Bilgi->direktYonlen("/");

                    endif;


                endif;

            endif; // şifre uyumsuzluk halinde tekrar gelinince hata olmaması için

        elseif ($kriter=="sifredegistir"):

            if ($_POST) :

                $sifre1=$this->Form->get("sifre1")->bosmu();
                $sifre2=$this->Form->get("sifre2")->bosmu();
                $sonsifre=$this->Form->SifreTekrar($sifre1,$sifre2);

                if (!empty($this->Form->error)) :
                    $this->View->goster("sayfalar/sifremiunuttum",
                        array("koddurum"=>true,
                            "Bilgi" => $this->Bilgi->hata("Şifreler Uyumsuz.","/uye/sifresifirlama/dogrulama")));

                else:

                    $sifirlamamailadres=Session::get("uyemailadres");

                    $sonuc=$this->model->Guncelleİslemi("uye_panel",
                        array("sifre"),
                        array($sonsifre),"mail='$sifirlamamailadres'");

                    if ($sonuc):
                        Session::destroy();

                        $this->View->goster("sayfalar/sifremiunuttum",
                            array("koddurum"=>true,
                                "Bilgi" => $this->Bilgi->basarili("ŞİFRE SIFIRLAMA BAŞARILI","/uye/giris")));
                    else:
                        $this->View->goster("sayfalar/sifremiunuttum",
                            array("Bilgi" => $this->Bilgi->hata("Güncelleme sırasında hata oluştu.","/uye/sifremiunuttum")));
                    endif;



                endif;

            else:

                $this->Bilgi->direktYonlen("/");

            endif;

        else:


            $this->View->goster("sayfalar/sifremiunuttum");

        endif;



    } // ŞİFREMİ UNUTTUM

    function Yorumsil () {
		
		if ($_POST) :	
		
		echo $this->model->Silmeİslemi("yorumlar", "id=".$_POST["yorumid"]);
		
		endif;
		
	} // YORUM SİL
	
	function adresSil () {
		
		if ($_POST) :	
		
		echo $this->model->Silmeİslemi("adresler", "id=".$_POST["adresid"]);
		
		endif;
		
	} // ADRES SİL
	
	function YorumGuncelle()  {
		
		if ($_POST) :
		
		echo $this->model->Guncelleİslemi("yorumlar",
		array("icerik","durum"),
		array($_POST["yorum"],"0"),"id=".$_POST["yorumid"]);
		
		endif;
		
		
	} // YORUM GÜNCELLE
	
	function AdresGuncelle()  {
		
		if ($_POST) :
		
		echo $this->model->Guncelleİslemi("adresler",
		array("adres"),
		array($_POST["adres"]),"id=".$_POST["adresid"]);
		
		endif;
		
		
	} // ADRES GÜNCELLE	
	
	
	function Panel() {	
	
	$this->View->goster("sayfalar/panel",array(
	"siparisler" => $this->model->VerileriAl("siparisler","where uyeid=".Session::get("uye"))));
		
	} // ANA PANEL
	
	function yorumlarim($mevcutsayfa=false) {

        $veriler=$this->model->VerileriAl("yorumlar","where uyeid=".Session::get("uye"));


        $this->Pagination->paginationOlustur(count($veriler),$mevcutsayfa,$this->model->tekliveri("uyeYorumAdet"," from ayarlar"));

        $this->View->goster("sayfalar/panel",array(
	    "yorumlar" => $this->model->VerileriAl("yorumlar","where uyeid=".Session::get("uye").
        " LIMIT ".$this->Pagination->limit.",".$this->Pagination->gosterilecekadet),
        "toplamsayfa"=>$this->Pagination->toplamsayfa,
        "toplamveri"=>count($veriler)
	));		
	
		
	} // YORUMLAR
	
	function adreslerim() {	

	$this->View->goster("sayfalar/panel",array(
	"adres" => $this->model->VerileriAl("adresler","where uyeid=".Session::get("uye"))
	));		

	} // ADRESLER

	function adresekle() {

	$this->View->goster("sayfalar/panel",array(
	"adresekle" => "ekleme"
	));

	} // ADRES EKLE

    function adresEkleSon() {
        if ($_POST) :

            $yeniadres=$this->Form->get("yeniadres")->bosmu();
            $uyeid=$this->Form->get("uyeid")->bosmu();

            if (!empty($this->form->error)) :
                $this->View->goster("sayfalar/panel",
                    array(
                        "adresekle" => "ekleme",
                        "bilgi" => $this->Bilgi->hata("Adres boş olmamalıdır.","/uye/adresekle",2)
                    ));

            else:

                $sonuc=$this->model->Ekleİslemi("adresler",
                    array("uyeid","adres"),
                    array($uyeid,$yeniadres));

                if ($sonuc):

                    $this->View->goster("sayfalar/panel",
                        array(
                            "adresekle" => "tamam",
                            "bilgi" => $this->Bilgi->basarili("EKLEME BAŞARILI","/uye/adreslerim")
                        ));

                else:

                    $this->View->goster("sayfalar/panel",
                        array(
                            "adresekle" => "ekleme",
                            "bilgi" => $this->Bilgi->hata("Kayıt sırasında hata oluştu.","/uye/adresekle",2)
                        ));

                endif;

            endif;


        else:

            $this->Bilgi->direktYonlen("/");
        endif;

    } // ADRES EKLİYOR.

	function hesapayarlarim() {	

	$this->View->goster("sayfalar/panel",array(
	"ayarlar" => $this->model->VerileriAl("uye_panel","where id=".Session::get("uye"))));

	} // HESAP AYARLARI
	
	function sifredegistir() {	

	$this->View->goster("sayfalar/panel",array(
	"sifredegistir" => Session::get("uye")));	

	} // ŞİFRE DEĞİŞTİR
	
	function siparislerim() {	
	
	$this->View->goster("sayfalar/panel",array(
	"siparisler" => $this->model->VerileriAl("siparisler","where uyeid=".Session::get("uye"))));

	} // SİPARİŞLER
	
	function ayarGuncelle() {		
		if ($_POST) :	
		
	$ad=$this->Form->get("ad")->bosmu();
	$soyad=$this->Form->get("soyad")->bosmu();
	$mail=$this->Form->get("mail")->bosmu();
	$telefon=$this->Form->get("telefon")->bosmu();
	$uyeid=$this->Form->get("uyeid")->bosmu();

	if (!empty($this->form->error)) :
	$this->View->goster("sayfalar/panel",
	array(
	"ayarlar" => $this->model->VerileriAl("uye_panel","where id=".Session::get("uye")),
	"bilgi" => $this->Bilgi->uyari("danger","Girilen bilgiler hatalıdır.")
	 ));
	 	
	else:	

		$sonuc=$this->model->Guncelleİslemi("uye_panel",
		array("ad","soyad","mail","telefon"),
		array($ad,$soyad,$mail,$telefon),"id=".$uyeid);
	
		if ($sonuc): 
	
			$this->View->goster("sayfalar/panel",
			array(
			"ayarlar" => "ok",
			"bilgi" => $this->Bilgi->basarili("GÜNCELLEME BAŞARILI","/uye/panel")
			 ));
				
		else:
		
			$this->view->goster("sayfalar/panel",
			array(
			"ayarlar" => $this->model->VerileriAl("uye_panel","where id=".Session::get("uye")),
			"bilgi" => $this->Bilgi->uyari("danger","Güncelleme sırasında hata oluştu.")
			 ));	
		
		endif;
	
	endif;
	
		else:	
	
	$this->Bilgi->direktYonlen("/");
	endif;

	} // ÜYE KENDİ AYARLARINI GÜNCELLİYOR.
	
	function sifreguncelle() {		

	if ($_POST) :		
		
	 $msifre=$this->Form->get("msifre")->bosmu();
	 $yen1=$this->Form->get("yen1")->bosmu();
	 $yen2=$this->Form->get("yen2")->bosmu();
	 $uyeid=$this->Form->get("uyeid")->bosmu();
	 $sifre=$this->Form->SifreTekrar($yen1,$yen2); // ŞİFRELİ YENİ HALİ ALIYORUM
	/*
	ÖNCE GELEN ŞFİREYİ SORGULAMAM LAZIM DOĞRUMU DİYE, EĞER MEVCUT ŞİFRE DOĞRU İSE	
	DEVAM EDECEK HATALI İSE İŞLEM BİTECEK
	*/
	
	$msifre=$this->Form->sifrele($msifre);
	
	if (!empty($this->form->error)) :
	$this->View->goster("sayfalar/panel",
	array(
	"sifredegistir" => Session::get("uye"),
	"bilgi" => $this->Bilgi->uyari("danger","Girilen bilgiler hatalıdır.")
	 ));
	
	else:
		
	$sonuc2=$this->model->GirisKontrol("uye_panel","ad='".Session::get("kulad")."' and sifre='$msifre'");
	
		if ($sonuc2): 
		
				$sonuc=$this->model->Guncelleİslemi("uye_panel",
				array("sifre"),
				array($sifre),"id=".$uyeid);
			
				if ($sonuc): 
				
			
				$this->View->goster("sayfalar/panel",
				array(
				"sifredegistir" => "ok",
				"bilgi" => $this->Bilgi->basarili("ŞİFRE DEĞİŞTİRME BAŞARILI","/uye/panel")
			 	));
					
						
				else:
				
				$this->View->goster("sayfalar/panel",
				array(
				"sifredegistir" => Session::get("uye"),
				"bilgi" => $this->Bilgi->uyari("danger","Şifre değiştirme sırasında hata oluştu.")
				));	
				
				endif;
			
		else:
		
			$this->View->goster("sayfalar/panel",
	array(
	"sifredegistir" => Session::get("uye"),
	"bilgi" => $this->Bilgi->uyari("danger","Mevcut şifre hatalıdır.")
	 ));

		endif;
	
	endif;
	
	else:	
	
	$this->Bilgi->direktYonlen("/");
	endif;
	

	} // ÜYE ŞİFRESİNİ GÜNCELLİYOR.
	
	
	//***********  ÜYENİN PANELİNİ SAĞLAYAN FONKSİYONLAR
		
	
	function siparisTamamlandi() {
		
		if ($_POST) :		

	$ad=$this->Form->get("ad")->bosmu();
	$soyad=$this->Form->get("soyad")->bosmu();
	$mail=$this->Form->get("mail")->bosmu();
	$telefon=$this->Form->get("telefon")->bosmu();
	$toplam=$this->Form->get("toplam")->bosmu();
		
	$odeme=$this->Form->get("odeme")->bosmu();
	$adrestercih=$this->Form->get("adrestercih")->bosmu();
	$odemeturu=($odeme==1) ? "Nakit" : "Hata";
	$durum=0;
	$tarih=date("d.m.Y");

	if (!empty($this->form->error)) :
	$this->View->goster("sayfalar/siparistamamla",
	array("bilgi" => $this->Bilgi->uyari("danger","Bilgiler eksiksiz doldurulmalıdır")));

	else:
	
	$siparisNo=mt_rand(0,99999999);
	$uyeid=Session::get("uye");
	
	$this->model->TopluislemBaslat();

		if (isset($_COOKIE["urun"])) :

		foreach ($_COOKIE["urun"] as $id => $adet) :
		
$GelenUrun=$this->model->VerileriAl("urunler","where id=".$id);


	$birimfiyat=$GelenUrun[0]["fiyat"]*$adet;
	
	$this->model->SiparisTamamlama(
	array(
	$siparisNo,
	$adrestercih,
	$uyeid,
	$GelenUrun[0]["urunad"],
	$adet,
	$GelenUrun[0]["fiyat"],
	$birimfiyat,
	$odemeturu,
    $durum,
	$tarih
	));

	    echo $this->model->Guncelleİslemi("urunler",
        array("stok"),
        array($GelenUrun[0]["stok"]-$adet),"id=".$GelenUrun[0]["id"]);

        endforeach;
	
	
	else:
	 // cookie  tanımlı değilse diye bir knotrol
		$this->Bilgi->direktYonlen("/");
	
	endif;
	
	
	$this->model->TopluislemTamamla();
	
		
	Cookie::SepetiBosalt(); // sepeti boşalttık
		
		
	$TeslimatBilgileri=$this->model->Ekleİslemi("teslimatbilgileri",
	array("siparis_no","ad","soyad","mail","telefon"),
	array(
	$siparisNo,
	$ad,
	$soyad,
	$mail,
	$telefon	
	));
	
		if ($TeslimatBilgileri):


		$this->View->goster("sayfalar/siparistamamlandi",
		array(
		"siparisno" => $siparisNo,
		"toplamtutar" => $toplam,
        "bankalar"=>$this->model->VerileriAl("bankabilgileri",false)
		));	

		else:
		
		$this->View->goster("sayfalar/siparisitamamla",
		array("bilgi" => $this->Bilgi->uyari("danger","Sipariş oluşturulurken hata oluştu")));
		
		endif;
	
	endif;

	else:	
	
	$this->Bilgi->direktYonlen("/");
	endif;
	

	} // SİPARİŞ TAMAMLANDI
	

}




?>