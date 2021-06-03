<?php

class Token {

    function kodolustur() {
        $token=md5(sha1(base64_encode(gzdeflate(gzcompress(serialize(mt_rand(0,9999999)))))));
        Session::set("token",$token);
        return $token;
    } //TOKEN OLUŞUYOR

}



?>