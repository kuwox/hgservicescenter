<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<? if ($_REQUEST['ac']=="send") {
	
		// multiple recipients
		//$to .= ', ' . 'wez@example.com';
		
		// subject
		$subject = 'Informacion Vigo Imagenes';
		
		// message
		$message = '
		<html>
		<body>
		  <p>Solicitud de Información:</p>
		  <table>
			<tr>
			  <td>Nombre:</td>
			  <td>'.$_REQUEST['name'].'</td>
			</tr>
			<tr>
			  <td>Apellido:</td>
			  <td>'.$_REQUEST['lastname'].'</td>
			</tr>
			<tr>
			  <td>email:</td>
			  <td>'.$_REQUEST['email'].'</td>
			</tr>
			<tr>
			  <td>Telefono:</td>
			  <td>'.$_REQUEST['telephone'].'</td>
			</tr>
			<tr>
			  <td>Compañía:</td>
			  <td>'.$_REQUEST['company'].'</td>
			</tr>
			<tr>
			  <td>Tipo de Información:</td>
			  <td>'.$_REQUEST['type'].'</td>
			</tr>	
			<tr>
			  <td>&nbsp;</td>
			  <td></td>
			</tr>			
			<tr>
			  <td>Comentarios o Dudas:</td>
			  <td>'.$_REQUEST['comments'].'</td>
			</tr>								
		  </table>
		</body>
		</html>
		';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		$headers .= 'To: <'.$email_master.'>' . "\r\n";
		$headers .= 'From: Vigo Imagenes <info@vigoimagenes.com>' . "\r\n";
	
	
		// Mail it
		mail($email_master, $subject, $message, $headers);	
		
		// Mail Copy
		mail($email_copy, $subject, $message, $headers);
		
		?><script language="javascript">window.location="?option=contact&op=send&ac=0";</script><?
		exit;
	}


$title_page="Contactos";
$img_header="teaser-main.jpg";

include("includes/header.php");
?>




      <div id="content">
        <h1>Contacto</h1>

      
      <? if ($_REQUEST['op']=="send") { ?>

	<p>Su informaci&oacute;n ha sido enviada satisfactoriamente !!! </p>
        <p>En pocas horas estaremos atendiendo su solicitud. </p>
        <p>Gracias por cont&aacute;ctarnos. </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    <? } else { ?>

      <p>Para contact&aacute;rnos, por favor complete el formulario que se   presenta a continuaci&oacute;n:<br />
      </p>
      <div id="msj_error"></div>
       <form id="form1" name="form1" method="post" action="?option=contact&ac=send" >
          <table cellpadding="0" cellspacing="5">
            <tbody>
              <tr>
                <td valign="top" width="160"><div align="right">* Nombre:</div></td>
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
                <td><input name="company" size="30" title="Empresa" type="text" /></td>
              </tr>
              <tr>
                <td valign="top"><div align="right">* Consulta:</div></td>
                <td><select name="type" id="type" size="1" title="Consulta" class="validate is_req">
                  <option selected="selected" value="">- Seleccionar -</option>
                  <option value="Dudas o Preguntas">Dudas o Preguntas</option>
                  <option value="Solicitar Presupuesto">Solicitar Presupuesto</option>
                  <option value="Solicitar Servicios de Afiliacion">Solicitar Servicios de Afiliacion</option>
                  <option value="Otro">Otro</option>
                </select></td>
              </tr>
              <tr valign="top">
                <td valign="top"><div align="right">* Comentarios:</div></td>
                <td ><textarea name="comments" id="comments" title="Comentarios" cols="40" rows="2" class="validate is_req" ></textarea></td> 
              </tr>
              <tr>
                <td valign="top"><div align="right"></div></td>
                <td align="left">* Campos obligatorios</td>
              </tr>
     
              <tr>
                <td valign="top"><div align="right"></div></td>
                <td  align="center"><input type="button" value="Enviar" id="send" name="send" onclick="validateForm()"><!--<input name="send" value="Enviar" type="submit" />--></td>
              </tr>
            </tbody>
          </table>
        </form>

      <? } ?>
  </div>
<? include("includes/menu_rigth.php"); ?>