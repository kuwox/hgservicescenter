// JavaScript Document
/* ppValidatorForm v2.0 <http://ww.presenciaprofesional.com/download/>
	Copyright (c) 2011 Greyza Sarmiento
	Este codigo fue desarrollado por Presencia Profesional c.a.
	permite validar de forma asincrona un formulario a traves de validaciones en PHP
*/


$(document).ready(function(){
	//Colocar que si onkey enter ejecute el validateform
	//alert(" tiempo corriendo");
});	
	
function insertAfter(parent, node, referenceNode) {
  parent.insertBefore(node, referenceNode.nextSibling);
}  

/*function enviar_form(){
	alert('envio');

}*/
function print_msgError(id,msg) {

	var label = document.getElementById('l_'+id);
	if (label != null) {
		// Print msg
		label.innerHTML = msg;
	} else {	
		// create node
		var newNode = document.createElement("label");
		newNode.setAttribute('class', 'label_error');
		newNode.setAttribute('id', 'l_'+id);
		newNode.setAttribute('for', id);
		newNode.appendChild(document.createTextNode(msg));
		
		// insert before
		var padre = document.getElementById(id);
		if (padre == null) {
			//alert('campo '+name+' no tiene id');
		} else {
			insertAfter(padre.parentNode,newNode, padre);
		}
	}
}




function validateForm(txt)
{
	var ieVersion = parseInt(navigator.appVersion);
	var data = "";
	document.form1.send.disabled=true;
	$('#msj_error').html('<img src="../images/ajax-loader.gif"/>');		
	var className = "validate";
	var firstField = 0;
	var form = document.getElementById("form1");
	//alert(ieVersion);
	if(navigator.userAgent.indexOf("MSIE") != -1 && ieVersion < 5) { //IE 8 o menor


		
		var form = document.getElementById("form1");
		//var allElements = form.getElementsByClassName("validate");
		var allElements = form.getElementsByTagName('*')
		//var allElements = form.getElementsByTagName('select')
		//var allElements = form.getElementsByTagName('textarea')
		//var allElements = form.getElementsByTagName('input')

		//Remueve mensajes de error ya mostrados
		//var remElement=form.getElementsByClassName('label_error'); 

		var total = allElements.length;
		for (i = 0; i< total; i++) {
			var element = allElements[i];

			var elementClass = element.className;
			
			//alert('elementClass='+elementClass);
			if (elementClass == 'label_error') { 
				var nodo = document.getElementById(element.id);
				nodo.innerHTML = "";
			} 
			if (elementClass && elementClass.indexOf(className) != -1 ) {
				//For focus to First Field to validate
				if (firstField==0) { 
					firstField = element.id; 
					//document.getElementById(firstField).focus();
					document.getElementById('msj_error').focus();
				}
			
				if (elementClass.indexOf('is_equalto') > 0){
					a = elementClass.split('#');
					valor2 = element.value+'#_'+document.getElementById(a[1]).value;
					//alert('valor2='+valor2);
					data+= element.id+'|'+valor2+'|'+elementClass+'|'+element.title+'^';	
					//alert('data='+data);
				} else {
					
					data+= element.id+'|'+element.value+'|'+elementClass+'|'+element.title+'^';
					//alert('elementClass='+elementClass);
				}

			} //end class Validate
		}
		



	} //Fin IE 8 o menor
	else {


		var allElements = form.getElementsByClassName("validate");
		var data = "";

		//Remueve mensajes de error ya mostrados
		var remElement=form.getElementsByClassName('label_error'); 


		for (i = 0; i< remElement.length; i++) {
			var element = remElement[i];
			var nodo = document.getElementById(element.id);
			nodo.innerHTML = "";
		}
		
		
		var total = allElements.length;
		//alert(total);


		for (i = 0; i<total; i++) {
			var element = allElements[i];
			var elementClass = element.className;


			if (elementClass && elementClass.indexOf(className) != -1 ) {
				//For focus to First Field to validate
				if (i==0) { firstField = element.id; }
				if (firstField==0) { 
					firstField = element.id; 
					//document.getElementById(firstField).focus();
					document.getElementById('msj_error').focus();
				}
				
				//Verifica que no este ya el input en cadena a validar
				if (data.indexOf(element.id+'|') == -1){
					//alert(element.type);
					
					//Verifica si es checkbox
					if (element.type=='checkbox') {
						//var xx = document.getElementById(element.id);
						//alert('='+xx.length);						
						//document.form1.scripts.length
						//document.form1.scripts[i].checked
						
						/*var valorcheck="";
						for(var d=0; d < element.id[0].length; d++){
							if(element[d].checked)
								valorcheck +=element[d].value + "#";
						}
						//alert("="+valorcheck);						
						data+= element.id+'|'+valorcheck+'|'+elementClass+'|'+element.title+'^';
						*/	
					}
					

					if (elementClass.indexOf('is_equalto') > 0){
						a = elementClass.split('#');
						valor2 = element.value+'#_'+document.getElementById(a[1]).value;
						//alert('valor2='+valor2);
						data+= element.id+'|'+valor2+'|'+elementClass+'|'+element.title+'^';	
						//alert('data='+data);
					} else {
						//alert(element.id+'|'+element.value+'|'+elementClass+'|'+element.title+'^');
						data+= element.id+'|'+element.value+'|'+elementClass+'|'+element.title+'^';				
					}
				}
			}
		}

	}
//
	 $("#msj_error").load("../lib/ppValidator/validate_asin_form.php", { data:data },llegadaDatos );

	//alert('='+ data);


	if(txt.indexOf('is_equalto') > 0){
		alert('aaa');
		//validate(); //Objeto validator
	} 
	
	//Si existe captcha lo verifica
	/*if(txt=='captcha'){
		var tmptxt = document.getElementById('tmptxt').value;
		var txt_puerta = '1';
		$.get("../pages/asin.general.php", { txt_puerta : txt_puerta , tmptxt : tmptxt },
		 function(data){
				if(data==1){
					document.getElementById('mens').innerHTML = '';
					validate(); //Objeto validator
				} else {
					document.getElementById('mens').innerHTML = data;
					return false;
				} 
		});
	} */
	//Fin captcha
	

}



function llegadaDatos(datos)
{


	if(datos!=null && datos != ""){
		//alert('='+ datos);
		//Reload(); refreshCaptcha();
		document.form1.send.disabled=false;
		
	} else {
		$('#msj_error').html('<img src="../images/ajax-loader.gif"/>');	
		document.form1.submit();
	} 	

}