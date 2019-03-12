<?
defined( '_JEXEC' ) or die( 'Restricted access' );


if ($_POST['ac']=="send") {

//die('='.$_POST['ac']);
	//buscamos email en la base de datos
	$user = new user();
	$arruser = $user->get_user($_POST['email']);

	//die('='.$arruser[0]['name']);	
	
	if (!empty($arruser)) {
		$_msg="Email ya esta registrado";
		
	} else {
		
		//Guardamos los datos del Form en variables y evitamos la comilla simple
		$pass = md5($_POST['pass']);
		$person_id = $_POST['person'].'-'.$_POST['person_id'];
		$user->add_user($_POST['email'],$_POST['name'],$_POST['lastname'],$_POST['telephone'],$pass,$_POST['company'],$person_id,$_POST['address'],$_POST['movil'],$_POST['city'],$_POST['state']);	

		// multiple recipients
		$to  = $email_master; 
		
		// subject
		$subject = 'Nuevo Usuario';
		
		// message
		$message = '
		<html>
		<body>
		  <p>Una persona requiere de su Aprobaci&oacute;n para entrar al sistema. Puede aprobar este registro en el Area restringida del Sitio Web.</p>
		  <table>
			<tr>
			  <td>Nombre:</td>
			  <td>'.$_POST['name'].'</td>
			</tr>
			<tr>
			  <td>Apellido:</td>
			  <td>'.$_POST['lastname'].'</td>
			</tr>
			<tr>
			  <td>email:</td>
			  <td>'.$_POST['email'].'</td>
			</tr>
			<tr>
			  <td>Movil:</td>
			  <td>'.$_POST['movil'].'</td>
			</tr>
			<tr>
			  <td>CI / RIF</td>
			  <td>'.$person_id.'</td>
			</tr>			
			<tr>
			  <td>Compa&ntilde;&iacute;a:</td>
			  <td>'.$_POST['company'].'</td>
			</tr>
			<tr>
			  <td>Direccion:</td>
			  <td>'.$_POST['address'].'</td>
			</tr>
			<tr>
			  <td>Telefono:</td>
			  <td>'.$_POST['telephone'].'</td>
			</tr>
			<tr>
			  <td>Ciudad:</td>
			  <td>'.$_POST['city'].'</td>
			</tr>	
			<tr>
			  <td>Estado:</td>
			  <td>'.$_POST['state'].'</td>
			</tr>		
			<tr>
			  <td>&nbsp;</td>
			  <td></td>
			</tr>			
		  </table>
		</body>
		</html>
		';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'From: www.presenciaprofesional.com <info@presenciaprofesional.com>' . "\r\n";
		//$headers .= 'To: <'.$to.'>' . "\r\n";		
	
		// Mail it
		mail($to, $subject, $message, $headers);	

		// Mail Copy Webmaster
		//$subject.= " to:".$to;
		//mail($email_copy, $subject, $message, $headers);

	?><script language="javascript">window.location="?option=register&op=send";</script><?
	
	}
}

?>
<script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();	
	});
</script>

<div id="MiddlePart">
  <div class="article_contact_us" style=" background-color:#eef0f2">
                        
                            
<? if ($_REQUEST['op']=="send") { ?>
<h2>Registro en Proceso</h2>	 
<p class="paragraf_left">&nbsp;</p>
<p class="paragraf_left">Su registro est&aacute; en proceso de aprobaci&oacute;n !!!</p>
<p class="paragraf_left">En poco tiempo recibir&aacute; un correo de notificaci&oacute;n de su registro. Y confirmaci&oacute;n de su Cita para el d&iacute;a escogido.</p>
<p class="paragraf_left">Gracias por usar nuestro sistema de Cita Programada. </p>
<p class="paragraf_left">&nbsp;</p>
<p class="paragraf_left">&nbsp;</p>
<p class="paragraf_left">&nbsp;</p>
<p class="paragraf_left">&nbsp;</p>

<? } else { ?>
<h2>Registr&eacute;se</h2>	 <br />

<p class="paragraf_left">Por favor llene el siguiente formulario para crear su cuenta en nuestro Sitio Web y tener acceso al Area de Citas Programadas.<br />
  <br />
Si lo que desea es respuesta a una inquietud, le sugerimos que entre en el men&uacute; de <strong>Cont&aacute;ctenos</strong> haciendo clic <a href="?option=contact_us">aqu&iacute;</a></p>
<form id="form1" name="form1" method="post" action="?option=register" class="cmxform">
 <? if (!empty($_msg)) {?>
	<div class="div_msg">
    	<span class="txt_msg"><?=$_msg;?></span>
	</div>
<? } ?>
  <table cellpadding="2" cellspacing="0" >
            <tbody>
               <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top" width="96" align="right"><div align="right"><strong>* Nombre:</strong></div></td>
                <td valign="top" width="190"><input name="name" size="30" type="text"  value="<?=$_POST['name']?>" class="required" /></td>
                <td valign="top" width="120" align="right"><strong>* Apellido:</strong></td>
                <td valign="top" width="260"><input name="lastname" size="30" type="text" value="<?=$_POST['lastname']?>"  class="required" /></td>
              </tr>
              <tr>
                <td valign="top"><div align="right"></div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td valign="top"><div align="right"><strong>* Email</strong>:</div></td>
                <td valign="top" >
<input name="email" id="email" size="30" type="text" class="required email" value="<?=$_POST['email']?>" ></td>
                <td align="right" valign="top" ><strong>* Telef&oacute;no M&oacute;vil</strong>:</td>
                <td valign="top" ><input name="movil" size="30" value="<?=$_POST['movil']?>"  type="text" class="required" /></td>
              </tr>
				<tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top"><div align="right"><strong>Empresa</strong>:</div></td>
                <td valign="top"><input name="company" size="30" type="text" value="<?=$_POST['company']?>"/></td>
                <td align="right" valign="top"><strong>* C.I. / R.I.F.</strong>:</td>
                <td><select size="1" name="person" id="person" style="width: 35px;" class="required">
            <option selected="selected">V</option>
            <option value="E">E</option>
            <option value="J">J</option>            
            
            </select>            <input name="person_id" id="person_id" size="24" value="<?=$person_id?>"  class="required number" type="text" />
            <br /><span class="active">
            Dejar en blanco si es persona natural</span></td>
              </tr>
<!-- <tr>
                <td colspan="4" valign="top"><br />
                Informaci&oacute;n que ser&aacute; utilizada en caso de generarse una Factura </td>
              </tr>-->
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
 <tr>
                <td valign="top"><div align="right"><strong>Direcci&oacute;n <br />
                Fiscal</strong>:</div></td>
                <td valign="top"><textarea name="address" id="address" cols="22" rows="1"><?=$_POST['address']?></textarea></td>
                <td align="right" valign="top"><strong> Tel&eacute;fono <br />
                Oficina:</strong></td>
                <td valign="top"><input name="telephone" size="30" type="text" value="<?=$_POST['telephone']?>" /></td>
              </tr>
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
 <tr>
                <td valign="top"><div align="right"><strong>* Ciudad:</strong></div></td>
                <td><input name="city" size="30" type="text" class="required" value="<?=$_POST['city']?>"/></td>
                <td align="right"><strong>* Estado:</strong></td>
                <td><input name="state" size="30" type="text" class="required" value="<?=$_POST['state']?>"/></td>
              </tr>                                          
              <tr>
                <td valign="top"><div align="right"></div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
                            <tr>
                <td valign="top"><div align="right"></div></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
                                          <tr>
                <td colspan="4" valign="top"><SPAN style="padding-left:40px; color:#039; font-weight:bold;">INFORMACION DE ACCESO</strong></td>
              </tr>
              <tr>
                <td valign="top"><div align="right"><strong>* Clave</strong>:</div></td>
                <td>
<input name="pass" id="pass" size="30" type="password" value="<?=$_POST['pass']?>"  minlength="5" class="required"></td>
                <td align="right"><strong>* Confirmar Clave</strong>:</td>
                <td><input  name="password2" id="password2" size="30" value="<?=$_POST['password2']?>" type="password" class="required {equalTo:'#pass'}"/></td>
              </tr>
              <tr>
                <td colspan="4" valign="top"><div align="right"><strong><br />
                * Campos obligatorios&nbsp;&nbsp;&nbsp; </strong></div></td>
              </tr>
              <tr>
                <td colspan="4" align="center"><input name="ac" value="send" type="hidden" /><input name="send" value="Enviar" type="submit" /></td>
              </tr>
            </tbody>
          </table>
  
</form>

<? } ?>
<br />
<br />
  </div>
</div>