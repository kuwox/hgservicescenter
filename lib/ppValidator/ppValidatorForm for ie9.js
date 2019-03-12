// JavaScript Document
/* ppValidatorForm v2.0 <http://ww.presenciaprofesional.com/download/>
	Copyright (c) 2011 Greyza Sarmiento
	Este codigo fue desarrollado por Presencia Profesional c.a.
	permite validar de forma asincrona un formulario a traves de validaciones en PHP
*/

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
			alert('campo '+name+' no tiene id');
		} else {
			insertAfter(padre.parentNode,newNode, padre);
		}
	}
}


function validateForm(txt)
{
	 	document.form1.send.disabled=true;
		$('#msj_error').html('<img src="../images/ajax-loader.gif"/>');		
		var className = "validate";
		var hasClassName = new RegExp("(?:^|\\s)" + className + "(?:$|\\s)");
		
		var form = document.getElementById("form1");
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
			
				if (elementClass.indexOf('is_equalto') > 0){
					a = elementClass.split('#');
					valor2 = element.value+'#_'+document.getElementById(a[1]).value;
					//alert('valor2='+valor2);
					data+= element.id+'|'+valor2+'|'+elementClass+'|'+element.title+'^';	
					//alert('data='+data);
				} else {
					data+= element.id+'|'+element.value+'|'+elementClass+'|'+element.title+'^';				
				}
				/*else if (elementClass.indexOf('is_email') > 0){
					data+= element.id+'|'+element.value+'|is_email|'+element.title+'^';					
					
				} else if (elementClass.indexOf('is_num') > 0){
					data+= element.id+'|'+element.value+'|is_num|'+element.title+'^';
				}*/
			}
		}

	  document.getElementById(firstField).focus();
	 $("#msj_error").load("../lib/ppValidator/validate_asin_form.php", { data:data },llegadaDatos );
	
	//Si existe captcha lo verifica
	if(txt=='captcha'){
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
	}
	//Fin captcha

}
function llegadaDatos(datos)
{

	//alert('llegadaDatos='+datos+'|');
	if(datos!=null && datos != ""){
		document.form1.send.disabled=false;
	} else {
	  $('#msj_error').html('<img src="../images/ajax-loader.gif"/>');	
	  document.form1.submit();
	} 	

}