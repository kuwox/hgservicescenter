<?php

class terminos extends dbtools{
	
	/**
	 * Obtiene los terminos del año fiscal dado
	 * @param $anio
	 * @return unknown_type
	 */
	function get_terminos_anio($anio,$perfil=''){
		$query = "SELECT termino_texto as contenido FROM terminos
				WHERE termino_anio='$anio' AND termino_status='1' 
				ORDER BY termino_anio DESC LIMIT 0,1 ";
		$this->data = $this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
	}
	
	/**
	 * Lista la tabla de terminos
	 * @param $order
	 * @param $min
	 * @param $max
	 * @return unknown_type
	 */
	function list_terminos($order = '', $min = '', $max = ''){
		$query="SELECT * FROM terminos WHERE 1 ";
		if (! empty ( $order )) {
			$query .= " ORDER BY $order ";
		} else {
			$query .= " ORDER BY termino_id ";
		}
		if (! empty ( $max )) {
			$query .= " LIMIT $min,$max ";
		}
		return $this->lista=$this->_SQL_tool('SELECT', __METHOD__, $query);
	}

	/**
	 * Agrega nuevos terminos
	 */
	function add_terminos($termino_anio, $termino_texto, $status){
		$query="INSERT INTO terminos (termino_anio, termino_texto, termino_status) 
			VALUES ('$termino_anio', '$termino_texto', '$status')";
		$this->newid=$this->_SQL_tool('INSERT', __METHOD__, $query);
		return $this->newid;	
	}
	
	/**
	 * Actualiza los terminos
	 */
	function update_terminos($termino_id, $termino_anio, $termino_texto, $status){
		$query="UPDATE terminos SET termino_anio='$termino_anio', termino_texto='$termino_texto', termino_status='$status' 
			WHERE termino_id='$termino_id' ";
		$this->_SQL_tool('UPDATE', __METHOD__, $query);
	}
	
	/**
	 * Obtiene los terminos por el id
	 * @param $termino_id
	 * @return unknown_type
	 */
	function get_termino_id($termino_id){
		$query="SELECT * FROM terminos WHERE termino_id='$termino_id' ";
		$this->data=$this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
	}
	
	/**
	 * Busca los ultimos terminos disponibles sin importar el año
	 * @return unknown_type
	 */
	function ultimos_terminos(){
		$query = "SELECT termino_texto as contenido FROM terminos WHERE termino_status='1' ";
		$query.=" ORDER BY termino_anio DESC LIMIT 0,1 "; 
		$this->data = $this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
	}
	
}

?>