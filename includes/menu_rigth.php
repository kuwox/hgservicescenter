<div id="right"><br><br>
    <div>
    <p align="center">
    <a href="?option=cita" target="_self"><!--onClick="window.open(this.href, this.target, 'width=415,height=475,atributo=NO,Left=300,top=150'); return false;"--><img src="images/cita.png" alt="Pida su Cita" title="Pida su Cita"  border="0"/>
    </a><br /><a href="?option=afiliacion" target="_self"><img src="images/empresas.png" alt="Afiliese y obtenga beneficios" title="Afiliese y obtenga beneficios" width="150" height="66" border="0">
    </a><br>
    <a href="?option=horarios" target="_self"><img src="images/horario-atencion.png" alt="Horario y Centros de Atencion" width="150" height="66" border="0" title="Horario y Centros de Atencion">
    </a><br>
    <a href="http://forum.vigoimagenes.com" target="_blank"><img src="images/forum.png" alt="Forum" width="150" height="66" border="0" title="Forum" />
    </a>
    <!--<br>
    <img src="images/convenios.gif" width="140" height="49"><br>-->
    <br>
    <br>
    </p>
    <h2>Ultimos Temas</h2>
    <?
	//buscamos temas
	$forum = new forum();
	$arrforum = $forum->get_post();

	if (empty($arrforum)) {	?>
		<ul class="menu">
        <li>No hay temas nuevos</li>
    	</ul>
	<?
	}
	
	$total = count($arrforum);
	//die('.'.$total);
	$i=1;
	while ($i < 3 and $i < $total) {
		
		$forum_id = $arrforum[$i]['post_id'];
		$post_subject = htmlentities($arrforum[$i]['post_subject']);
		$i++;
		?>
        <p class="button"><a href="http://forum.vigoimagenes.com/viewtopic.php?t=<?=$forum_id?>" target="_blank" title="<?=$post_subject?>"><?=$post_subject?></a></p>
        <?
	}
	?>
    <!--<ul class="menu">
        <li><a
    href="?option=tips&id=1">Como prepararse para un eco abdominal</a>
     </li>
    </ul>-->
    <div class="slogan"></div>
    
    <!-- by Texy2! -->
    </div>
</div>
<!-- End Right  -->
