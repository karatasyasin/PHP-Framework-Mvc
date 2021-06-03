<?php

class  Dosyacikti {

    function Excelaktar($tablobasligi,array $enaltsatir=NULL,$columns=array(),$data=array())
    {
        $filename=date("d.m.Y");
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-disposition: attachment; filename='.$filename.'.xls');
        echo "\xEF\xBB\xBF"; // bom ham veri için


        $sayim=count($columns);

        echo '<table border="1"><th style="background-color:#6f26c0" colspan="'.$sayim.'">
	<font color="#FDFDFD">'.$tablobasligi.'</font></th>
	<tr>';
        // BAŞLIKLAR  OLUŞUYOR
        foreach ($columns as $veri):

            echo '<td style="background-color:#ddb446">'.trim($veri)."</td>";

        endforeach;

        echo '</tr>';


        //VERİLER OLUŞUYOR
        foreach ($data as $val):
            echo '<tr>';

            for($i=0; $i<$sayim; $i++):
                echo '<td>'.$val[$i]."</td>";
            endfor;

            echo '</tr>';
        endforeach;

        if ($enaltsatir!=NULL):
            echo '<tr>';
            foreach ($enaltsatir as $veri):
                echo '<td style="background-color:#ddb446">'.trim($veri)."</td>";
            endforeach;
            echo '</tr>';
        endif;


        echo '</table>';
    } //EXCEL FORMATI

    function txtolustur($icerikler){

        $filename=date("d.m.Y");
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-disposition: attachment; filename='.$filename.'.txt');
        echo "\xEF\xBB\xBF"; // bom ham veri için


        foreach ($icerikler as $value):
            echo $value["mailadres"]."\r\n";
        endforeach;



    } //TXT FORMATI

    function veritabaniyedekindir($icerikler){

        $filename=date("d.m.Y");
        header('Content-Encoding: UTF-8');
        header('Content-Type: text/plain; charset=utf-8');
        header('Content-disposition: attachment; filename='.$filename.'.sql');
        echo "\xEF\xBB\xBF"; // bom ham veri için

        echo $icerikler;



    } //SQL FORMATI

}


?>