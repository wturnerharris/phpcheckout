<?php 
require_once('config.php'); 

$CheckedOutID = $_POST['CheckedOutID'];
$FinePaid = $_POST['FinePaid'];
$StudentID = $_POST['StudentID'];
$strike = intval($FinePaid);
$sql = "UPDATE checkedout SET FinePaid = '$FinePaid', Strikes = '$strike' WHERE ID = $CheckedOutID;";
//echo $sql;
mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());

include('fines.php');
?>
<meta http-equiv="refresh" content="1,studentinfo.php?StudentID=<?php echo $StudentID; ?>" />
<div id="alert" style="visibility:visible">
Fines Paid<br />
<br />
Returning to Student: <? echo $StudentID ?><br />
</div>