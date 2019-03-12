<?php

class dbtools extends logs {

	var $return_id='';
	var $time='';
	var $genera_log=true;
	static  $arr_codigosLogNoRewrite=array('INSERT'=>201,'UPDATE'=>202,'DELETE'=>203);
	private $codigos=array('INSERT'=>201,'UPDATE'=>202,'DELETE'=>203);
	public static $dbDebug =array();
	public static $numberInstances=0;
	public static $DebugFileName;

	function __construct(){
		self::$numberInstances++;
		$this->setCodigosLog(array(),true);
	}

	/**
	 * Construir una consulta de insert o update con los datos de un array
	 *
	 * @param $table nombre de la tabla
	 * @param $data arreglo de campos y valores
	 * @param $action tipo de consulta a ejecutar
	 * @param $parameters filtros where de consulta update
	 * @return string query generado
	 */
	function build_query($table, $data, $action = 'insert', $parameters = ''){
		reset($data);
		if ($action == 'insert') {
			$query = 'INSERT INTO ' . $table . ' (';
			while (list($columns, ) = each($data)) {
				$query .= $columns . ', ';
			}
			$query = substr($query, 0, -2) . ') VALUES (';
			reset($data);
			while (list(, $value) = each($data)) {
				switch ((string)$value) {
					case ('now()' || 'NOW()'):
						$query .= 'now(), ';
						break;
					case ('null' || 'NULL'):
						$query .= 'null, ';
						break;
					default:
						$query .= '\''.$value.'\', ';
						break;
				}
			}
			$query = substr($query, 0, -2) . ')';
		} elseif ($action == 'update') {
			$query = 'update ' . $table . ' set ';
			while (list($columns, $value) = each($data)) {
				switch ((string)$value) {
					case ('now()' || 'NOW()'):
						$query .= $columns . ' = now(), ';
						break;
					case ('null' || 'NULL'):
						$query .= $columns .= ' = null, ';
						break;
					default:
						$query .= $columns . ' = \''.$value.'\', ';
						break;
				}
			}
			$query = substr($query, 0, -2) . ' WHERE ' . $parameters;
		}
		return $query;
	}

	/**
	 * Funcion general para hacer los queries
	 * @param $tipo
	 * @param $funct_call
	 * @param $query
	 * @param $mostrar
	 * @param $detener
	 * @return unknown_type
	 */
	function _SQL_tool($tipo, $funct_call, $query, $comentario='', $mostrar=0, $detener=0,$calcrows=1){
		dbtools::$dbDebug[] = array('file'=>$_SERVER['SELF'],'class'=>get_class($this),'method'=>$funct_call,'query'=>$query,'time'=>  $this->time);
		if($mostrar){ echo $query; }
		if($detener){ die($query); }
		$tipo=strtoupper($tipo);
		$this->return_id = '';
		$query = trim($query);

		switch($tipo){
			case 'SELECT':
				if( stripos($query,'GROUP_CONCAT') !== false ){ $this->alterar_group_concat_max_len(); }
				set_time_limit(0);
				ini_set('memory_limit',-1);
				if($calcrows){ $query = substr($query,0,6)." SQL_CALC_FOUND_ROWS ".substr($query,6); }
				$inicio = microtime();
				$result = mysql_query($query);
				$fin = microtime();
				$this->time =$fin - $inicio;
				$res_array = array();
				$i = 0;
				//Consulta general
				if ($result) {
					while($rows=mysql_fetch_assoc($result)){
						foreach($rows as $columna => $valor){
							$res_array[$i][$columna] = $valor;
						}
						$i++;
					}
						
					//Para retornar el total de registros si no existiera el limite
					$result = mysql_query('SELECT FOUND_ROWS() as total');
					if($row=mysql_fetch_assoc($result)){
						$this->total_verdadero = $row['total'];
					} else {
						$this->total_verdadero = 0;
					}
						
					return $res_array;
				} else {
					die ( "Error: ". mysql_error () . "<br /><br />Function: " . $funct_call. "<br /><br />Query -> " . $query );
				}
				break;
			case 'SELECT_SINGLE':
				if( stripos($query,'GROUP_CONCAT') !== false ){ $this->alterar_group_concat_max_len(); }
				$inicio = microtime();
				$result = mysql_query($query);
				$fin = microtime();
				$this->time =$fin - $inicio;
				$res_array=array();
				if ($result) {
					if($rows=mysql_fetch_assoc($result)){
						foreach($rows as $columna => $valor){
							$res_array[$columna] = $valor;
						}
					}
					return $res_array;
				} else {
					die ( "Error: ". mysql_error () . "<br /><br />Function: " . $funct_call. "<br /><br />Query -> " . $query );
				}
				break;
			case ('INSERT' || 'UPDATE' || 'DELETE'):
				$query_valido = $this->process_query($query,$tipo);
				if($query_valido){
					$inicio = microtime();
					$result = mysql_query($query);
					$fin = microtime();
					$this->time =$fin - $inicio;
					if($result){
						$return_value = true;
						if($tipo=='INSERT'){
							$this->return_id = mysql_insert_id();
							$return_value = $this->return_id;
						}
						$codigo=$this->codigos[$tipo];
						if($this->genera_log){ $this->set_log_consulta($query, $codigo, $comentario); }
						$this->setCodigosLog(array(),true);
						return $return_value;
					} else {
						die ( "Error: ". mysql_error () . "<br /><br />Function: " . $funct_call. "<br /><br />Query -> " . nl2br($query) );
					}
				} else {
					die("Sentencia no corresponde con el primer parametro de la funcion _SQL_tool. Debe ser corregido para continuar");
				}
				break;
		}
		$this->setCodigosLog(array(),true);
	}

	private function alterar_group_concat_max_len(){
		//Hay que quitar el limite de la funcion para poder mostrar todos los posibles valores
		$prequery="SET @@group_concat_max_len = 9999999";
		mysql_query($prequery);
	}

	protected function setCodigosLog($arrValues=array(),$autoSet=false){
		if($autoSet){
			$this->codigos=dbtools::$arr_codigosLogNoRewrite;
		}else{
			$this->codigos=array_merge($this->codigos,$arrValues);
		}
	}

	function __destruct(){
		self::$numberInstances--;
	}

}

?>