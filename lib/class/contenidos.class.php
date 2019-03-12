<?php

class contenidos extends dbtools{
	
	function list_contenidos($order = '', $min = '', $max = ''){
		$query="SELECT * FROM contenidos WHERE 1 ";
		//$query .= " GROUP BY contenido_codigo ";
		if (! empty ( $order )) {
			$query .= " ORDER BY $order ";
		} else {
			$query .= " ORDER BY contenido_id ";
		}
		if (! empty ( $max )) {
			$query .= " LIMIT $min,$max ";
		}
		$this->contenidos=$this->_SQL_tool('SELECT', __METHOD__, $query);
	}
	
	function edit_contenido($contenido_id, $contenido_codigo, $contenido_activo, $contenido_titulo, $contenido_texto, $contenido_zona_id){
		$query="SELECT * FROM contenidos WHERE contenido_id='$contenido_id' AND contenido_zona_id='$contenido_zona_id' ";
		$res_array=$this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
		if($res_array){
			$query="UPDATE contenidos SET contenido_activo='$contenido_activo', 
				contenido_titulo='$contenido_titulo', contenido_texto='$contenido_texto' 
				WHERE contenido_id='$contenido_id' ";
			$this->_SQL_tool('UPDATE', __METHOD__, $query);		
		} else {
			$query="INSERT INTO contenidos (contenido_activo, contenido_codigo, contenido_titulo,
				contenido_texto, contenido_zona_id) VALUES ('$contenido_activo', '$contenido_codigo', 
				'$contenido_titulo', '$contenido_texto', '$contenido_zona_id') ";
			$this->_SQL_tool('INSERT', __METHOD__, $query);
		}
	}
	
	function get_contenido_codigo($contenido_codigo){
		$query="SELECT * FROM contenidos WHERE contenido_codigo='$contenido_codigo' AND contenido_activo='1' LIMIT 0,1 ";
		$this->data=$this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
	}
	
}

?>