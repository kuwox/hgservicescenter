<?php
if(!$_SESSION['user_id']){
	header("location: ".DOMAIN_ROOT."index.php");
	exit;
}

?>