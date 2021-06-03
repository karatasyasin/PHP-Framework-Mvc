<?php

class Router extends Controller {

    public static $yetkikontrol,$View,$Form,$Bilgi,$Pagination;

    public static $model;

    public static function init()  {

        //klasik yöntem (Router olmadan)
        //parent::KutuphaneYukle(array("View","Form","Bilgi","Upload","Pagination","Dosyacikti","Mailislem"));
        //$this->Modelyukle('adminpanel');


        self::$View=new View();
        self::$Bilgi=new Bilgi();
        self::$Form=new Form();
        self::$Pagination=new Pagination();
        self::$model=parent::RouterModelyukle('routerpanel');


        if (Session::get("AdminAd") && Session::get("Adminid")) :
            self::$yetkikontrol=new PanelHariciFonksiyonlar();
        endif;

    }  //KURUCU METOD

    public static function SayfaYukleme($bolum,$yetkituru=false,$gidilecekDosyaYolu,$ModelFonksiyonAdi=false,
                                        array $sorgu=null){

        switch ($bolum):
            case "ADMİN":
                $gidilecekDosyaYolu=ADMİNDOSYAYOLU.$gidilecekDosyaYolu;
                break;
            case "ARAYUZ":
                $gidilecekDosyaYolu=ARAYUZDOSYAYOLU.$gidilecekDosyaYolu;
                break;
        endswitch;

        $kullanat=array();

        for ($i=0;$i<count($sorgu);$i++):

            // gelen temel yapı eleman kontrolü
            if(count($sorgu[$i])<3)  :

                //formata özel db işlemleri
                if ($ModelFonksiyonAdi && $ModelFonksiyonAdi=="SpesifikVerial"):

                    $kullanat[$sorgu[$i][0]]=self::$model->$ModelFonksiyonAdi($sorgu[$i][1]);

                else:

                    $kullanat[$sorgu[$i][0]]=$sorgu[$i][1];

                endif;


            else:

                $kullanat[$sorgu[$i][0]]=self::$model->$ModelFonksiyonAdi($sorgu[$i][1],($sorgu[$i][2] == "false" ) ? false : $sorgu[$i][2]);

            endif;


        endfor;


        self::$yetkikontrol->YetkisineBak($yetkituru);

        self::$View->goster($gidilecekDosyaYolu,$kullanat);



    }

    public static function Sil($bolum, $yetkituru, $gidilecekDosyaYolu, $gidilecekUrl, array $sorgu,
                               $OlumluBilgiVerileri=false, $OlumsuzBilgiVerileri=false) {


        switch ( $bolum ):

            case "ADMİN":
                $gidilecekDosyaYolu = ADMİNDOSYAYOLU . $gidilecekDosyaYolu;
                break;

            case "ARAYUZ":
                $gidilecekDosyaYolu = ARAYUZDOSYAYOLU . $gidilecekDosyaYolu;
                break;

        endswitch;



        self::$yetkikontrol->YetkisineBak( $yetkituru );



        if (self::$model->Sil($sorgu[0],$sorgu[1])):
            /*
            self::$View->goster($gidilecekDosyaYolu,
                ["Bilgi" =>[
                    "adres" => URL."/panel/".$gidilecekUrl,
                    "durum" => $OlumsuzBilgiVerileri[0],
                    "metin" => $OlumsuzBilgiVerileri[1]
                ]	] );

            self::SayfaYukleme("ADMİN","kategoriYonetim","kategoriler","kategoriler",
                [["bilgi",self::$Bilgi->basarili($OlumluBilgiVerileri,"/panel/".$gidilecekUrl,3)]]
            );*/


            self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->basarili($OlumluBilgiVerileri,"/panel/".$gidilecekUrl,3)));



        else:
             /*
            self::SayfaYukleme($gidilecekDosyaYolu,
                [["bilgi",self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)]]
            );*/

            self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)));

        endif;





    }

    public static function SayfaYuklemePagi($islemTipi, $bolum, $yetkituru = false, $gidilecekDosyaYolu, $islemTabloAdi,
                                            $mevcutSayfa=false, $AyarAdimiz, array $istenilensutunlar=null,
                                            array $tabloadlari=null, $kosul=null) {


        switch ( $bolum ):

            case "ADMİN":
                $gidilecekDosyaYolu = ADMİNDOSYAYOLU . $gidilecekDosyaYolu;
                break;

            case "ARAYUZ":
                $gidilecekDosyaYolu = ARAYUZDOSYAYOLU . $gidilecekDosyaYolu;
                break;

        endswitch;



        self::$yetkikontrol->YetkisineBak( $yetkituru );

        switch($islemTipi) :

            case "Uyeler":
                self::$Pagination->paginationOlustur(self::$model->sayfalama($islemTabloAdi),$mevcutSayfa,
                    self::$model->tekliveri($AyarAdimiz," from ayarlar"));

                self::$View->goster( $gidilecekDosyaYolu, array(
                    "data" => self::$model->Verial($islemTabloAdi," LIMIT ".self::$Pagination->limit.",".self::$Pagination->gosterilecekadet),
                    "toplamsayfa" =>self::$Pagination->toplamsayfa,
                    "toplamveri" => self::$model->sayfalama($islemTabloAdi)
                ) );

                break;
            case "Urunler":

                self::$Pagination->paginationOlustur(self::$model->sayfalama($islemTabloAdi),$mevcutSayfa,
                    self::$model->tekliveri($AyarAdimiz," from ayarlar"));

                self::$View->goster($gidilecekDosyaYolu,array(
                    "data" => self::$model->Verial($islemTabloAdi," LIMIT ".self::$Pagination->limit.",".self::$Pagination->gosterilecekadet),
                    "toplamsayfa" => self::$Pagination->toplamsayfa,
                    "toplamveri" => self::$model->sayfalama($islemTabloAdi),
                    "data2" => self::$model->Verial("ana_kategori",false)
                ));
                break;

            case "Bulten":
                self::$Pagination->paginationOlustur(self::$model->sayfalama($islemTabloAdi),$mevcutSayfa,
                    self::$model->tekliveri($AyarAdimiz," from ayarlar"));
                self::$View->goster($gidilecekDosyaYolu,array(
                    "data" => self::$model->Verial($islemTabloAdi," LIMIT ".self::$Pagination->limit.",".self::$Pagination->gosterilecekadet),
                    "toplamsayfa" => self::$Pagination->toplamsayfa,
                    "toplamveri" => self::$model->sayfalama($islemTabloAdi)
                ));
                break;


        endswitch;




    }

    public static function Guncelle(array $TeknikVeriler=null, array $SutunAdlari, array $FormVerileri, $kriterVerisi,
                                    $Kosul, $gidilecekUrl, $Tabload, $OlumluBilgiVerileri,
                                    $OlumsuzBilgiVerileri, $bolum=false) {


        if (isset($TeknikVeriler[1])) :

            switch ( $TeknikVeriler[1] ):

                case "ADMİN":
                    $gidilecekDosyaYolu = ADMİNDOSYAYOLU . $TeknikVeriler[3];
                    break;

                case "ARAYUZ":
                    $gidilecekDosyaYolu = ARAYUZDOSYAYOLU . $TeknikVeriler[3];
                    break;

            endswitch;
        else:

            switch ( $bolum ):

                case "ADMİN":
                    $gidilecekDosyaYolu = ADMİNDOSYAYOLU . $gidilecekUrl;
                    break;

                case "ARAYUZ":
                    $gidilecekDosyaYolu = ARAYUZDOSYAYOLU . $gidilecekUrl;


                    break;

            endswitch;

        endif;

        if($TeknikVeriler[0]=="ilk"):
            self::SayfaYukleme($TeknikVeriler[1],$TeknikVeriler[2],$TeknikVeriler[3],$TeknikVeriler[4],$TeknikVeriler[5]);

        else:

            if ($_POST) :
                $SutunVerileri=array();

                foreach ($FormVerileri as $anahtar => $deger):

                            if(strstr($anahtar,"input")) :
                                $SutunVerileri[]=self::$Form->get($deger)->bosmu();
                            elseif (strstr($anahtar,"select")):
                                $SutunVerileri[]=self::$Form->Selectboxget($deger);
                            elseif (strstr($anahtar,"check")):
                                $SutunVerileri[]=self::$Form->Checkboxget($deger);
                            elseif (strstr($anahtar,"radio")):
                                $SutunVerileri[]=self::$Form->radiobutonget($deger);
                            endif;

                endforeach;


                $kriterVerisi=self::$Form->get($kriterVerisi)->bosmu();

                $TamKosul=$Kosul.$kriterVerisi;

                /*
                echo $TamKosul."<br>";
                echo "<pre>";
                print_r($SutunAdlari);
                echo "</pre>";
                echo "<pre>";
                print_r($SutunVerileri);
                echo "</pre>";
                echo $kriterVerisi."<br>";
                */

                if (!empty(self::$Form->error)) :

                    /*
                    self::SayfaYukleme("ADMİN","kategoriYonetim","kategoriler","kategoriler",
                        [["bilgi",self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)]]
                    );*/

                    self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)));

                else:

                    if (self::$model->Guncelle($Tabload,$SutunAdlari,$SutunVerileri,$TamKosul)):

                        /*
                        self::SayfaYukleme("ADMİN","kategoriYonetim","kategoriler","kategoriler",
                            [["bilgi",self::$Bilgi->basarili($OlumluBilgiVerileri,"/panel/".$gidilecekUrl,3)]]
                        );*/


                        self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->basarili($OlumluBilgiVerileri,"/panel/".$gidilecekUrl,3)));


                    else:
                        /*
                        self::SayfaYukleme("ADMİN","kategoriYonetim","kategoriler","kategoriler",
                            [["bilgi",self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)]]
                        );*/
                        self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)));


                    endif;
                endif;

            else:

                self::$Bilgi->direktYonlen(URL."/panel/".$gidilecekUrl);

            endif;


        endif;



    }

    public static function KategoriGuncelle(array $TeknikVeriler=null, array $FormVerileri, $kriterVerisi, $Kosul,
                                            $gidilecekUrl, $OlumluBilgiVerileri, $OlumsuzBilgiVerileri) {


        if (isset($TeknikVeriler[1])) :

            switch ( $TeknikVeriler[1] ):

                case "ADMİN":
                    $gidilecekDosyaYolu = ADMİNDOSYAYOLU . $TeknikVeriler[3];
                    break;

                case "ARAYUZ":
                    $gidilecekDosyaYolu = ARAYUZDOSYAYOLU . $TeknikVeriler[3];
                    break;

            endswitch;
        else:

            switch ( $bolum ):

                case "ADMİN":
                    $gidilecekDosyaYolu = ADMİNDOSYAYOLU . $gidilecekUrl;
                    break;

                case "ARAYUZ":
                    $gidilecekDosyaYolu = ARAYUZDOSYAYOLU . $gidilecekUrl;


                    break;

            endswitch;

        endif;

        if($TeknikVeriler[0]=="ilk"):
            self::SayfaYukleme($TeknikVeriler[1],$TeknikVeriler[2],$TeknikVeriler[3],$TeknikVeriler[4],$TeknikVeriler[5]);

        else:

            if ($_POST) :
                $SutunVerileri=array();

                foreach ($FormVerileri as $anahtar => $deger):

                            if(strstr($anahtar,"input")) :
                                $SutunVerileri[]=self::$Form->get($deger)->bosmu();
                            elseif (strstr($anahtar,"select")):
                                $SutunVerileri[]=self::$Form->Selectboxget($deger);
                            elseif (strstr($anahtar,"check")):
                                $SutunVerileri[]=self::$Form->Checkboxget($deger);
                            elseif (strstr($anahtar,"radio")):
                                $SutunVerileri[]=self::$Form->radiobutonget($deger);
                            endif;

                endforeach;


                $kriterVerisi=self::$Form->get($kriterVerisi)->bosmu();

                $TamKosul=$Kosul.$kriterVerisi;

                if (!empty(self::$Form->error)) :

                    self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)));

                else:


                    if ($SutunVerileri[0]=="ana"):

                        $sonuc=self::$model->Guncelle("ana_kategori",
                            array("ad"),
                            array($SutunVerileri[1]),$TamKosul);

                    elseif ($SutunVerileri[0]=="cocuk"):
                        $sonuc=self::$model->Guncelle("cocuk_kategori",
                            array("ana_kat_id","ad"),
                            array($SutunVerileri[2],$SutunVerileri[1]),$TamKosul);
                    elseif ($SutunVerileri[0]=="alt"):
                        $sonuc=self::$model->Guncelle("alt_kategori",
                            array("cocuk_kat_id","ana_kat_id","ad"),
                            array($SutunVerileri[3],$SutunVerileri[2],$SutunVerileri[1]),$TamKosul);
                    endif;


                    if ($sonuc):

                        self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->basarili($OlumluBilgiVerileri,"/panel/".$gidilecekUrl,3)));


                    else:
                        self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)));


                    endif;
                endif;

            else:

                self::$Bilgi->direktYonlen(URL."/panel/".$gidilecekUrl);

            endif;


        endif;



    }

    public static function Ekle(array $TeknikVeriler=null, array $SutunAdlari, array $FormVerileri, $gidilecekUrl,
                                $Tabload, $OlumluBilgiVerileri, $OlumsuzBilgiVerileri, $bolum=false) {


        if (isset($TeknikVeriler[1])) :

            switch ( $TeknikVeriler[1] ):

                case "ADMİN":
                    $gidilecekDosyaYolu = ADMİNDOSYAYOLU . $TeknikVeriler[3];
                    break;

                case "ARAYUZ":
                    $gidilecekDosyaYolu = ARAYUZDOSYAYOLU . $TeknikVeriler[3];
                    break;

            endswitch;
        else:

            switch ( $bolum ):

                case "ADMİN":
                    $gidilecekDosyaYolu = ADMİNDOSYAYOLU . $gidilecekUrl;
                    break;

                case "ARAYUZ":
                    $gidilecekDosyaYolu = ARAYUZDOSYAYOLU . $gidilecekUrl;


                    break;

            endswitch;

        endif;

        if($TeknikVeriler[0]=="ilk"):
            self::SayfaYukleme($TeknikVeriler[1],$TeknikVeriler[2],$TeknikVeriler[3],$TeknikVeriler[4],$TeknikVeriler[5]);

        else:

            if ($_POST) :
                $SutunVerileri=array();

                foreach ($FormVerileri as $anahtar => $deger):


                    if(strstr($anahtar,"input")) :
                        $SutunVerileri[]=self::$Form->get($deger)->bosmu();
                    elseif (strstr($anahtar,"select")):
                        $SutunVerileri[]=self::$Form->Selectboxget($deger);
                    elseif (strstr($anahtar,"check")):
                        $SutunVerileri[]=self::$Form->Checkboxget($deger);
                    elseif (strstr($anahtar,"radio")):
                        $SutunVerileri[]=self::$Form->radiobutonget($deger);
                    endif;

                endforeach;



                if (!empty(self::$Form->error)) :


                    self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)));

                else:

                    if (self::$model->Ekleme($Tabload, $SutunAdlari, $SutunVerileri)):



                        self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->basarili($OlumluBilgiVerileri,"/panel/".$gidilecekUrl,3)));


                    else:

                        self::$View->goster($gidilecekDosyaYolu, array("bilgi" => self::$Bilgi->hata($OlumsuzBilgiVerileri,"/panel/".$gidilecekUrl,3)));


                    endif;
                endif;

            else:

                self::$Bilgi->direktYonlen(URL."/panel/".$gidilecekUrl);

            endif;


        endif;



    }

}

?>