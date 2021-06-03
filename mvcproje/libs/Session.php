<?php

class  Session   {
	
	public static $db;
		
	public static function init() {
		
		self::$db= new Database();
		
		session_start();

	} //BAŞLATICI METOD

	public static function set ($key,$value) {

		$_SESSION[$key]=$value;

	} //OTURUM BİLGİSİ TUTUYOR
	
	public static function get ($key) {
		
		if (isset($_SESSION[$key])) 
		
		return $_SESSION[$key];
		
	} //OTURUM BİLGİSİ GELİYOR
	
	public static function destroy() {
		
		session_destroy();
		
	} //OTURUMLAR YOK OLUYOR

	public static function OturumKontrol($tabloAdi,$deger1,$deger2) {
		
        $sonuc=self::$db->listele($tabloAdi,"where ad='".$deger1."' and id=".$deger2);

        /*
        if (!isset($sonuc[0])) :
            self::destroy();
        endif;*/
		
	} //OTURUM BİLGİSİ KONTROLLERİ YAPILIYOR
	
}




?>