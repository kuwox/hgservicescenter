<?php

$host="localhost";
$login="root";
$password="123";
$basedatos = "pp_vigo";

/*
// vivo 
$host="localhost";
$login="vigoimag_admin";
$password="ldc1txZDA";
$basedatos = "vigoimag_master";
*/


$db=mysql_connect($host,$login,$password) or die ("Can't open connection");
mysql_select_db($basedatos) or die ("Can't connect to DB");

?>
