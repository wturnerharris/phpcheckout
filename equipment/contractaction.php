<?php 
require_once('config.php'); 
include('includes/heading.html');

$StudentID = $_POST['StudentID'];

$sql = "UPDATE students SET ContractSigned = '1' WHERE StudentID = $StudentID";
//echo $sql;
mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());

?>

Contract Signed. Thank you.

Page will refresh automatically.

<meta http-equiv="refresh" content="3,studentinfo.php?StudentID=<? echo $StudentID ?>" />
<? 
include 'includes/footer.html';
?>