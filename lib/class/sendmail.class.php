<?
/**
 * 
 *
 */
class sendmail extends dbtools {
	var $html_header;
	var $html_footer;
	var $vars;
	var $template;
	var $from;



	/**
	 * carga el contenido de un template html
	 *
	 * @param varchar $template			nombre del archivo del template
	 * @return string					retorna el contenido del archivo en forma de cadena
	 */
	function get_template($template=null,$lang='es'){
		
		$html=file_get_contents("../mail_templates/".$lang."/".$template.".html");
		$this->template = $html;
	}
	
	/**
	 * rememplaza las variables del contenido de un archivo ya cargado
	 *
	 * @param array $vars		variables a cambiar en formato variable=>valor
	 * @param string $html 		cadena a reemplazar
	 * @return string			retorna la cadena reemplazada
	 */
	function remplace_var_template($vars='',$html='', $folder_client=''){

		$vars['##server_path##']=DOMAIN_ROOT;
		$vars['##system_name##']=SYSTEM_NAME;
		$vars['##email_from##']=EMAIL_FROM;
		$vars['##email_from_name##']=EMAIL_FROM_NAME;   
		$vars['##email_signature##']=EMAIL_SIGNATURE;	
	   
		$html = str_ireplace("src=\"images","src=\"".DOMAIN_ROOT."images",$html);
		$html = str_ireplace("background=\"images","background=\"".DOMAIN_ROOT."images",$html);
	   
		foreach($vars as $key=>$value){
				$html= str_replace($key,stripslashes($value),$html);
				//$html= str_replace($key,$value,$html);
		}
			
		//die($html);
/*		foreach($vars as $key=>$value){
			$html= str_replace($key,$value,$html);
		}*/
		/*echo $html;
		die();*/
		return ($html);
		
	}
	
	
	
	//realiza el envio de correos
	/**
	 * envio del correo.
	 *
	 * @param array $to_send				lista de destinatarios
	 * @param array $to_send_CC				lista de destinatarios CC
	 * @param array $to_send_BCC			lista de destinatarios BCC
	 * @param varchar $titulo				Titulo del correo
	 * @param text $mensaje					mensaje HTML
	 */
	function send_email_normal($to_send, $attach='', $attach_name='',$to_send_CC='',$to_send_BCC='') {

			$mensaje=$this->remplace_var_template($this->vars,$this->template);
		    $pos = strpos($mensaje, '##_subject##');
			
			$subject = substr($mensaje,0,$pos);
			$mensaje = substr($mensaje,$pos+12);
			//die('='.$to_send.'<br>'.$mensaje);
			

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'From: '.EMAIL_FROM_NAME.' <'.EMAIL_FROM.'>' . "\r\n";

	
			if(isset($_SESSION['s_usuario_recive_mails']) && $_SESSION['s_usuario_recive_mails']==1){
					//El usuario esta logueado y quiere recibir correos
					$enviar = true;
			} elseif( !isset($_SESSION['s_usuario_recive_mails']) ){
					//Si no existe el parametro hago el envio verdadero
					$enviar = true;
			}
			
			
			//die('SEND_MAIL='.SEND_MAIL);
			if (SEND_MAIL=="active" and $enviar == true) {
				//die('1='.$to_send.'<br>'.$mensaje);
				mail($to_send, $subject, $mensaje, $headers);	
				// Mail to Copia
				$subject = "Copy (".$to_send.") - ".$subject;
				mail(SYSTEM_EMAIL_BCC, $subject, $mensaje, $headers);
			} elseif (SEND_MAIL=="redirect") {
				//die('2='.$to_send.'<br>'.$mensaje);
				// Mail to Copia
				$subject = "Redirect (".$to_send.") - ".$subject;
				mail(SYSTEM_EMAIL_BCC, $subject, $mensaje, $headers);
			} 
			
		   

		   

		
	}

	function set_bd_email($emails_id='',$emails_status_id=''){
		$query = "UPDATE emails SET emails_status_id=$emails_status_id WHERE emails_id='$emails_id' ";
		$res_array = $this->_SQL_tool('UPDATE', __METHOD__, $query);
		
	}

	function get_bd_email($emails_id='',$emails_status_id=''){
		$query = "SELECT * FROM emails WHERE 1 ";
		if(!empty($emails_id)) $query.=" AND emails_id='$emails_id'";
		if(!empty($emails_status_id)) $query.=" AND emails_status_id='$emails_status_id'";		
		//die($query );
		$res_array = $this->_SQL_tool('SELECT', __METHOD__, $query);
		return $res_array;
		
	}
	
	function new_bd_email($emails_to='', $emails_from='',$emails_subject, $emails_body='', $text_body='',$attach_name='',$attach_content=''){
		$text_body = trim($text_body);
		$emails_body = trim($emails_body);		
		$query = "insert into emails (emails_to, emails_from, emails_subject, emails_body, text_body, attach_name, attach_content, emails_status_id, date_update)
		 values ('$emails_to', '$emails_from','$emails_subject','$emails_body','$text_body','$attach_name','$attach_content', '1', now())";
		//die($query );
    	$email_id = $this->_SQL_tool('INSERT', __METHOD__, $query);
		return $email_id;	
		
	}


	function send_bd_email($email_id) {

			$arr_email = $this->get_bd_email($email_id);
			$to_send = $arr_email[0]['emails_to'];
			$subject = $arr_email[0]['emails_subject'];
			$html_body = $arr_email[0]['emails_body'];
			
            $text_body=strip_tags(html_entity_decode($html_body));
			
			$enviar = false;
			$mail = new PHPMailer();
			$mail->IsSMTP();        // send via SMTP
			$mail->CharSet = 'UTF-8';  //agregado
			$mail->Host     = EMAIL_SERVER_HOST; // SMTP servers
			$mail->From     = $arr_email[0]['emails_from'];
			$mail->FromName = EMAIL_FROM_NAME;
			if(defined(EMAIL_SERVER_AUTH) && EMAIL_SERVER_AUTH!="false"){
				$mail->SMTPAuth = EMAIL_SERVER_AUTH;     // turn on SMTP authentication
				$mail->Username = EMAIL_SERVER_USER;  // SMTP username
				$mail->Password = EMAIL_SERVER_PASS; // SMTP password
			}              
		   
			
			$mail->WordWrap = 80;   // set word wrap
			$mail->IsHTML(true);    // send as HTML

			//$mail->AddAttachment($attach,$attach_name);            
			$mail->Subject  =  $subject;    
			$mail->Body     =  $html_body;
			$mail->AltBody  =  $text_body;
		   

			$enviar = true;
			if($enviar && (SEND_MAIL=="active" || SEND_MAIL=="redirect" || SEND_MAIL=="active_db") ){ 

				if (SEND_MAIL=="active" || SEND_MAIL=="active_db") {
					$mail->AddAddress($to_send);
					$mail->Send();				
					$this->set_bd_email($email_id,'2');
				} elseif (SEND_MAIL=="redirect") {
					
					$mail->Subject  =  "Redirect (".$to_send.") - ".$subject; //cambio subject		
					$mail->AddAddress(SYSTEM_EMAIL_BCC);
					$mail->Send();
					$this->set_bd_email($email_id,'2');
				} 				
				
				
			
			}
			
			
			$mail->ClearAllRecipients();  
			$mail->ClearAttachments();

	}

	//realiza el envio de correos
	/**
	 * envio del correo.
	 *
	 * @param array $to_send				lista de destinatarios
	 * @param array $to_send_CC				lista de destinatarios CC
	 * @param array $to_send_BCC			lista de destinatarios BCC
	 * @param varchar $titulo				Titulo del correo
	 * @param text $mensaje					mensaje HTML
	 */
	function send_email ($to_send, $attach='', $attach_name='',$to_send_CC='',$to_send_BCC='') {

			$mensaje=$this->remplace_var_template($this->vars,$this->template);
		    $pos = strpos($mensaje, '##_subject##');
			
			//Extraemos el subject y el cuerpo
			$subject = substr($mensaje,0,$pos);
			$html_body = substr($mensaje,$pos+12);
            $text_body=strip_tags(html_entity_decode($html_body));
			//die('='.$to_send.'<br>'.$html_body);



/*			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: www.presenciaprofesional.com <info@presenciaprofesional.com>' . "\r\n";
			// Mail it
			mail($to_send, $subject, $mensaje, $headers);	*/
			
			$enviar = false;
			$mail = new PHPMailer();
			$mail->IsSMTP();        // send via SMTP
			$mail->CharSet = 'UTF-8';  //agregado
			$mail->Host     = EMAIL_SERVER_HOST; // SMTP servers
			$mail->From     = EMAIL_FROM;
			$mail->FromName = EMAIL_FROM_NAME;
			if(defined(EMAIL_SERVER_AUTH) && EMAIL_SERVER_AUTH!="false"){
				$mail->SMTPAuth = EMAIL_SERVER_AUTH;     // turn on SMTP authentication
				$mail->Username = EMAIL_SERVER_USER;  // SMTP username
				$mail->Password = EMAIL_SERVER_PASS; // SMTP password
			}      
			if(empty($this->from)) {
				$mail->From     = EMAIL_FROM;
				$mail->FromName = EMAIL_FROM_NAME;
			} else {
				$mail->From     = $this->from;
				$mail->FromName = $this->from;			
			}
			
			if($to_send_CC){ $mail->AddCC($to_send_CC); }
			if($to_send_BCC){ $mail->AddBCC($to_send_BCC);  }
		   
			
			$mail->WordWrap = 80;   // set word wrap
			$mail->IsHTML(true);    // send as HTML

			$mail->AddAttachment($attach,$attach_name);            
			$mail->Subject  =  $subject;    
			$mail->Body     =  $html_body;
			$mail->AltBody  =  $text_body;
		   

			$enviar = true;
		   
			if($enviar && (SEND_MAIL=="active" || SEND_MAIL=="redirect" || SEND_MAIL=="bd" || SEND_MAIL=="active_db") ){ 
				 //die('enviado='.$mail->Password.'   / '.SEND_MAIL);
				 
				if (SEND_MAIL=="active") {
					$mail->AddAddress($to_send);
					$mail->Send();				
				} elseif (SEND_MAIL=="active_db") {
					$mail->AddAddress($to_send);
					$mail->Send();				
					$this->set_bd_email($email_id,'2');
				
				} elseif (SEND_MAIL=="redirect") {
					
					$mail->Subject  =  "Redirect (".$to_send.") - ".$subject; //cambio subject		
					$mail->AddAddress(SYSTEM_EMAIL_BCC);
					$mail->Send();

				} elseif (SEND_MAIL=="bd") { //Guarda envio en BD
					//die('s='.$text_body);
					//$atach_file=file_get_contents($attach);
					$this->new_bd_email($to_send, $mail->From, $subject, $html_body, $text_body, $attach_name,$attach);
				}				
				
				
			
			}
			
			
			$mail->ClearAllRecipients();  
			$mail->ClearAttachments();

	}
	
}
?>