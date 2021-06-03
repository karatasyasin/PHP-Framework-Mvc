<?php

session_start();

$kod=substr(md5(mt_rand(0,9999999)),0,6);
$_SESSION["kod"]=$kod;
header('Content-type: image/png');
$resim=imagecreate(100,50);
$arka_renk=imagecolorallocate($resim,225,237,60);
$yazi_renk=imagecolorallocate($resim,30,30,30);
$cizgi_renk=imagecolorallocate($resim,60,60,60);

for ($i=0;$i<10;$i++):
imageline($resim,0,rand()%90,200,rand()%90,$cizgi_renk);
    endfor;

$nokta_renk=imagecolorallocate($resim,0,0,255);

for ($i=0;$i<100;$i++):
    imagesetpixel($resim,rand()%100,rand()%50,$nokta_renk);
endfor;

imagestring($resim,35,20,20,$kod,$yazi_renk);
imagepng($resim);
imagedestroy($resim);



?>