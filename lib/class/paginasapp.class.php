<?php

class paginasapp extends dbtools{
	
	var $menu_links = array();
	
	function data_paginaapp($pagina){
		global $objlang;
		
		$path_parts = pathinfo($pagina);
		$directorio = substr($path_parts['dirname'], (strripos($path_parts['dirname'],"/")+1) );
		$pagina_url = $directorio."/".$path_parts['basename'];
		$query="SELECT * FROM paginas_app WHERE pagina_url='$pagina_url' ";
		$this->viendo = $this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
		if(!$this->viendo){
			echo '<p align="center"><span class="errormsg"><strong>'
				.$objlang->txt['txt_undefined_code_page']
				.'</strong></span></p>' ;
			die();
		}		
	}
	
	function get_paginas_menu(){
		$query="SELECT * FROM paginas_app WHERE pagina_en_menu='1' ";
		$res_array = $this->_SQL_tool('SELECT', __METHOD__, $query);	
		for($i=0, $cant=count($res_array); $i<$cant; $i++){
			$url = $res_array[$i]['pagina_url'];
			$this->menu_links[$url] = array(
											'codigo'=>$res_array[$i]['pagina_codigo'] ,
											'padre'=>$res_array[$i]['pagina_codigo_padre'] ,
											);	
		}
	}
	
}

?>