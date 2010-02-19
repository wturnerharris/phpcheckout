<?php 
require_once('config.php'); 

$pID = $_POST['pID'];
	
$remove = "DELETE FROM users WHERE ID='$pID'";
mysql_select_db($database_equip, $equip);
mysql_query($remove, $equip) or die(mysql_error());

?>
