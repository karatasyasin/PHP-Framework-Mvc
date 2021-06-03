<?php

class  Captcha {

public $kaynak;

    function __construct() {

        $this->kodolustur();

    } //KURUCU METOD

    function kodolustur() {
        $this->kaynak=URL."/views/sayfalar/diger/captcha.php";

    } //CAPTCHA OLUŞTUR

    //işlemsel fonksiyonlar eklenebilir!! (+-*/)

}




?>