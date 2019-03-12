<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$_msg = "";
?>

<? if ($_REQUEST['ac']=="send") {
	
	$arruser = $user->get_user('', $_POST['email']);

	//die('='.$arruser[0]['user_id']);
	if (empty($arruser)) {
		$_msg = "Email no esta registrado";	
	} else {
		
		//generamos clave temporal
		$user_actkey = $user->save_clave_tmp($arruser[0]['user_id'],$_POST['pass']);
		
		
		//Enviamos correo con link para activar clave nueva
		$send_mail = new send_mail;
		$send_mail->get_template('clave_tmp', $lang='es');
		$send_mail->vars = array(
		"##login##"=>$arruser[0]['username'],
		"##user_id##"=>$arruser[0]['user_id'],
		"##actkey##"=>$user_actkey,
		"##server_path##"=>DOMAIN_ROOT,
		);

		$send_mail->send_email($_POST['email']);
		
		?><script language="javascript">window.location="?option=recordar_clave&op=send&ac=0";</script><?
		exit;
	}
}


$title_page="Clave Nueva";
$img_header="teaser-main.jpg";

include("includes/header.php");

?>



      <div id="content">
        <h1>Recordar Clave</h1>

      
      <? if ($_REQUEST['op']=="send") { ?>

	<p>Un correo le ha sido enviado para la activaci&oacute;n de su nueva clave!!! </p>
        <p></p>
        <p>Gracias por cont&aacute;ctarnos. </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    <? } else { ?>

      <p>Para restablecer su clave, por favor complete los siguientes datos:<br />
      </p>
      <div id="msj_error"> <? if (!empty($_msg)) echo $_msg; ?></div>

       <form id="form1" name="form1" method="post" action="?option=recordar_clave&ac=send" >
          <table cellpadding="0" cellspacing="5">
            <tbody>
              <tr>
                <td valign="top"><div align="right">* Email:</div></td>
                <td>
  <input name="email" id="email" size="30" type="text" title="Email" class="validate is_req is_email"></td>
              </tr>
 <tr>
                <td valign="top"><div align="right">* Clave Nueva:</div></td>
                <td>
<input name="pass" id="pass" size="30" type="password" value=""  class="validate is_req"></td>  
              </tr>  
 <tr>
			 <td align="right">* Confirmar Clave:</td>
                <td><input  name="password2" id="password2" size="30" value="" type="password" class="validate is_req is_equalto:#pass"/></td>
              </tr>                            
 <tr>
                <td width="45%" align="right" valign="top">&nbsp;</td>
                <td valign="top"><iframe src="lib/common/captcha/php_captcha.php" id="iframe1" frameborder="0"  height="70px" width="125px" style="border: 0px;" scrolling="no" marginheight="5px" marginwidth="0px"></iframe> <img src="lib/common/captcha/reload_icon.png"  onclick="Reload();refreshCaptcha();" vspace="19"/></td>
             </tr>
             <tr>
                <td width="45%" align="right" valign="top">* Codigo de Validaci&oacute;n:</td>
                <td valign="top"><input name="tmptxt" type="text" id="tmptxt" class="validate is_req"/> <span id="mens"></span></td>
             </tr>
              <tr>
                <td valign="top"><div align="right"></div></td>
                <td align="left">* Campos obligatorios</td>
              </tr>
     
              <tr>
                <td valign="top"><div align="right"></div></td>
                <td  align="center"><input type="button" value="Enviar" id="send" name="send" onclick="validateForm('captcha')"><!--<input name="send" value="Enviar" type="submit" />--></td>
              </tr>
            </tbody>
          </table>
        </form>

      <? } ?>
  </div>
