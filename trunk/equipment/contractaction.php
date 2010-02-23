<?php 
require_once('config.php'); 

$StudentID = $_POST['StudentID'];

$sql = "UPDATE students SET ContractSigned = '1' WHERE StudentID = $StudentID";
//echo $sql;
mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());

?>
<meta http-equiv="refresh" content="3,studentinfo.php?StudentID=<? echo $StudentID ?>" />
<? 
include ('studentinfo.php');
echo "<script type='text/javascript'>setTimeout('$(\'alert\').style.visibility = \'hidden\';',1000);</script>";
echo "<div id='alert' style='visibility:visible'>Contract Signed. Thank you.<br/>";
echo "Page will refresh automatically.</div>";
?>