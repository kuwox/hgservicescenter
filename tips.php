<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


if ($_REQUEST['ac']=="upload" and $_SESSION['user_type']==3){ 

	$img = $_FILES['foto_upload'];
	//die($img);

	$image_name = $img['name'];
	//die('='.$image_name);
	$output_filename=$_SERVER['DOCUMENT_ROOT']."/upload_files/doc/".$image_name;
	//$output_filename="D:/web/vigoimagenes/upload_files/doc/".$image_name;

	// Carga el archivo 
	if (move_uploaded_file($img['tmp_name'], $output_filename)) {
		$msj = "El archivo ha sido guardado exitosamente. ";
	} else {
		$msj = "";
	}
//die('dd'	);
?><script language="javascript">window.location="?option=tips";</script><?		
}

if ($_REQUEST['ac']=="del") {
	//die($_REQUEST['files_name']);
	  unlink($_REQUEST['files_name']);
	?><script language="javascript">window.location="?option=tips";</script><?		
}



$title_page="Imagenologia";
$img_header="teaser-main.jpg";

include("includes/header.php");
?>
<script language="javascript">
function del(filename){
	var res=confirm("Esta seguro de eliminar el documento?");
	if(res==true){
		window.location="?option=tips&ac=del&files_name="+filename;
	}
}
</script>
<link href="css/styles.css" rel="stylesheet" type="text/css" />



      <div id="content">
        <h1><strong>Informaci&oacute;n Util</strong></h1>

        
        <br />
        <? if ($_SESSION['user_type']==3) { ?>
        <p>   
        <form name="form" id="form" method="post" action="?option=tips&ac=upload" enctype="multipart/form-data">
          <p>Subir Nuevo Documento:
          <input name="foto_upload" type="file" id="logo_upload"/>  <input type="submit" name="Subir" value="Subir" />
          </p>
            
          </p>
          <p><em><strong>Recomendado subir archivos .pdf </strong></em></p>
        </form>
        <? } ?>
        
		<ul>
		<?       
      // Incluir la clase    
      include_once('class/galeria.class.php'); 
       
      $mygallery = new gallery(); // Crear una nueva instancia 
      $mygallery->loadFolder('upload_files/doc'); // Leer las imágenes de la carpeta  
      //$mygallery->show(500, 100); // Mostrar la galería en este lugar en un area de 500px       
	  
	  $total = count($mygallery->files); 
      $cont = 0; 

      if ($total==0) {
		  echo ("Informaci&oacute;n no disponible");
	  } else {
		  for($i = 0; $i < $total; $i++){    
			$arr = explode('.', $mygallery->files[$i]);
		  ?>    
				   <li> 
				   <a href="<?=$mygallery->path.'/'.$mygallery->files[$i]?>" target="_blank">
				   <?=$arr[0]?> 
				   </a> 
				   <? if ($_SESSION['user_type']==3) { ?>
				   <a href="javascript:del('<?=$mygallery->path.'/'.$mygallery->files[$i]?>')"><img src="images/del_act.gif" width="19" height="19" />  </a> 
				   <? } ?>
					</li> 
	
				 <?
			 } 
	  }
		?>
        </ul>
        <p>&nbsp;</p>
      </div>
      



