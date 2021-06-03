<?php

class  Controller {

    public function Modelyukle($name) {

        $yol='model/'.$name.'_model.php';

        if (file_exists($yol)) :

            require $yol;

            $modelsinifName=$name.'_model';

            $this->model= new $modelsinifName();

        endif;


    }// ihtiyacımız olan model'i dahil ediyoruz

    public function RouterModelyukle($name) {

        $yol='model/'.$name.'_model.php';

        if (file_exists($yol)) :

            require $yol;

            $modelsinifName=$name.'_model';

            return new $modelsinifName();

        endif;


    }// ihtiyacımız olan router model'i dahil ediyoruz

    function KutuphaneYukle(array $ad){

        foreach ($ad as $deger):
            $this->$deger = new $deger();
            endforeach;

    }// ihtiyacımız olan kütüphaneleri dahil ediyoruz

}




?>