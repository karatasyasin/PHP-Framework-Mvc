<?php

class sayfalar extends Controller  {
	
	
	function __construct() {
        parent::KutuphaneYukle(array("View"));

        Session::init();

	}	
	
		
	
	function iletisim() {
	
	$this->View->goster("sayfalar/iletisim");
		
	}
	
	function sepet() {
	
	$this->View->goster("sayfalar/sepet");
		
	}
	
	function kargonezamangelir() {
	
	$this->View->goster("sayfalar/diger/kargonezaman");
		
	}
	
	function iadehakki() {
	
	$this->View->goster("sayfalar/diger/iadehakki");
		
	}
	
	function musterihizmetleri() {
	
	$this->View->goster("sayfalar/diger/musterihizmetleri");
		
	}
	
	function gizlilikpolitikasi() {
	
	$this->View->goster("sayfalar/diger/gizlilikpolitikasi");
		
	}
	function satissozlesmesi() {
	
	$this->View->goster("sayfalar/diger/satissozlesmesi");
		
	}

	
	function siparisitamamla() {
	
	$this->View->goster("sayfalar/siparisitamamla");
		
	}
	
	
	
	
}




?>