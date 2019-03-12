<?php
class Captcha{
	var $chars = '1234567890abcdefghijklmnopqrstuvwxyz'; // O  and 0 (Zero) are visually similar, that's why I am not using it
	var $RandomStr = '';
	function OutputCaptcha($width=100,$height=70,$length=4){
		for($i = 0; $i < $length; $i++){ // Generating the captcha string
		   $pos = mt_rand(0, strlen($this->chars)-1);
		   $this->RandomStr .= substr($this->chars, $pos, 1);
		}
		$ResultStr = $this->RandomStr;
		$NewImage = imagecreatetruecolor(200, 70);
		// Colores Aleatorios
		$color1 = rand(1,255);
		$color2 = rand(1,255);
		$color3 = rand(1,255);
			//Colores
		$rojo = imagecolorallocate($NewImage, 255, 60, 75);
		$ramdo = imagecolorallocate($NewImage, $color1, $color2 , $color3);
		$negro = imagecolorallocate($NewImage, 0, 0 , 0);
		$verde = imagecolorallocate($NewImage, 128, 158 , 26);
		$blanco = imagecolorallocate($NewImage, 255, 255, 255);
		$azul = imagecolorallocate($NewImage, 150, 190, 255);
		$orange = imagecolorallocate($NewImage, 254, 114, 28);
		$fondo = imagecolorallocate($NewImage, 228, 229, 223);
		$TextColor = imagecolorallocate($NewImage, 0, 0, 0);//text color-Black
		//Rellenado de la imagen
		imagefilledrectangle($NewImage, 0, 0, 200, 70, $fondo);
		$fuente = 'Hotel Coral Essex.ttf'; // Aqui podemos cambiar de fuente entre otras mas cosas
		imagettftext($NewImage, 30, 5, 35, 60, $azul, $fuente, $ResultStr);	
		$_SESSION['captcha_val'] = $ResultStr;// carry the data through session
		header("Content-type: image/gif");// out out the image 
		imagegif($NewImage);//Output image to browser 
		
		}

}

?>