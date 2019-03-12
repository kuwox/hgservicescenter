<?php

class edocuments extends dbtools {

	
	function get_type_documents($id_type = '') {
		$query = "SELECT * FROM edocuments_type where allow = 'Y' ";
		if (!empty($id_type)) $query .= " and id in ($id_type)";

		$res_array = $this->_SQL_tool('SELECT', __METHOD__, $query);
		return ($res_array);
	}	
	
  function new_doc($description='', $usuario_id, $name_file='', $name_file_original='', $extension='',$url='', $id_status='1', $date_effective='0000-00-00',  $date_expiration='0000-00-00',$position=''){

		$query = "insert into edocuments (description, usuario_id, name_file, name_file_original, ext, url, id_status, date_effective, date_expiration, position, date_update)
		 values ('$description', '$usuario_id','$name_file','$name_file_original', '$extension','$url', '$id_status', '$date_effective', '$date_expiration', '$position', now())";
		//die($query );
    	$document_id = $this->_SQL_tool('INSERT', __METHOD__, $query);
		return $document_id;	
		
	}
	
  function get_doc($id='',$id_status='', $max='', $date_effective='0000-00-00',  $date_expiration='0000-00-00', $pos='',$not_list=''){

		$query = "SELECT edocuments.*, edocuments_status.description as 'status' from edocuments 
		INNER JOIN edocuments_status ON (edocuments_status.id = edocuments.id_status)
		WHERE 1";
		if (!empty($id)) $query.= " AND edocuments.id='$id'";		
		if (!empty($id_status)) $query.= " AND id_status='$id_status'";	
		if (!empty($pos)) $query.= " AND position='$pos'";	
		if (!empty($not_list)) $query.= " AND position NOT IN ('$not_list')";
		if (!$date_effective=="0000-00-00") $query.= " AND date_effective=>'$date_effective'";
		if (!$date_expiration=="0000-00-00") $query.= " AND date_expiration=>'$date_expiration'";
		if (!empty($max)) $query .= " LIMIT 0,$max ";
		//die($query );
		$res_array = $this->_SQL_tool('SELECT', __METHOD__, $query);
		return ($res_array);
		
	}
	
	
	function upp_document_banner($id,$description, $name_file, $name_file_original ,$ext ,$id_status ,$url='', $position) {
		$query="UPDATE edocuments set description='$description', name_file='$name_file' , name_file_original='$name_file_original',ext='$ext',id_status='$id_status',url='$url', position='$position'  where id='$id'";
		//die($query);
		$this->_SQL_tool('UPDATE', __METHOD__, $query);
	}
	function upp_document($id,$description,$ext,$id_status,$url='',$position) {
		$query="UPDATE edocuments set description='$description',ext='$ext',id_status='$id_status',url='$url', position='$position'  where id='$id'";
		//die($query);
		$this->_SQL_tool('UPDATE', __METHOD__, $query);
	}
	
	function get_doc_impre($id='',$id_status='', $position=''){

		$query = "SELECT edocuments.*, edocuments_status.description as 'status' from edocuments 
		INNER JOIN edocuments_status ON (edocuments_status.id = edocuments.id_status)
		WHERE 1";
		if (!empty($id)) $query.= " AND edocuments.id='$id'";		
		if (!empty($id_status)) $query.= " AND id_status='$id_status'";	
		if (!empty($position)) $query.= " AND position='$position'";	
		

		$query.= " ORDER BY edocuments.impresion ASC";
		//die($query );
		$res_array = $this->_SQL_tool('SELECT', __METHOD__, $query);
		return ($res_array);
		
	}
	function upp_document_prin($id,$impresion='') {
		$query="UPDATE edocuments set impresion='$impresion' where id='$id'";
		//die($query);
		$this->_SQL_tool('UPDATE', __METHOD__, $query);
	}
	/**
     * Borrar un recurso o pagina
     * @param $id
     */
    function delete_doc($id){
        $query = "delete from edocuments where id = '" . $id . "'";
        $this->_SQL_tool('DELETE', __METHOD__, $query);
    }
}
?>