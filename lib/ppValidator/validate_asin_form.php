<?php
//include("../core.php");
require_once('../core.lib.php');

$data = $_REQUEST['data'];
$msg_error = "Por favor verifique los campos con errores";
// id | value | funcion | title ^
//die('data recibida= '.$data);

//$_msg_paciente = unserialize($_REQUEST['data']);
$vector = explode('^',$data);
$error = false;
//$vector = array("uno", "dos", "tres");
//Leemos lineas

foreach ($vector as $valor) {
	// Leemos campos
	//$fields = explode('|',$valor);
	list($id, $value, $function, $title) = explode('|',$valor);
	// id | value | funcion | title ^
	if (!empty($id))	{
		//echo "Valor: $id $value $function $title<br>";
		$arr_function = split(" ",$function);
		
		foreach ($arr_function as $one_function) {
			//echo $one_function.' '.$id.' '.$value.' .. <br>';
			
			//Verifica si la funcion esta definida
			$function_final = split(":#",$one_function);
			//echo $function_final[0].' '.$id.' '.$value.' //<br>';
			//echo('<br>'.$one_function[0]);
			if(function_exists('validate_'.$function_final[0])){
				$arr_value = split('#_',$value );
				//Ejecuta la funcion 
				//echo $function_final[0].' '.$id.' '.$arr_value[0].' '.$arr_value[1].' //<br>';
				if ($result = call_user_func_array('validate_'.$function_final[0], array($id, $arr_value))) {	
					$error = 1; 
					break;
					//die('error='.$error);
				} else {
					//die('no hay error');
				}
			}
		}		
	}
   
} 



//echo('aqui='.$error);
if(empty($error)) {
	die("");
} else {
	echo $msg_error;
}

//imprimir todo el array
//echo 'ERROR '.$data[0].'<br>'.$data[1];
//echo "a=".$_REQUEST['a'];



//Valida que tenga formato de email
function validate_is_email($id='',$value='') {

	$email = strtolower($value[0]);
	$cadena = '([\w\!\#$\%\&\'\*\+\-\/\=\?\^\`{\|\}\~]+\.)*(?:[\w\!\#$\%\'\*\+\-\/\=\?\^\`{\|\}\~]|&amp;)+@((((([a-z0-9]{1}[a-z0-9\-]{0,62}[a-z0-9]{1})|[a-z])\.)+[a-z]{2,6})|(\d{1,3}\.){3}\d{1,3}(\:\d{1,5})?)';
	
	if (!preg_match('/^' . $cadena . '$/i', $email)) {
		?>
		<script type="text/javascript">
		print_msgError('<?=$id?>',"* Formato de Email Invalido");
		</script>        
		<?
		return true;
	}
	return false;
}

// Valida que la cadena no sea vacia
function validate_is_req($id='',$value='') {
	
	if (empty($value[0])) {
		?>
		<script type="text/javascript">
		print_msgError('<?=$id?>',"* Campo requerido");
		</script>
		<?
		return true;
	}
	return false;
}

//Valida que sea un numero real
function validate_is_num($id='',$value='') {
	if (!is_numeric($value[0])) {
		?>
		<script type="text/javascript">
		print_msgError('<?=$id?>',"* Ingrese solo numeros");
		</script>
		<?
		return true;
	}
	return false;
}

//Valida que sea solo numeros positivos
function validate_is_int($id='',$value='') {
	if (!is_numeric($value[0]) or $value[0]<0) {
		?>
		<script type="text/javascript">
		print_msgError('<?=$id?>',"* Ingrese un numero valido");
		</script>
		<?
		return true;
	}
	return false;
}

//Valida que el captcha sea el indicado
function validate_is_captcha($id='',$value='') {
	
	if (!($_SESSION['captcha_val'] == $value[0]) or empty($value[0])) {
		?>
		<script type="text/javascript">
		print_msgError('<?=$id?>',"* Codigo invalido");
		</script>
		<?
		return true;
	}
	return false;
}

//Valida que 2 campos sean iguales
//Falta recibir un array en el value
function validate_is_equalto($id='',$value='') {
	//die('ss	='.$value[1]);
	
	if ($value[0] != $value[1]) {
		?>
		<script type="text/javascript">
		print_msgError('<?=$id?>',"* Confirmacion incorrecta");
		</script>
		<?
		return true;
	}
	return false;
}

//Valida que 2 campos sean iguales
//Falta recibir un array en el value
function validate_min($id='',$value='') {
	//$value[0]  valor
	//$value[1]  valor minimo
	
	if(strlen($value[0]) < $value[1]) 
	if ($value[0] != $value[1]) {
		?>
		<script type="text/javascript">
		print_msgError('<?=$id?>',"* La confirmación que introdujo es incorrecta");
		</script>
		<?
		return true;
	}
	return false;
}
 ?>		