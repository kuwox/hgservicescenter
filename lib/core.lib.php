<?php 
//Evitamos ataques de scripts de otros sitios
if (preg_match( "/core.lib.php/", $_SERVER ["PHP_SELF"] ) || preg_match( "/core.lib.php/", $HTTP_SERVER_VARS ["PHP_SELF"] ))
        die("Access denied!");

$ini_request=microtime(true);
//El config_var va en el mismo directorio del core.lib

require ("config_var.php");

////CONEXION CON LA BASE DE DATOS
//$link = mysql_connect ( SERVER, USER, PASS ) or die ( "Cound not connect to Database server" );
//mysql_select_db ( DB, $link ) or die ( "Could not open database" );

session_start();

////require_once(APPROOT."lib/rewrite_globals.php");

/*
 * Invocador automatico de clases
 * La clase debe llamarse igual que el archivo para que funcione y estar en la carpeta class
 * de lo contrario incluirlo a mano
 */
/*function __autoload($class_name) {
	if ((class_exists($class_name))) {
		return false;
	}
	$classDir=APPROOT."lib/class/";
	$file=strtolower($class_name).".class.php";
	if(file_exists($classDir.$file)){
		require_once $classDir.$file;
	} else {
		die('La clase <strong>'.$class_name.'</strong> no logra ser invocada por el cargador, revise el nombre de la clase y el archivo o incluyala a mano');
	}
}*/

//$objlogs = new logs();
//$objdbtools = new dbtools();
//$objparams = new parametros();
//$objgeneral = new general();

//Incluir otras clases usadas
//Clases de correos
require_once(APPROOT."lib/class/phpmailer/class.phpmailer.php");

//$start = "1";  // Inicio
//$total_left = "1"; // Numero total de imagenes 
//$total_right = "1";

//$random_right = 'right-'.mt_rand($start, HOME_GALLERY_RIGHT).'.png'; 
//$random_left = 'left-'.mt_rand($start, HOME_GALLERY_LEFT).'.png';

//die("=".$random_right);


//Iniciar otros objetos
//$objuser = new usuarios();
//$objcountdb = new countbd();

//habilitamos el error handler
/*if ((DEBUG) and (Debug::$config['Handler'])){

	$errorhandler = array (
			Debug,
		'errorHandlerCallback'
	);
	set_error_handler($errorhandler);
}*/

?>