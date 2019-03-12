// JavaScript Document
var xmlHttp;
var myrand=parseInt(Math.random()*99999999);

function GetXmlHttpObject(){
	var objXMLHttp=null
	if(window.XMLHttpRequest){
		objXMLHttp= new XMLHttpRequest();
	} else if(window.ActiveXObject){
		objXMLHttp= new ActiveXObject("Microsoft.XMLHTTP");
	}
	return objXMLHttp;
}

