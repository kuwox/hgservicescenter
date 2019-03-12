<?php
/**
 * Clase para buscar las constantes y parametros de configuracion para la aplicacion
 * @author doropeza
 *
 */
class parametros extends dbtools {
	
	/**
	 * Funcion constructora que define las constantes en la aplicacion
	 * @return unknown_type
	 */
	function __construct(){
		$query="SELECT * FROM parametros";
		$res_array=$this->_SQL_tool('SELECT', __METHOD__, $query);
		for($i=0, $cant=count($res_array); $i<$cant; $i++){
			define($res_array[$i]['parametro_key'], $res_array[$i]['parametro_value']);
		}
	}
	
	/**
	 * Lista los parametros de la bd
	 * @param $mostrar
	 * @return unknown_type
	 */
	function list_parametros($mostrar=1){
		$query="SELECT * FROM parametros WHERE 1 ";
		if(!is_null($mostrar)){ $query.=" AND parametro_mostrar='$mostrar' "; }
		$this->lista=$this->_SQL_tool('SELECT', __METHOD__, $query);
	}
	
	/**
	 * Actualiza los valores de un parametro
	 * @param $parametro_id
	 * @param $parametro_value
	 * @return unknown_type
	 */
	function update_parametro($parametro_id,$parametro_value){
		$query="UPDATE parametros SET parametro_value='$parametro_value' WHERE 
			parametro_id='$parametro_id' ";
		$this->_SQL_tool('UPDATE', __METHOD__, $query);	
	}
	
	/**
	 * Obtiene un parametro por su id
	 * @param $parametro_id
	 * @return unknown_type
	 */
	function get_parametro_id($parametro_id){
		$query="SELECT * FROM parametros WHERE parametro_id='$parametro_id' ";
		$this->data=$this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
	}
	

}
?>