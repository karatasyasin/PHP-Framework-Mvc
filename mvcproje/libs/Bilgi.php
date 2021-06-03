<?php

class Bilgi  {

		function basarili($deger,$yol) {

		    if(gettype($deger)==="array"): $deger = $deger[0]; endif;
			
			return '<div class="alert alert-success mt-5 text-center">'.$deger.'</div>'
			. header("Refresh:3; url=".URL.$yol);
		}
		
		function hata($deger=false,$yol) {

            if(gettype($deger)==="array"): $deger = $deger[0]; endif;
			
			return '<div class="alert alert-danger mt-5 text-center">'.$deger.'</div>'
			. header("Refresh:3; url=".URL.$yol);
		}
		
		function uyari($tur,$metin,$id=false) {
			
			
			return '<div class="alert alert-'.$tur.' mt-2 pt-3 text-center" '. $id.'>'.$metin.'</div>';
		}
		
		function direktYonlen($yol) {

			return  header("Location:".URL.$yol);

		}

}




?>