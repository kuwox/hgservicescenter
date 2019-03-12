<?php
/**
 * Salvamos todas las variables $HTTP_*_VARS o $_* en el arreglo $GPC,
 * 'magic_quotes_gpc = off' se sobre escribe para todas las variables
 * y asi evitar injecciones SQL y arreglar problemas con caracteres
 * especiales como comillas
 * 
 * Con este cambio usar $GPC['campo'] en lugar de $_REQUEST['campo']
 * 
 */

function rehtmlspecialchars($arg) {
	$arg = str_replace ( "&lt;", "<", $arg );
	$arg = str_replace ( "&gt;", ">", $arg );
	$arg = str_replace ( "&quot;", "\"", $arg );
	$arg = str_replace ( "&amp;", "&", $arg );
	return $arg;
}

ini_set('magic_quotes_runtime', 0 );
if (! defined ( "GLOBAL_VARS_REWRITED" )) {
	$GPC = array ();
	
	// Solo se hace una vez!
	define ( "GLOBAL_VARS_REWRITED", 1 );
	
	$magic_quotes = get_magic_quotes_gpc ();
	
	function checkValue($arg) {
		global $magic_quotes;
		if (is_string ( $arg )) {
			$arg = ($magic_quotes) ? $arg : addslashes ( $arg );
			$arg = rehtmlspecialchars ( htmlspecialchars ( $arg ) );
		} else {
			foreach ( $arg as $key => $value ) {
				$arg [$key] = checkValue ( $value );
			}
		}
		return $arg;
	}
	
	function regGlobals($array, &$target_array) {
		reset ( $array );
		// get the vars out of the get-, post- or cookie-arrays
		foreach ( $array as $key => $value ) {
			global ${$key};
			// we don't register arrays with more than one dimension,
			// we only add slashes if required and use rehtmlspecialchars()
			$value = checkValue ( $value );
			${$key} = $value;
			$target_array [$key] = $value;
		}
		return true;
	}
	
	if (! empty ( $_GET )) {
		regGlobals ( $_GET, $GPC );
	} else if (! empty ( $HTTP_GET_VARS )) {
		regGlobals ( $HTTP_GET_VARS, $GPC );
	}
	
	if (! empty ( $_POST )) {
		regGlobals ( $_POST, $GPC );
	} else if (! empty ( $HTTP_POST_VARS )) {
		regGlobals ( $HTTP_POST_VARS, $GPC );
	}
	
	if (! empty ( $_COOKIE )) {
		regGlobals ( $_COOKIE, $GPC );
	} else if (! empty ( $HTTP_COOKIE_VARS )) {
		regGlobals ( $HTTP_COOKIE_VARS, $GPC );
	}
	
	if (! empty ( $_SERVER )) {
		$GPC ["PHP_SELF"] = $_SERVER ["PHP_SELF"];
		$GPC ["PURE_PHP_SELF"] = basename ( $_SERVER ["PHP_SELF"] );
		$GPC ["QUERY_STRING"] = $_SERVER ["QUERY_STRING"];
		$GPC ["HTTP_USER_AGENT"] = $_SERVER ["HTTP_USER_AGENT"];
		$GPC ["HTTP_ACCEPT_ENCODING"] = $_SERVER ["HTTP_ACCEPT_ENCODING"];
	} else if (! empty ( $HTTP_SERVER_VARS )) {
		$GPC ["PHP_SELF"] = $HTTP_SERVER_VARS ["PHP_SELF"];
		$GPC ["PURE_PHP_SELF"] = basename ( $HTTP_SERVER_VARS ["PHP_SELF"] );
		$GPC ["QUERY_STRING"] = $HTTP_SERVER_VARS ["QUERY_STRING"];
		$GPC ["HTTP_USER_AGENT"] = $HTTP_SERVER_VARS ["HTTP_USER_AGENT"];
		$GPC ["HTTP_ACCEPT_ENCODING"] = $HTTP_SERVER_VARS ["HTTP_ACCEPT_ENCODING"];
	}
}

?>