<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<? if($_REQUEST['cont']=="clave") {
	
	$arrUser = $user->get_usuario_by_fields( array("user_id"=>$_REQUEST['i'],"user_actkey"=>$_REQUEST['tmpkey']) );

	//die('='.sizeof($arrUser));
	if(sizeof($arrUser)<1){
		?><script language="javascript">window.location="?option=reestablecer_clave";</script><?
		exit;
	}
	
	//actualiza clave temporal

	$user->update_clave_temp($arrUser[0]['user_id']);
	$clave_activado = 1;
		
		
}


$title_page="Clave Nueva";
$img_header="teaser-main.jpg";

include("includes/header.php");

?>



<div id="content">
	<h1>Recordar Clave</h1>

      
	<? if ($clave_activado == 1) { ?>

	<p>Su clave nueva ha sido cambiada correctamente!!! </p>
        <p></p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    <? } else { ?>

      <div id="msj_error">El enlace solicitado ya no es valido.</div>


      <? } ?>
</div>
