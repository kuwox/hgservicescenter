<?php

class countbd extends dbtools{
	var $count_visit;
	var $ip;
	var	$fecha;
	var	$hora;
	var	$segundos;
	/*
	 * Obtiene los datos del usuario
	 */
	function countbd(){
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->fecha = date("j del n de Y");
		$this->hora = date("h:i:s");
		$this->segundos = time();
		$can = "3600";
		//compara si en la última hora hubo alguna entrada con la misma IP no la toma en cuenta
		$resta = $this->segundos-$can;	
		//die('resta='.$resta);
		$query = "SELECT segundos, ip FROM contador WHERE segundos >= $resta AND ip = '$this->ip' ";
		//die($query);
		$this->data = $this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
		//die('='.$this->data['ip']);

		if(!$this->data['ip']) {
			$this->add_count();
		}
		

		$query = "SELECT max(id) as total FROM contador ";
		//die($query);
		$this->data = $this->_SQL_tool('SELECT_SINGLE', __METHOD__, $query);
		$this->count_visit = $this->data['total'];

	}
    
    
    

	/*
	 * Agrega un usuario nuevo a la bd
	 */
	function add_count() {
			
		$query="INSERT INTO contador (ip, hora, segundos,fecha)
		VALUES ('$this->ip','$this->hora','$this->segundos',NOW())";
		//die($query);
		$newid = $this->_SQL_tool('INSERT', __METHOD__, $query);
	}
    
	
}
?>