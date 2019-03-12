<?
defined( '_JEXEC' ) or die( 'Restricted access' );


session_start();
session_unset();
session_destroy();
header("location: ?option=home");

?>
             