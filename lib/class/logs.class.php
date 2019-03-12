<?php

/**
 * Classe para registrar logs
 * 
 * @author Domingo Oropeza <dioh_@hotmail.com>
 * @version 1.5 2010/04/25
 *
 */

class logs{
	
	private $saltodelinea = array ("\t","\n","\r","\0","\x0B");
	private $codigos = array();
	private $log_usuario_id='';
	private $log_usuario_info='';
	private $log_usuario_email='';
	private $log_usuario_compania='';
	private $log_navegador='';
	private $data_old='No data';
	private $data_new='No data';
	private $table_name='No data';
	
	/**
	 * Funcion constructora, obtiene los codigos de los logs
	 * @return unknown_type
	 */
	function __construct(){
		$query="SELECT * FROM log_codigos";
		$res=mysql_query($query) or die("Error: ".mysql_error()."<br /><br />Function: ".__METHOD__."<br /><br />Query: ".$query);
		$res_array=array();
		while ( $row = mysql_fetch_array ( $res ) ) {
			foreach ( $row as $key => $value ) {
				$res_array[$row['log_codigo_id']][$key] = $value;
			}
		}
		$this->codigos=$res_array;
	}
	
	/**
	 * Desglosa el query segun su funcionabilidad para almacenar los datos en el log
	 * @param $query
	 * @param $tipo
	 * @return unknown_type
	 */
	function process_query($query, $tipo){
		$query = trim( str_ireplace($this->saltodelinea, " ", $query) );		
		$tipo = strtoupper($tipo);
		$this->data_old = 'No data'; 
		$this->data_new = 'No data';
		$this->table_name = '';
		$var_data_old = '';
		$var_data_new = '';
		$i=0;
			
		if($tipo=='INSERT'){
			/**
			 * http://dev.mysql.com/doc/refman/5.0/en/insert.html
			 * El query en verdad es un insert?
			 */
			if (preg_match('/^(?i:INSERT\s*INTO)\s*([^(]*)\(\s*([^)]*)\)\s*(.+)/', $query, $regs)) {
				//Obtengo las tablas a actualizar 
				$tablas_string = trim($regs[1]);
				//die($tablas_string);
				
				//Obtengo la cadena de campos
				$campos = trim($regs[2]);
				$arr_campos = explode( ",", $campos);
				//die($campos);
				
				//Obtengo la cadena de valores
				$var_string= trim($regs[3]);
				//die($var_string);
				
				if (!preg_match('/^(?i:SELECT)/', $var_string, $subqry)) {
					//Insert simple
					preg_match('/.+\((.*)\)/', $var_string, $vals);
					$valores = trim( $vals[1] );
					//die($valores);
					$arr_valores = explode(",",$valores);
					if( count($arr_campos) != count($arr_valores) ){
						/**
						 * TODO hacer el arreglo de la cadena cuando la cantidad de valores y columnas no coincide
						 */
					} 
					foreach($arr_campos as $key => $value){
						$var_data_new .= trim($value)." = ".$arr_valores[$key]."<br />";							
					}
					
				} else {
					/**
					 * Es un INSERT ... SELECT Syntax
					 * http://dev.mysql.com/doc/refman/5.0/en/insert-select.html
					 */ 
					$res=mysql_query($var_string) or die("Error: ".mysql_error()."<br /><br />Function: ".__METHOD__."<br /><br />Query: ".$var_string);
					$cant_data=mysql_num_rows($res);
					if($cant_data<>0){
						while($row=mysql_fetch_row($res) ){
							$var_data_new .= "Register No.".$i."<br />";	
							foreach($row as $key => $value){
								if(is_numeric($key)){ //Hay que usar los indices numericos
									$var_data_new .= trim($arr_campos[$key])." = ".$value."<br />";
								}
							}
							$i++;
						}
					}
				}				
				
				$this->data_new = $var_data_new;
				$this->table_name = trim($tablas_string);
				
				return 1;
			}
		}
		
		if($tipo=='UPDATE'){
			/**
			 * http://dev.mysql.com/doc/refman/5.0/en/update.html
			 * El query en verdad es un update?
			 */
			if (preg_match('/^(?i:UPDATE)\s*(.+)\s*(?i:SET)\s*(.+)\s*(?i:WHERE)\s*(.+)/', $query, $regs)) {
				//Obtengo las tablas a actualizar 
				$tablas_string = trim( $regs[1] );
				//die($tablas_string);
				
				//Obtengo la cadena de campos y valores
				$campos = trim( $regs[2] );
				//die($campos);
				
				//Obtengo la cadena del where
				$where_string = trim( $regs[3] );
				//die($where_string);
				
				//Pico la cadena de campos para obtener los nombres reales
				$es_primero = true;
				$split_campos=explode(",",$campos);
				//print_r($split_campos);
				foreach($split_campos as $indice => $valor){
					//Si existe en la cadena un "=" quizas sea un campo
					if(strpos($valor, "=")!==false){
						$campo=trim( substr($valor, 0,  strpos($valor, "=") ) );
						//Si no se encuentran espacios en el nombre del campo entonces es valido
						if(strpos($campo, " ")===false){
							$campos_string .= $separador.$campo;
							if($es_primero){
								$separador=", ";
								$es_primero = false;
							}
						}
					}
				}
				
				//Obtenemos los valores viejos antes del cambio
				$this->get_old_data($campos_string,$tablas_string,$where_string);
				
				$this->data_new = $campos;
				$this->table_name = trim($tablas_string);
				
				return 1;
			}
		}
		
		if($tipo=='DELETE'){
			/**
			 * http://dev.mysql.com/doc/refman/5.0/en/delete.html
			 * El query en verdad es un delete?
			 */
			if (preg_match('/^(?i:DELETE\s*FROM)\s*(.+)\s*(?i:WHERE)\s*(.+)/', $query, $regs)) {
				/**
				 * Se extrae la parte de la sentencia para realizar una busqueda del registro 
				 * antes de borrarlo y poder buscar los valores para mostrar en el texto del log
				 */	
				//Obtengo las tablas a actualizar 
				$tablas_string = trim($regs[1]);
				//die($tablas_string);
				
				//Obtengo la cadena del where
				$where_string = trim($regs[2]);
				//die($where_string);
				
				if(stripos($tablas_string, ",")!==false){
					//Delete en multiples tablas
					$var_campo=''; $var_tabla='';
					$tablas_array = explode(",", $tablas_string);
					foreach($tablas_array as $tabla){
						$var_campo .= $tabla.'.*, ';
						$var_tabla .=  $tabla.', ';
					}
					$var_campo = substr($var_campo,0,-2);
					$var_tabla = substr($var_tabla,0,-2);
				} else {
					//Delete simple
					$var_campo = '*';
					$var_tabla = $tablas_string;
				}
				//die($var_campo);

				//Obtenemos los valores viejos antes del cambio
				$this->get_old_data($var_campo, $var_tabla, $where_string);

				$this->table_name = trim($var_tabla);
				
				return 1;
			}
			
		}
		return 0;		
	}
	
	/**
	 * Obtiene los datos viejos antes de un cambio
	 * @param string $campos campos a usar
	 * @param string $tablas tablas a usar
	 * @param string $sentencia sentencia del where
	 */
	function get_old_data($campos,$tablas,$sentencia){
		$i=0; $var_data_old='';
		$query="SELECT ".$campos." FROM ".$tablas." WHERE ".$sentencia;
		//die($query);
		$res=mysql_query($query) or die("Error: ".mysql_error()."<br /><br />Function: ".__METHOD__."<br /><br />Query: ".$query);
		$cant_data=mysql_num_rows($res);
		if($cant_data<>0){
			while($row=mysql_fetch_array($res) ){
				$var_data_old .= "Register No.".$i."<br />";	
				foreach($row as $key => $value){
					if(!is_numeric($key)){ //Hay que obiar los indices numericos
						$var_data_old .= $key." = ".$value."<br />";
					}
				}
				$i++;					
			}
			$var_data_old = substr($var_data_old, 0, -6);
		} else {
			$var_data_old = 'No data';
		}		
		$this->data_old = $var_data_old;
	}
	
	/**
	 * Obtiene los datos de un usuario para ser guardados en el log
	 * @return unknown_type
	 */
	private function get_userinfo_log(){
		$this->log_usuario_info = ($_SESSION['s_usuario_nombre'] || $_SESSION['s_usuario_apellido'])? $_SESSION['s_usuario_nombre']." ".$_SESSION['s_usuario_apellido'] : 'N/A';
		$this->log_usuario_id = ($_SESSION['s_usuario_id'])? (int)$_SESSION['s_usuario_id'] : 0;
		$this->log_usuario_email = ($_SESSION['s_usuario_email'])? $_SESSION['s_usuario_email'] : 'N/A';
		$this->log_usuario_compania = ($_SESSION['s_compania_nombre'])? $_SESSION['s_compania_nombre'] : 'N/A';
		
	}
	
	/**
	 * Inserta el log en la bd
	 * @param $query_log
	 * @param $log_codigo_id
	 * @param $comentario
	 * @return unknown_type
	 */
	function set_log_consulta($query_log, $log_codigo_id,$comentario=''){
		//Para detectar el navegador
		require('browser_detection/your_computer_info.php');		
		$this->log_navegador=$html;	
		//Para detectar el navegador

		$this->get_userinfo_log();
		$query_log = mysql_real_escape_string( str_ireplace($this->saltodelinea, " ", $query_log) );
		$comentario = mysql_real_escape_string($comentario);
		$query="INSERT INTO log_consultas 
			(en_fecha, log_codigo_id, usuario_id, usuario_info, usuario_email, usuario_compania, session_id, 
			direccion_ip, navegador, en_tablas, data_vieja, data_nueva, sentencia_sql, comentario) 
			VALUES 
			( NOW(), '$log_codigo_id', '".$this->log_usuario_id."', '".mysql_real_escape_string($this->log_usuario_info)."', 
			'".$this->log_usuario_email."', '".mysql_real_escape_string($this->log_usuario_compania)."', '".session_id()."', 
			'".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string($this->log_navegador)."', 
			'".$this->table_name."', '".mysql_real_escape_string($this->data_old)."', 
			'".mysql_real_escape_string($this->data_new)."', '".$query_log."', '$comentario' )";
		//die($query);
		$res=mysql_query($query) or die("Error: ".mysql_error()."<br /><br />Function: ".__METHOD__."<br /><br />Query: ".$query);
	}
	
	/**
	 * Lista los logs del sistema
	 * @param $start_date
	 * @param $end_date
	 * @param $compania
	 * @param $usuario
	 * @param $event
	 * @param $order
	 * @param $min
	 * @param $max
	 * @return unknown_type
	 */
	function list_consultas($start_date,$end_date,$usuario,$event,$order = '', $min = '', $max = ''){
		$query="SELECT cons.*,cod.* FROM log_consultas AS cons, log_codigos AS cod 
			WHERE cons.log_codigo_id=cod.log_codigo_id ";
		if($start_date){ 
			$query.=" AND cons.en_fecha >= '$start_date 00:00:01' "; 
		}
		if($end_date){ 
			$query.=" AND cons.en_fecha <= '$end_date 23:59:59' "; 
		}
		if($usuario){ $query.=" AND cons.usuario_info='$usuario' "; }
		if($event){ $query.=" AND cod.log_codigo_id='$event' "; }
		if (! empty ( $order )) {
			$query .= " ORDER BY $order ";
		} else {
			$query .= " ORDER BY en_fecha DESC ";
		}
		if (! empty ( $max )) {
			$query .= " LIMIT $min,$max ";
		}
		$this->lista = dbtools::_SQL_tool('SELECT',__METHOD__,$query);
	}
	
	/**
	 * Obtiene un log por su id
	 * @param $log_id
	 * @return unknown_type
	 */
	function get_log_id($log_id){
		$query="SELECT cons.*,cod.* FROM log_consultas AS cons, log_codigos AS cod 
			WHERE cons.log_codigo_id=cod.log_codigo_id AND cons.log_id='$log_id' ";
		$this->data = dbtools::_SQL_tool('SELECT_SINGLE',__METHOD__,$query);
	}
	
	protected function setLogdataNew($arrNew){
		$this->data_new=$this->getFormatedDataLog($arrNew);
	}
	
	protected function getFormatedDataLog($arrNew){
		$strReturn="";
		if(is_array($arrNew)){
			$i=0;
			foreach($arrNew as $index=>$array){
				if($i>=1){$strReturn.="<br />";}
				foreach($array as $name=>$val){
					$strReturn.=$name."='".$val."'<br />";
				}
				$i++;
			}
		}
		return $strReturn;
	}
	protected function setLogTable($tableName){
		$this->table_name=$tableName;
	}
}

?>