// JavaScript Document
function func_check(tipo){
	var var_cadena;
	switch (trim(tipo)){
		case "Single Line Text":
			//var_cadena = "<li class=\'list1\' id=\'li1_4\'>list 1, item 4</li>";
			var_cadena = "<li id=\'li1_4\' title=\'Click to edit. Drag to reorder.\'><IMG class=arrow alt=\'\' src=\'Wufoo%20·%20Form%20Builder_files/arrow.png\'> ";
			var_cadena += "<LABEL class=desc id=title0 for=Field0>nombre <SPAN class=req id=req_0>*</SPAN></LABEL>";
			var_cadena += "<DIV><INPUT class=\'field text medium\' id=Field0 readOnly maxLength=255 name=Field0> </DIV>";
			var_cadena += "<P class=\'instruct hide\' id=instruct0><SMALL></SMALL></P>";
			var_cadena += "<DIV class=\'fieldActions\' id=fa0><IMG class=faDup onmousedown=duplicateField(0) title=Duplicate. alt=Duplicate. src=\'Wufoo%20·%20Form%20Builder_files/add.png\'> ";
			var_cadena += "<IMG class=faDel onmousedown=removeField(0) title=Delete. alt=Delete. src=\'Wufoo%20·%20Form%20Builder_files/delete.png\'> ";
			var_cadena += "</DIV>";
			var_cadena += "</li>";
			break;
		/*case "Number":
			break;
		case "Paragraph Text":
			break;
		case "Checkbox":
			break;
		case "Multiple Choice":
			break;
		case "Drop Down":
			break;
		case "Section Break":
			break;
		case "File Upload":
			break;*/
	}
	return var_cadena;
}
function trim(str)
{
    if(!str || typeof str != 'string')
        return null;

    return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
}