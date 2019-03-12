<?php
require_once('../lib/core.lib.php');


if($GPC['ac']=="send"){
	$objsendmail = new sendmail;	
	
	$objsendmail->get_template('new_contact', $lang='es');
	$objsendmail->vars = array(
				"##name##"=>$_REQUEST['name'],
				"##lastname##"=>$_REQUEST['lastname'],
				"##email##"=>$_REQUEST['email'],
				"##telephone##"=>$_REQUEST['telephone'],
				"##company##"=>$_REQUEST['company'],
				"##type##"=>$_REQUEST['type'],
				"##comments##"=>$_REQUEST['comments'],

				);
		$objsendmail->send_email(ADMIN_SITE_EMAIL,'','','',SYSTEM_EMAIL_BCC);
		//$objsendmail->send_email(SYSTEM_EMAIL_BCC);
		
		?><script language="javascript">window.location="?op=send&ac=0";</script><?
		exit;
	}
	

include("../includes/header.php");
?>
<script type="text/javascript" src="<?=DOMAIN_ROOT?>lib/js/captcha.js"></script>

<div id="content" >

<h1>Cont&aacute;ctenos</h1>

      <? if ($_REQUEST['op']=="send") { ?>
 <table width="74%" border="0" cellpadding="0" cellspacing="8">
   <tr>
     <td width="352" height="295" align="left" valign="top">
     <p>Su informaci&oacute;n ha sido enviada satisfactoriamente !!! </p>
        <p>Muy pronto estaremos atendiendo su solicitud. </p>
        <p>Gracias por cont&aacute;ctarnos. </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p></td></tr></table>
     
	
    <? } else { ?>


       <form id="form1" name="form1" method="post" action="?ac=send" >
          <table border="0" cellpadding="0" cellspacing="7" >
            <tbody>
<tr>
                <td colspan="2" align="left" valign="top">
                  <p>Cont&aacute;ctenos al correo: <a href="mailto:hgservicescenter.admon@gmail.com" class="link">hgservicescenter.admon@gmail.com</a><br />
                    <br />
                    O si lo prefiere, complete el formulario que se presenta a continuaci&oacute;n:<br />
                  </p>
                  <div id="msj_error"></div>
                </td>
              </tr>            
              <tr>
                <td valign="top" width="175"><div align="right">* Nombre:</div></td>
                <td><input name="name" size="30" type="text" id="name" class="validate is_req" title="Nombre"   /></td>
              </tr>
              <tr>
                <td valign="top"><div align="right">* Apellido:</div></td>
                <td><input name="lastname" id="lastname" title="Apellido" size="30" type="text" class="validate is_req" /></td>
              </tr>
              <tr>
                <td valign="top"><div align="right">* Email:</div></td>
                <td>
  <input name="email" id="email" size="30" type="text" title="Email" class="validate is_req is_email"></td>
              </tr>
              <tr>
                <td valign="top"><div align="right">* Tel&eacute;fono:</div></td>
                <td><input name="telephone" id="telephone" title="Telefono" size="30" type="text"  class="validate is_num"/></td>
              </tr>
              <tr>
                <td valign="top"><div align="right">Empresa:</div></td>
                <td><input name="company" id="company" size="30" title="Empresa" type="text" /></td>
              </tr>
              <tr>
                <td valign="top"><div align="right">* Consulta:</div></td>
                <td><select name="type" id="type" size="1" title="Consulta" class="validate is_req" style="width:272px;">
                  <option selected="selected" value="">- Seleccionar -</option>
                  <option value="Pregunta">Pregunta</option>
                  <option value="Presupuesto">Presupuesto</option>
                  <option value="Otro">Otro</option>
                </select></td>
              </tr>
              <tr valign="top">
                <td valign="top"><div align="right">* Comentarios:</div></td>
                <td ><textarea name="comments" id="comments" title="Comentarios" cols="40" rows="2" class="validate is_req" style="width:270px;" ></textarea></td> 
              </tr>
 <tr>
            <td align="right" valign="top"><strong>* C&oacute;digo de Validaci&oacute;n:</strong></td>
            <td valign="top"><input name="tmptxt" type="text" id="tmptxt" class="validate is_captcha"/> <span class="label_error" id="mens"></span></td>
          </tr>
          <tr>
		    <td align="right">&nbsp;</td>
		    <td><iframe src="<?=DOMAIN_ROOT ?>lib/common/captcha/php_captcha.php" id="iframe1" frameborder="0"  height="70px" width="125px" style="border: 0px;" scrolling="no" marginheight="5px" marginwidth="0px"></iframe>
            <img src="<?=DOMAIN_ROOT ?>lib/common/captcha/reload_icon.png"  onclick="Reload();refreshCaptcha();" vspace="15" title="Obtener otra imagen" alt="Obtener otra imagen" style="cursor:pointer"/></td>
	      </tr>                
              <tr>
                <td valign="top"><div align="right"></div></td>
                <td align="left">* Campos obligatorios</td>
              </tr>
     
              <tr>
                <td valign="top"><div align="right"></div></td>
                <td  align="center"><input type="button" value="Enviar" id="send" name="send" onclick="validateForm()"></td>
              </tr>
            </tbody>
          </table>
</form>
      <? } ?>

 

  
</div>  <!-- End contenido -->


<? include('../includes/footer.php'); ?>
