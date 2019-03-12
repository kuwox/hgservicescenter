<?php
/**
 * Clase general de funciones mas utilizadas o utiles
 * 
 * @author Domingo Oropeza <dioh_@hotmail.com>
 * @version v1.0 2008/02/08
 */
class general{
 
	/**
	 * Cambia un formato sql a una fecha normal o la divide en un arreglo
	 *
	 * @param string $fecha cadena de fecha con formato sql (yyyy-mm-dd hh:mm:ss)
	 * @param boolean $inarray indica si retornar el resultado en un arreglo o no
	 * @param string $lang formato de la fecha segun el lenguaje
	 * @param string $sep caracter separador de numeros con el que se imprime la fecha
	 * @return mixed retorna la fecha o un arreglo segun el valor del segundo parametro de la funcion 
	 */
	function date_sql_screen($fecha,$inarray=false,$lang="es",$sep="/",$short=0){
		$fechanor="";
		preg_match("/([0-9]{2,4})[\/\-\.]([0-9]{1,2})[\/\-\.]([0-9]{1,2})/", $fecha, $frev);
		if ($short==1) $year = 'y'; else $year = 'Y';
		if($frev){	
			if($inarray){ return $frev; }
			if($lang=="en"){
				$fechanor=date("m".$sep."d".$sep.$year,mktime(0,0,0,$frev[2],$frev[3],$frev[1]));
			} else {
				$fechanor=date("d".$sep."m".$sep.$year,mktime(0,0,0,$frev[2],$frev[3],$frev[1]));
			}
		}
		return $fechanor;
	}
	
	/**
	 * Cambia el formato sql de una fecha con hora a formato humano o la divide en un arreglo
	 *
	 * @param string $fecha cadena de fecha con formato sql (yyyy-mm-dd hh:mm:ss) 
	 * @param boolean $inarray indica si retornar el resultado en un arreglo o no
	 * @param string $lang formato de la fecha segun el lenguaje
	 * @param string $sep caracter separador de numeros con el que se imprime la fecha
	 * @param integer $format formato de la hora a mostrar, 12 o 24 horas
	 * @return mixed retorna la fecha o un arreglo segun el valor del segundo parametro de la funcion
	 */
	function fechahora_sql_normal($fecha,$inarray=false,$lang="es",$sep="/",$format=12){
		$fechanor=""; $fh="H"; $ap="";
		preg_match("/([0-9]{2,4})[\/\-\.]([0-9]{1,2})[\/\-\.]([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2})/", $fecha, $frev);
		if($frev){	
			if($inarray){ return $frev; }
			if($format!=24){
				$fh="h"; $ap="a";
			} 
			if($lang=="en"){
				$fechanor=date("m".$sep."d".$sep."Y ".$fh.":i ".$ap,mktime($frev[4],$frev[5],0,$frev[2],$frev[3],$frev[1]));
			} else {
				$fechanor=date("d".$sep."m".$sep."Y ".$fh.":i ".$ap,mktime($frev[4],$frev[5],0,$frev[2],$frev[3],$frev[1]));
			}
			$fechanor=trim($fechanor);			
		}
		return $fechanor;
	}
	
	/**
	 * Cambia el formato de una hora
	 *
	 * @param string $hora cadena de la hora (hh:mm:ss) 
	 * @param boolean $inarray indica si retornar el resultado en un arreglo o no
	 * @param integer $format formato de la hora a mostrar, 12 o 24 horas
	 * @return mixed retorna la hora o un arreglo segun el valor del segundo parametro de la funcion
	 */
	function hora_sql_normal($hora,$inarray=false,$format=12){
		$horanor="";
		preg_match("/([0-9]{1,2}):([0-9]{1,2})/", $hora, $hrev);
		if($hrev){	
			if($inarray){ return $hrev; }
			if($format!=24){
				$horanor=date("h:i a",mktime($hrev[1],$hrev[2]));
			} else {
				$horanor=date("H:i",mktime($hrev[1],$hrev[2]));
			}
		}
		return $horanor;
	}

	/**
	 * Da el formato de una fecha a el formato sql (yyyy-mm-dd)
	 *
	 * @param string $fecha cadena con la fecha a dar formato
	 * @param string $lang formato de lenguaje de la fecha de origien (dd-mm-yyyy o mm-dd-yyyy)
	 * @param string $sep cadena utilizada como separador de nuemeros de la fecha original
	 * @return string
	 */
	function fecha_normal_sql($fecha,$lang="es"){
		$fechasql="";
		preg_match("/([0-9]{1,2})[\/\-\.]([0-9]{1,2})[\/\-\.]([0-9]{2,4})/", $fecha, $frev);
		if($frev){
			if($lang=="en"){
				$fechasql=date("Y-m-d",mktime(0,0,0,$frev[1],$frev[2],$frev[3]));
			} else {
				$fechasql=date("Y-m-d",mktime(0,0,0,$frev[2],$frev[1],$frev[3]));
			}
		}
		return $fechasql;
	}
	
	/**
	 * Da el formato de una fecha hora a el formato sql (yyyy-mm-dd hh:mm:ss)
	 *
	 * @param string $fecha cadena con la fecha y hora a dar formato (dd-mm-yyyy hh:mm:ss [am/pm])
	 * @param string $lang formato de lenguaje de la fecha de origien (dd-mm-yyyy o mm-dd-yyyy)
	 * @param string $sep cadena utilizada como separador de nuemeros de la fecha original
	 * @return string
	 */
	function fechahora_normal_sql($fecha,$lang="es"){
		$fsql=""; $hsql="";
		$farray=explode(" ",trim($fecha));

		preg_match("/([0-9]{1,2})[\/\-\.]([0-9]{1,2})[\/\-\.]([0-9]{2,4})/", $farray[0], $frev);
		if($frev){
			if($lang=="en"){
				$fsql=date("Y-m-d",mktime(0,0,0,$frev[1],$frev[2],$frev[3]));
			} else {
				$fsql=date("Y-m-d",mktime(0,0,0,$frev[2],$frev[1],$frev[3]));
			}
		}
		
		preg_match("/([0-9]{1,2}):([0-9]{1,2})/", $farray[1], $frev);
		if($frev){
			if($farray[2]){
				$chars=array(" ",".");
				$farray[2]=strtolower(str_replace($chars,"",$farray[2]));
				if($farray[2]=="pm" && $frev[1]<=12){ $frev[1]+=12; }
			}
			$hsql=date("H:i:s",mktime($frev[1],$frev[2],0));
		}
		
		$fechasql=trim($fsql." ".$hsql);
		return $fechasql;
	}
	
	/**
	 * Por defecto calcula el numero de dias entre dos fechas o la fecha actual si 
	 * no se define el segundo parametro, el tercer y cuarto parametro hacen un 
	 * calculo segun los valores dados y retorna la fecha obtenida 
	 * 
	 * Las fechas ingresadas debe tener un formato GNU valudo como el formato SQL, 
	 * para mas detalles puede verse el manual de la funcion strtotime de php en
	 * http://www.php.net/manual/es/function.strtotime.php o en el manual GNU 
	 * http://www.gnu.org/software/tar/manual/html_node/tar_113.html para saber
	 * otras fechas validas para esta funcion
	 *
	 * @param string $fechalow fecha de inicio a comparar
	 * @param string $fechahigh fecha final a comparar
	 * @param integer $diff numero de diferencia a calcular
	 * @param string $mod factor de calculo, por defecto en dias
	 * @return integer|string retorna el numero de dias de difrencia, devuelte la fecha calculada
	 */
	function timebtwdates($fechalow,$fechahigh='',$diff='',$mod="Dias"){
		switch($mod){
			case "Segundos":
				$factor = 1;
			break;
			case "Minutos":
				$factor = 60;
			break;
			case "Horas":
				$factor = 3600;
			break;
			case "Dias":
				$factor = 86400;
			break;
		}
		$regDate=strtotime($fechalow);
		if(empty($diff)){
			if(!empty($fechahigh)){ 
				$curDate=strtotime($fechahigh);
			} else {
				$curDate=mktime();
			}
			$tiempo = $curDate - $regDate;
			$tiempo = $tiempo / $factor;
		} else {
			$diff = $diff * $factor;
			$todate = $diff + $regDate;
			$tiempo = date("Y-m-d",$todate);		
		}
		return $tiempo;
	}

	/**
	 * Evalua una expresion para retornar uno de los dos valores dados
	 *
	 * @param mixed $expresion expresion a evaluar
	 * @param mixed $returntrue valor a retornar si es verdadero
	 * @param mixed $returnfalse valor a retornar si es false
	 * @return mixed
	 */
	function ifelse($expresion,$returntrue,$returnfalse=""){
		if(!$expresion){
			return $returnfalse;
		} else {
			return $returntrue;
		}
	}
	
	/**
	 * Generar un password aleatorio
	 *
	 * @param integer $passlen logintud de caracteres del password
	 * @param string $chars lista de caracteres a utilizar
	 * @return string password obtenido sin encriptar
	 */
	function randompass($passlen=15,$chars=""){
	    $chars = trim($chars);
		if(empty($chars)) $chars = "aAb0BcCdD1eEfF2gGh3HiIjJ4kKl5Lm6MnNo7OpPqQrR6sStTuUvV9wWxXyYzZ";
		$charlen = strlen($chars);
		for($i=0;$i<$passlen;$i++){
			mt_srand(date("s", time() + $i * 4567));
			$password .= substr($chars,mt_rand(1,$charlen),1);
		}
		return $password;
	}
	
	
	
	/**
	 * Obtiene el valor de un campo en una tabla en base a la cadena encriptada.
	 * 
	 * El valor del campo a consultar no debe estar encriptado obligatoriamente, 
	 * esta funcione es solo un metodo de seguridad para usar cadenas encriptadas 
	 * en los url de php en vez de usar campos importantes como un id unico a 
	 * ocultar. El metodo sha1 es mas potente que el md5 por eso se usa por defecto
	 * 
	 * El PHP y MySQL deben generar las mismas cadenas encriptadas para poder 
	 * obtener el valor real del campo, los metodos de cifrado de PHP se pueden 
	 * revisar en este link http://ve.php.net/manual/es/ref.strings.php y los 
	 * metodos de cifrado de MySQL se pueden revisar en este otro link
	 * http://dev.mysql.com/doc/refman/5.0/en/encryption-functions.html 
	 *
	 * @param string $hash cadena encriptada a buscar
	 * @param string $campo nombre del campo de la tabla a consultar
	 * @param string $tabla nombre de la tabla a consultar
	 * @param string $mode metodo de encriptacion puede ser md5, sha1, etc
	 * @return mixed valor del campo consultado
	 */
	function normalhash($hash,$campo,$tabla,$mode="sha1"){
		$query="SELECT $campo FROM $tabla WHERE $mode($campo)='$hash' ";
		$result=mysql_query($query) or die(mysql_error());
		if($row=mysql_fetch_array($result)){
			$valor_normal=$row[$campo];
		}
		return $valor_normal;
	}
	
	/**
	 * Cuenta el total de registros de una tabla
	 * 
	 * El total obtenido ademas de ser retornado tambien es guardado en 
	 * un vector como propiedad de la clase para algun uso extra durante 
	 * un script como por ejemplo un paginador, se usa el nombre de la 
	 * tabla por defecto o un nombre unico dado por el segundo parametro 
	 *
	 * @param string $tabla nombre de la tabla o tablas a consultar (se puede usar JOIN)
	 * @param string $key nombre de la clave con la que se guarda el resultado en un arreglo
	 * @param string $cond alguna condicion extra en la consulta para filtar algun resultado
	 * @return integer el numero total de registros encontrados
	 */
	function total_regist($tabla,$key='',$cond=''){
		$query="SELECT COUNT(*) as total FROM $tabla WHERE 1 ".$cond;
		//die($query);
		$result=mysql_query($query) or die(mysql_error());
		if($row=mysql_fetch_array($result)){
			if(!$key){ $key=$tabla; } 
			$this->total[$key]=$row['total'];
		}
		return $row['total'];
	}
	
	/**
	 * Buscar recursivamente un valor en un arreglo multiple incluyendo sus indices
	 *
	 * @param string $aguja valor a buscar en el arreglo
	 * @param mixed $pajar arreglo o vector multiple en el que se hara la busqueda
	 * @return boolean puede ser encontrado o no
	 */
	function in_multi_array($aguja,$pajar){
		$in_multi_array=false;
		if(@in_array($aguja,$pajar)){
			$in_multi_array=true;
		} else {
			foreach($pajar as $key => $val){
				if(@is_array($val)){
					if($this->in_multi_array($aguja,$val)){
						$in_multi_array=true;
						break;
					}
				}
			}
		}
		return $in_multi_array;
	}
	
	/**
	 * Ordena un arreglo multiple de manera natural segun el nombre del campo
	 *
	 * @param mixed $array arreglo o vector multiple a ordenar 
	 * @param string $porcampo nombre del campo por el que se hara el orden
	 * @return mixed arreglo ordenado
	 */
	function ordermultiarray($array,$porcampo){
		 usort($array,create_function('$a,$b','return strcasecmp($a["'.$porcampo.'"],$b["'.$porcampo.'"]);'));
		return $array;
	}

	/**
	 * Obtiene el id de la session usada
	 *
	 * @param str $sessid
	 * @return str
	 */
	function get_session_id($sessid = '') {
		if (!empty($sessid)) {
			return session_id($sessid);
		} else {
			return session_id();
		}
	}
	
	/*
	 * Alterna el nombre del estilo css para un listado
	 */
	function get_classfila($fila){
		if($fila%2==0){
			$class="firstalt";
		} else {
			$class="secondalt";
		}
		return $class;
	}
	
	/*
	 * Genera una lista de datos de una columna agrupada 
	 */
	function get_filers_colum($colum_value, $colum_text, $table_name){
		$query="SELECT $colum_value AS valor, $colum_text AS texto 
			FROM $table_name GROUP BY $colum_value ORDER BY $colum_text ";
		$this->filter = dbtools::_SQL_tool('SELECT',__METHOD__,$query);
	}
	
	/*
	 * Obtiene el querystring de la pagina y genera la cadena excluyendo ciertos parametros
	 */
	function capute_request($exclude) {
        $output = "";
        foreach($_GET as $k => $v){
            if( $k != $exclude && !in_array($k,array('lng','pg')) ) {
            	$output.= '&'.$k.'='.$v;
            }
        }
        return $output;
    }
	
    /**
     * @param float $maximo_porcentaje (es el total que representa el 100% por ejemplo)
     * @param float $valor (es el valor al cual se le calcula el porcentaje segun el primer parametro)
     * @param float $base_del_procentaje (es la base del porcentaje el cual representa el primer parametro [100|150|200] porciento)
     * @param string $type_return (tipo de dato a retornar)
     * @param $decimales (es la cantidad de decimales que se quiere que se muestre [solo si es float])
     * @param boolean $format si se quiere que se formatee el numero con number_format
     * @return Float | Int dependiendo del cuarto parametro
     */
    function calcular_porcentaje($maximo_porcentaje,$valor,$base_del_procentaje=100,$type_return="int",$decimales=2,$format=true){
    	$maximo_porcentaje=(double)$maximo_porcentaje;
    	$valor=(double)$valor;
    	$base_del_procentaje=(double)$base_del_procentaje;
    	$val_return=(!$maximo_porcentaje==(double)0)?(($valor/$maximo_porcentaje)*$base_del_procentaje):0;
    	switch(strtolower($type_return)){
    		case "int":
    			return round((float)$val_return,0);
    		break;
    		case "float":
    			$number=round((float)$val_return,$decimales);
    			return ($format)?number_format($number,$decimales):$number;
    		break;
    	}
    }
    
	public static function isInvalidEmail($email,$validDomain=false){
		$err=array();
		$exp = "/[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/";
		if(!preg_match($exp,$email)){
			$err['sintax']='txt_invalid_sintax';
		}
		if($validDomain){
			require_once LOCAL_PEAR_DIR."Net/DNS.php";
			$resolver = new Net_DNS_Resolver();
			//$resolver->nameservers = array('200.44.32.12'); //servidor DNS (CANTV)
			$resolver->nameservers = explode(',',SERVIDORES_DNS);
			$response = $resolver->query(end(explode('@',$email)),'MX');
			if (!$response) {
			  //foreach ($response->answer as $rr) {
			    //$rr->display();
			  //}
			  $err['domain']='txt_domain_not_exist';
			}
		}
		return ($err)?$err:false;
	}
        /*
         * Devuelve un numero en formato
         * @param float $number (es el numero a formatearse)
         * @param string $lang (el valor de la sesion del lenguaje)
         * @param int $dec (cantidad de decimales)
         * @return string del numero ya formateado
         */
        function FormatNumberMotoPoint($number,$lang='en',$dec=2) {
            if ($number){
                if ($lang== 'en'){
                $numberf = number_format($number,$dec,'.',',');
            }else{
                $numberf = number_format($number,$dec,',','.');
            }
            }
            return $numberf;
        }
        function RoundNumberMotoPoint($number) {
            if ($number){
                $numberf = ceil($number);
            }else{
                $numberf = '';
            }
            return $numberf;
        }
        
        function sumArrayIterator(array $arrIterator,$index,$fieldIterator,$fieldSum){
        	$lastValIterator=$valIterator=$arrIterator[$index][$fieldIterator];
        	$return=$arrIterator[$index][$fieldSum];
        	while($valIterator && $lastValIterator==$valIterator ){
        		$return+=$arrIterator[++$index][$fieldSum];
        		$lastValIterator=$arrIterator[$index][$fieldIterator];
        	}
        	return $return;
        }
        
        static function getMonthStr($month_number){
        	$arrMont= array(1 =>'January',
            2 =>'February',
            3 =>'March',
            4 =>'April',
            5 =>'May',
            6 =>'June',
            7 =>'July',
            8 =>'August',
            9 =>'September',
            10=>'October',
            11=>'November',
            12=>'December');
            return $arrMont[$month_number];
        }
        
		//Suma o Resta minutos a una fecha (yyyy-mm-dd hh:mm:ss)
		function SumaRestaMinutosFechaStr($FechaStr, $MinASumar, $resta=0)
		{
		  $FechaStr = str_replace("-", " ", $FechaStr);
		  $FechaStr = str_replace(":", " ", $FechaStr);
			
		  $FechaOrigen = explode(" ", $FechaStr);
			
		  $Anyo = $FechaOrigen[0];
		  $Mes = $FechaOrigen[1];
		  $Dia = $FechaOrigen[2];
			
		  $Horas = $FechaOrigen[3];
		  $Minutos = $FechaOrigen[4];
		  $Segundos = $FechaOrigen[5];
			
		  if ($resta==1) { // Resto los minutos
			  $Minutos = ((int)$Minutos) - ((int)$MinASumar); 
		  } else { // Sumo los minutos
			  $Minutos = ((int)$Minutos) + ((int)$MinASumar); 
		  }
		  // Asigno la fecha modificada a una nueva variable
		  $FechaNueva = date("Y-m-d H:i:s",mktime($Horas,$Minutos,$Segundos,$Mes,$Dia,$Anyo));
			
		  return $FechaNueva;
		}
		
		
		function copyTable($origenTable,$newTable){

			$query = "CREATE table IF NOT EXISTS $newTable like $origenTable";
			//$this->_SQL_tool('UPDATE', __METHOD__, $query);
			//die($query);
			$result=mysql_query($query) or die(mysql_error());
		}

		function renameTable($origenTable,$newTable){
			$query = "DROP TABLE IF EXISTS $newTable";
			$result=mysql_query($query) or die(mysql_error());
			
			$query = "RENAME table $origenTable to $newTable";
			//$this->_SQL_tool('UPDATE', __METHOD__, $query);
			//die($query);
			$result=mysql_query($query) or die(mysql_error());
		}
		
}
?>