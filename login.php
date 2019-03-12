<?
defined( '_JEXEC' ) or die( 'Restricted access' );


if($_REQUEST['ac']=='login') {

	//buscamos email en la base de datos

	$arruser = $user->login($_POST['login'],$_POST['password']);
	//die('='.$arruser[0]['user_id']);
	if (empty($arruser)) {
		$_SESSION['error_msg']= "Error en email o clave";
		//die('2='.$error_login);
		//$task="index.php";
	} elseif($arruser[0]['user_inactive_reason']==1) {
		$_SESSION['error_msg']= "Su registro se encuentra en proceso de activaci&oacute;n.<br>
		Un correo ha sido enviado a su email, con el link para la activacion de su nueva cuenta.
		<p>Recuerde revisar su carpeta de <strong>Correos No Deseados</strong>.</p>";
		//$task="index.php";
	} else {
		$_SESSION['user_id'] = $arruser[0]['user_id'];
		$_SESSION['user_type'] = $arruser[0]['user_type'];
		$_SESSION['name'] = $arruser[0]['username'];
		$_SESSION['email'] = $arruser[0]['user_email'];
		//die('='.$_SESSION['user_id']);
		?><script language="javascript">window.location="?option=member_area";</script><?	
	
	}
	

}


if($_REQUEST['ac']=='logout') {
	session_start();
	session_unset();
	session_destroy();
	?><script language="javascript">window.location="?option=home";</script><?	
}	

$title_page="Acceso Usuarios";
$img_header="teaser-main.jpg";

include("includes/header.php");
?>
<script>
function volvercon(controla, valora) { 
  if (document.getElementById(controla).value=='') {
     document.getElementById(controla).value=valora;
  } else{
   if (document.getElementById(controla).value==valora) {
      document.getElementById(controla).value='';
    }
   return true;
  }
}  // fin de la funcion
</script>

<link href="css/styles.css" rel="stylesheet" type="text/css" />

<div id="content">
  <h1><strong>Acceso Usuarios Registrados</strong></h1>
		<p>El &aacute;rea privada de Vigo Imagenes  es un servicio tecnol&oacute;gico exclusivo que ofrecemos a nuestros clientes.</p>
		<p>Si desea acceder al &aacute;rea,  h&aacute;ganos <a href="?option=cita">llegar sus datos aqu&iacute;</a> .</p>
		  <? if (empty($_SESSION['user_id'])) { ?>        
  
  <p>Para entrar por favor identifiquese,<br />
    <? if (!empty($_SESSION['error_msg'])) {?>
  <div class="flash-message" align="center"><?=$_SESSION['error_msg'];?></div>
    <? } ?>

  </p>
		<form id="form_login" name="form_login" action="?option=login&ac=login" method="POST" class="cmxform">
          <table align="left" border="0"  cellspacing="5" cellpadding="0">
            <tr>
              <td>Usuario:</td>
              <td><input name="login" id="login" value="e-mail" size="25" onfocus="volvercon('login', 'e-mail');" onblur="volvercon('login', 'e-mail');" type="text" /></td>
            </tr>
            <tr>
              <td>Clave:</td>
              <td><input size="25" id="password" name="password" type="password" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input value="Entrar" type="submit" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><a href="?option=recordar_clave">&iquest;Olvid&oacute; su Clave?</a></td>
            </tr>
          </table>
          <p>&nbsp;          </p>
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><br />
            <strong>
            <!--<a href="?option=olvidoclave">&iquest;Olvid&oacute; su contrase&ntilde;a?</a><br />-->
            </strong></p>
        </form>
<? } else { ?>
            <p><br />
<strong>Bienvenido(a) <?=$_SESSION['name']?></strong><br />
            <strong><a href="?option=login&task=logout" style="font-size:11px; color:#00C;">Cerrar Sesion</a></strong><br />
            </p>
  <? } ?>
            
            
            
            
</div>


             