<?php

class uploads extends dbtools{
	private $permitSize=50000;
	private $only_allowed_extension=array();
	
	static $allowed_csv_types=array("text/x-csv","text/comma-separated-values","text/csv","application/csv",
									"application/excel","application/vnd.ms-excel","application/vnd.msexcel",
									"application/octet-stream"
									);
	static $allowed_image_types=array("image/gif", "image/jpg", "image/jpeg", "image/pjpeg", "image/tiff");
	static $deny_mimetype=array('application/octet-stream','application/x-msdownload','application/exe',
							'application/x-exe','application/dos-exe','vms/exe','application/x-winexe',
							'application/msdos-windows','application/x-msdos-program','application/x-vbs',
							'text/vbs','text/vbscript','application/x-msdos-program','application/com',
							'application/x-com','application/x-httpd-php','text/php','application/php',
							'magnus-internal/shellcgi','application/x-php','application/x-javascript',
							'text/javascript','application/x-ole-storage','text/mspg-legacyinfo'
							);	
	static $spechars=array("\\","'","\t","\n","\r","\0","\x0B","%20"," ");
	
	function upload($dir,$FILE,$type){
		if(!is_array($FILE)){
			throw new Exception("param FILE is not Array");
		}
		$ext= end(explode(".", $FILE['name']));
		if($this->only_allowed_extension && !in_array($ext,$this->only_allowed_extension)){
			throw new Exception(sprintf("Extension FILE '%s' do not Permited",$ext));
		}
		if($FILE['size']> $this->permitSize){
		  throw new Exception(sprintf("Max File size : %s, this Fila size: %s",$this->permitSize,$FILE['size']));
		 }
		 $mimeType=array();
		switch ($type){
		  case "file":
		    $mimeType=self::$allowed_csv_types;
      break;
		  case "img":
		    $mimeType=self::$allowed_image_types; 
		  break;
		 }
		 if(!in_array($FILE['type'], $mimeType) || in_array($FILE['type'], self::$deny_mimetype)){
		  throw new Exception(sprintf("MIME TYPE '%s' don't allowed ",$FILE['type']));
		  }
		  if(!is_uploaded_file($FILE['tmp_name'])){
		  	throw new Exception("File Not Uploaded " );
		  }
		  if(!is_dir($dir)){
		  	mkdir($dir,777);
		  }
		  if(!is_writable($dir)){
		  	throw new Exception(sprintf("Dir '%s' is not writable",$dir));
		  }
		  
		  $fileName=str_replace(self::$spechars, "_", substr($FILE['name'], 0,(strlen($ext)+1)*-1 )).date('Ymdhis')."_rand_".rand(50,8000).".".$ext;
		  if(move_uploaded_file($FILE['tmp_name'],$dir."/".$fileName)){
		  	return array('original_name'=>$FILE['name'],
		  	             'fisical_name'=>$fileName,
		  	             'upload_dir'=>$dir,
		  	             'ext'=>$ext);
		  }else{
		  	throw  new Exception(sprintf("Not moved file to %s ",($dir."/".$fileName)));
		  }
		  

	}
	
	function setOnlyAllowedExtension(array $arr){
		$this->only_allowed_extension=$arr;
	}
	
}

  

?>