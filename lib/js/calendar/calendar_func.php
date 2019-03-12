<?
function UltimoDia($a,$m){
  if (((fmod($a,4)==0) and (fmod($a,100)!=0)) or (fmod($a,400)==0)) {
    $dias_febrero = 29;
  } else {
    $dias_febrero = 28; 
  }
  switch($m) {
    case  1: $valor = 31; break;
    case  2: $valor = $dias_febrero; break;
    case  3: $valor = 31; break;
    case  4: $valor = 30; break;
    case  5: $valor = 31; break;
    case  6: $valor = 30; break;
    case  7: $valor = 31; break;
    case  8: $valor = 31; break;
    case  9: $valor = 30; break;
    case 10: $valor = 31; break;
    case 11: $valor = 30; break;
    case 12: $valor = 31; break;
  }
  return $valor;
}

function nombre_mes($m, $objLan){
  switch($m) {
    case  1: $valor = "Enero";			break;
    case  2: $valor = "Febrero";		break;
    case  3: $valor = "Marzo";			break;
    case  4: $valor = "Abril";			break;
    case  5: $valor = "Mayo";			break;
    case  6: $valor = "Junio";			break;
    case  7: $valor = "Julio";			break;
    case  8: $valor = "Agosto";			break;
    case  9: $valor = "Septiembre";		break;
    case 10: $valor = "Octubre";		break;
    case 11: $valor = "Noviembre";		break;
    case 12: $valor = "Diciembre";		break;
  }
  return $valor;
}

function numero_dia_semana($d,$m,$a){ 
  $f = getdate(mktime(0,0,0,$m,$d,$a)); 
  $d = $f["wday"];
  if ($d==0) {$d=7;}
  return $d;
} 

function nombre_dia_semana($d,$m,$a,$objLan){ 
  $f = getdate(mktime(0,0,0,$m,$d,$a)); 
  switch($f["wday"]) {
    case 1: $valor = "Lunes";			break;
    case 2: $valor = "Martes";			break;
    case 3: $valor = "Miercoles";		break;
    case 4: $valor = "Jueves";			break;
    case 5: $valor = "Viernes";			break;
    case 6: $valor = "Sabado";			break;
    case 0: $valor = "Domingo";			break;
  }
  return $valor;
}

?>
