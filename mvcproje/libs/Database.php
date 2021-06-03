<?php

class Database extends PDO {

	protected $dizi=array();
	protected $dizi2=array();
	
	function __construct() {
    parent::__construct('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',DB_USER,DB_PASS);
    $this->bilgi= new Bilgi();
	} //KURUCU METOD

	function Ekle($tabloisim,$sutunadlari,$veriler) {		
		
		$sutunsayi=count($sutunadlari);	
		for ($i=0; $i<$sutunsayi; $i++) :		
		$this->dizi[]='?';
		endfor;
		
		$sonVal=join (",",$this->dizi);					
		$sonhal=join (",",$sutunadlari);		
		
		$sorgu=$this->prepare('insert into '.$tabloisim.' ('.$sonhal.') 	
		VALUES('.$sonVal.')'); 
		
		
		if ($sorgu->execute($veriler)) : 
		return true;	
		else:		
		return false;	
		
		endif;
		
		
	} // EKLEME
	
	function listele($tabloisim,$kosul=false) {
		
		
		if ($kosul==false) :
		
		$sorgum="select * from ".$tabloisim;
		
		else:
		
		$sorgum="select * from ".$tabloisim." ".$kosul;
												
		endif;
		
		$son=$this->prepare($sorgum);
		$son->execute();
		
		return $son->fetchAll();
		
		
	} // LİSTELEME

	function spesifiklistele($tabloisim,$kosul=false) {


		if ($kosul==false) :

		$sorgum="select ".$tabloisim;

		else:

		$sorgum="select * from ".$tabloisim." ".$kosul;

		endif;

		$son=$this->prepare($sorgum);
		$son->execute();

		return $son->fetchAll();


	} // SPESİFİK LİSTELEME

	function teklistele($sutun,$kosul) {

		$son=$this->prepare("select ".$sutun." ".$kosul);
		$son->execute();
        $veri=$son->fetch(PDO::FETCH_ASSOC);

		return $veri[$sutun];


	} // TEKLİ LİSTELEME

	function sil($tabloisim,$kosul) {
		
		$sorgum=$this->prepare("delete from ".$tabloisim. ' where '.$kosul);
		
		if ($sorgum->execute()) :
		
		return true;	
		else:		
		return false;		
		
		endif;
		
	} // SİLME
	
	function guncelle($tabloisim,array $sutunlar,array $veriler,$kosul) {
		
		
		foreach ($sutunlar as $deger) :
		
		$this->dizi2[]=$deger."=?";
		
		endforeach;
		
		$sonSutunlar=join (",",$this->dizi2);			
		unset($this->dizi2);
		
		
	    $sorgum=$this->prepare("update ".$tabloisim." set ".$sonSutunlar." where ".$kosul);


        if ($sorgum->execute($veriler)) :

            return true;
            else:
            return false;

        endif;


		
	} // GÜNCELLEME
	
	function arama($tabloisim,$kosul) {
		
		
		$sorgum="select * from ".$tabloisim." where ".$kosul;							
		
		
		$son=$this->prepare($sorgum);
        $son->execute();
        if ($son->rowCount()>0) :

            return $son->fetchAll();

        else:

            return false;


        endif;

		

				
		
		
	} // ARAMA
	
	function giriskontrol($tabloisim,$kosul) {
		
		
		$sorgum="select * from ".$tabloisim." where ".$kosul;
		$son=$this->prepare($sorgum);
		$son->execute();
		
		if ($son->rowCount()>0) :
		
		return $son->fetchAll();
		
		else:
		
		return false;
		
		
		endif;
		

		
	} // GİRİŞ KONTROL

	function siparisTamamla($veriler=array()) {
		

		
		$sorgu=$this->prepare('insert into siparisler (siparis_no,adresid,uyeid,urunad,urunadet,urunfiyat,toplamfiyat,odemeturu,durum,tarih) 	
		VALUES(?,?,?,?,?,?,?,?,?,?)');
		
		
		$sorgu->execute($veriler);
		
		
		
	} // SİPARİŞ TAMAMLA
	
    function sistembakim($deger){
	    $sorgu=$this->prepare('SHOW TABLES');

        if ($sorgu->execute()) :

            $tablolar=$sorgu->fetchAll();

            foreach ($tablolar as $tabloadi):

                $this->query("REPAIR TABLE ".$tabloadi["Tables_in_".$deger.""]);
                $this->query("OPTIMIZE TABLE ".$tabloadi["Tables_in_".$deger.""]);


            endforeach;
            $tarih=date("d.m.Y-H:i");
            $zamanguncelle=$this->prepare("update ayarlar set bakimzaman='$tarih'");
            $zamanguncelle->execute();
            return true;

        else:
            return false;

        endif;




    } // SİSTEM BAKIM

    function veritabaniyedek($deger){

	    $tables=array();
        $sorgu=$this->prepare('SHOW TABLES');

        //çalışma kontrol
        if ($sorgu->execute()): $durum=true; else: $durum=false; endif;

        while ($row=$sorgu->fetch(PDO::FETCH_ASSOC)):
            $tables[]=$row["Tables_in_".$deger.""];
        endwhile;

        $return="SET NAMES utf8;";
        //tabloların içine girilecek
        //tablolarda kaç sutun var
        //tabloların verileri alınacak


        foreach ($tables as $tablo):
            $result=$this->prepare("select * from $tablo");
            $result->execute();
            $numColumns=$result->columnCount();

            $return.="DROP TABLES IF EXIST $tablo;";

            $result2=$this->prepare("SHOW CREATE TABLE $tablo");
            $result2->execute();
            $row2=$result2->fetch(PDO::FETCH_ASSOC);
            $return.="\n\n".$row2["Create Table"].";\n\n";


            for ($i=0;$i<$numColumns;$i++):



                while ($row=$result->fetch(PDO::FETCH_NUM)):
                    $return.="INSERT INTO $tablo VALUES(";

                    for ($j=0;$j<$numColumns;$j++):

                        //boş sutun kontrollü ekleme
                        if (isset($row[$j])): $return.='"'.$row[$j].'"';  else: $return.='""'; endif;
                        //sutun içerik ayracı
                        if ($j<($numColumns-1)): $return.=','; endif;

                    endfor;

                    $return.= ");\n";


                endwhile;


            endfor;
            $return.= "\n\n\n";
        endforeach;

        if ($durum):
            $tarih=date("d.m.Y-H:i");
            $zamanguncelle=$this->prepare("update ayarlar set yedekzaman='$tarih'");
            $zamanguncelle->execute();
        endif;

        return [$durum,$return];





    } // VERİ TABANI YEDEK

    function sayfalamaAdet($tabload){
	    $cek=$this->prepare("select COUNT(*) AS toplam from ".$tabload);
        $cek->execute();
        $son=$cek->fetch(PDO::FETCH_ASSOC);
        return $son["toplam"];


    } // SAYFALAMA TOPLAM ADET

    function joinislemi($istenilenveriler,$tablolar,$kosul) {

            $sonveriler=join(",",$istenilenveriler);
            $sontablolar=join(" JOIN ",$tablolar);

            $sorgum="select ".$sonveriler." from ".$sontablolar." ON ".$kosul;

        $son=$this->prepare($sorgum);
        $son->execute();

        return $son->fetchAll();



    } // JOİN

}




?>