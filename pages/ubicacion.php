<?php
require_once('../lib/core.lib.php');
include("../includes/header.php");
?>

<link rel="stylesheet" href="../css/modal-message.css" type="text/css">
<script type="text/javascript" src="../lib/js/ajax.js"></script>
<script type="text/javascript" src="../lib/js/modal-message.js"></script>
<script type="text/javascript" src="../lib/js/ajax-dynamic-content.js"></script>


<div id="content">


 <h1><strong>UBICACION</strong></h1>
 <table width="74%" border="0" cellpadding="0" cellspacing="6">
   <tr>
     <td width="352" height="295" align="center" valign="top"><p><br />
      <img src="../images/ubicacion.png" width="352" height="263" alt="ubicacion" /></p>
      <p><a href="#" onclick="displayMessage('ubicacion-geo.php'); return false" class="link">Ver Video de Ubicaci&oacute;n</a></p></td>
	    <td width="407" valign="top"><p>&nbsp;</p>
	      <p>Estamos ubicados en el<br />
	      Aeropuerto Internacional Arturo 
	      Michelena Sector Aeroclub Hangar 77.<br />
	      Valencia. Edo.  Carabobo</p>
          <p><strong>Tel&eacute;fonos</strong>:<br />
  &nbsp;+58-241-8144879<br />
  &nbsp;+58-414-4477311<br />
  &nbsp;+58-424-4158901<br />
  &nbsp;+58-424-4158904<br />
  <p><a href="../images/Certif_OMA_HG_405.pdf">Descargar Certificado OMAC</a></p>
          <p>&nbsp;</p>
        <p><img src="../images/email.png" alt="email" width="43" height="49" hspace="2" vspace="2" border="0" align="middle" /><strong>Email</strong>: <a href="mailto:hgservicescenter@gmail.com">hgservicescenter.admon@gmail.com</a></p></td>
      </tr>
 </table>
</div>



<script type="text/javascript">
messageObj = new DHTML_modalMessage();	// We only create one object of this class
messageObj.setShadowOffset(5);	// Large shadow


function displayMessage(url)
{
	
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(500,450);
	messageObj.setShadowDivVisible(true);	// Enable shadow for these boxes
	messageObj.display();
}


function closeMessage()
{
	messageObj.close();	
}


</script>      
      <?
include("../includes/footer.php");
?>
