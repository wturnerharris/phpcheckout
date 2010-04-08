<?php 
require_once('config.php'); 

$CheckedOutID = $_POST['CheckedOutID'];
$FinePaid = $_POST['FinePaid'];
$StudentID = $_POST['StudentID'];

if ($fines) {
	$sql = "UPDATE checkedout SET FinePaid = '$FinePaid' WHERE ID = $CheckedOutID;";
} else {
	$sql = "UPDATE checkedout SET Strike = '$FinePaid', BannedDate = NULL WHERE ID = $CheckedOutID;";
}
//echo $sql;
mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());

include('fines.php');
?>
<meta http-equiv="refresh" content="1,studentinfo.php?StudentID=<?php echo $StudentID; ?>" />
<div id="alert" style="visibility:visible">
Adjusted<br />
<br />
Returning to Student: <? echo $StudentID ?><br />
</div>