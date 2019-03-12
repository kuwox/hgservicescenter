<?php
//Evitamos ataques de scripts de otros sitios
if (preg_match( "/config_var.php/", $_SERVER ["PHP_SELF"] ) || preg_match( "/config_var.php/", $HTTP_SERVER_VARS ["PHP_SELF"] ))
        die("Access denied!");
	
//Directorios
define ( "APPROOT", $_SERVER ['DOCUMENT_ROOT'] . "/" );
// Ej: se usa para los includes
define ( "DOMAIN_ROOT", "http://" . $_SERVER ['SERVER_NAME'] . "/" );
// Ej: se usa para las imágenes, link, etc.
define ( "LOCAL_PEAR_DIR", APPROOT . "/lib/PEAR/" );
//define ( "LOCAL_READERS_WRITERS_EXCEL_DIR", APPROOT . "/lib/common/PHPExcel/" );



// Constantes de Base de datos
//define ( "USER", "root" );
//define ( "PASS", "" );
//define ( "SERVER", "localhost" );
//define ( "DB", "pp_cabl" );

?>
