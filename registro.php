<?php

defined( '_JEXEC' ) or die( 'Restricted access' );


if ($_POST['ac']=="save") {		


		$user = new user();
		$arruser = $user->get_user($_POST['email']);
		//$arremail = $user->get_user('',$_POST['email'])	;							  
		if (!empty($arruser)) {
			$msg_error ="Email ya esta registrado";
		} else {		
			$arr_new_user = $user->add_user($_POST['email'],$_POST['email'],$_POST['pass']);	

			$send_mail = new send_mail;
			$send_mail->get_template('user_new_confirmation', $lang='es');
			$send_mail->vars = array(
			"##login##"=>$_POST['email'],
			"##clave_temporal##"=>$arr_new_user[1],
			"##user_id##"=>$arr_new_user[0],
			"##server_path##"=>DOMAIN_ROOT,
			);
	
			$send_mail->send_email($_POST['email']);

			?><script language="javascript">window.location="?option=registro&op=save";</script><?			
		}

}

$title_page="Nuevo Usuario";
$img_header="teaser-main.jpg";

include("includes/header.php");

?>


<div id="content-no-right">

    
<? if ($_REQUEST['op']=="save") { ?>
<h1>Registro por Activar</h1>	 
    <p>Un correo ha sido enviado a su email, con el link para la activacion de su nueva cuenta.</p>
    <p>Recuerde revisar su carpeta de <strong>Correos No Deseados</strong>.</p>
<? } else { ?>

        <h1>Nuevo Usuario </h1>	 <br />
        
  		<p>Registrese para obtener acceso a nuestro Sistema en Linea.
          <br />
          <br />
Si usted ya esta registrado, ingrese en  <a href="?option=login">Su Cuenta aqu&iacute;</a></p>


	<div id="msj_error" class="errormsg"><?=$msg_error?></div>
 	<form id="form1" name="form1" method="post" action="?option=registro">
<input name="ac" value="save" type="hidden" />
        <table width="100%" cellpadding="0" cellspacing="5">
          <tr>
            <td valign="top"><div align="right">* Email:</div></td>
            <td><input name="email" id="email" size="30" type="text" value="<?=$_POST['email']?>" class="validate is_req is_email" /></td>
          </tr>
          <tr>
            <td valign="top"><div align="right">* Confirmar Email:</div></td>
            <td><input name="email_confirm" id="email_confirm" size="30" type="text" value=""  class="validate is_req is_equalto:#email" /></td>
          </tr>            
          <tr>
            <td valign="top"><div align="right">* Clave:</div></td>
            <td><input name="pass" id="pass" size="32" type="password" class="validate is_req"></td>
          </tr>
          <tr>
            <td align="right">* Confirmar Clave:</td>
               <td><input  name="password_confirm" id="password_confirm" class="validate is_req is_equalto:#pass" size="32" value="" type="password" /></td>
          </tr>
         
          <tr>
            <td colspan="2" valign="top"><div align="right"><br />
            <span class="box-td">* Campos obligatorios</span>&nbsp;&nbsp;&nbsp; </div></td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input type="submit" value="Aceptar" id="send" name="send" onclick="validateForm('')">
            </td>
          </tr>
        </table>
  </form>
<? } ?>  

  


</div>

