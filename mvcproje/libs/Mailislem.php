<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailislem {

    function __construct(){

        require_once(dirname(__DIR__).'/helpers/mail/src/Exception.php');
        require_once(dirname(__DIR__).'/helpers/mail/src/PHPMailer.php');
        require_once(dirname(__DIR__).'/helpers/mail/src/SMTP.php');

    }  //KURUCU METOD

    public function mailgonder(array $mailadresleri,$mailkonu,$mailcerik){
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = HOSTMAİL;
            $mail->SMTPAuth   = true;
            $mail->Username   = HOSTMAİLADRES;
            $mail->Password   = HOSTMAİLSİFRE;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->setLanguage('tr','/language/');
            $mail->CharSet="UTF-8";

            //Recipients
            $mail->setFrom('tezmvcmarket@gmail.com', 'MVC MARKET');

            foreach ($mailadresleri as $deger):
            $mail->addAddress($deger);
            endforeach;

            $mail->addReplyTo('tezmvcmarket@gmail.com', 'Bilgilendirme');

            //Content
            $mail->isHTML(true);
            $mail->Subject = $mailkonu;
            $mail->Body    = $mailcerik;

            $mail->send();
            echo 'Gönderildi';
        } catch (Exception $e) {
            echo "Hata oluştu: {$mail->ErrorInfo}";
        }

    } //MAİL GÖNDERİLİYOR

}