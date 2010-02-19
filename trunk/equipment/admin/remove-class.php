<?php 
require_once('../config.php'); 

$rmClassID = $_POST['rmClassID'];
	
$remove = "DELETE FROM student_class WHERE ID='$rmClassID'";
mysql_select_db($database_equip, $equip);
mysql_query($remove, $equip) or die(mysql_error());

?>
