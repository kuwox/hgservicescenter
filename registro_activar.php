<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

if ($_REQUEST['cont']=="clave") {

	$user = new user();
	$arr_user = $user->get_usuario_inactive($_REQUEST['u'],$_REQUEST['tmpkey']);
	//die('='.sizeof($arr_user));
	
	if(sizeof($arr_user)>0){
		$user->active_user($_REQUEST['u']);
		$usr_activado = 1;	
	}
}

$title_page="Imagenologia";
$img_header="teaser-main.jpg";

include("includes/header.php");

?>

<link href="css/styles.css" rel="stylesheet" type="text/css" />



<div id="content">
<h1><strong>Activacion de Cuenta de Usuario</strong></h1>

<? if ($usr_activado == 1) { ?>
	<p align="center">&nbsp; </p>
	<p align="center"><strong>Su cuenta ha sido Activada Satisfactoriamente!</strong> </p>
	<p align="center">&nbsp;</p>
        <p>Ahora puede comenzar a disfrutar de los beneficios de participar con nosotros.<br /> 
          <a href="?option=login">Ingrese a su cuenta ahora</a></p>
<? } else { ?>
	<p align="center">&nbsp; </p>
  <p align="center"> <strong><span class="error">Error:</span></strong> El enlace solicitado ya no es valido.</p>
	<p align="center"><a href="index.php">Ir al Inicio</a></p>    
<? } ?>
       
       
<p>&nbsp;</p>
   
</div>



<?


?>
