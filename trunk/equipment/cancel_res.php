<?php
require_once('config.php'); 

$CheckOutID = $_REQUEST['CheckOutID'];
$sid = $_REQUEST['StudentID'];
mysql_select_db($database_equip, $equip);
$remove = "SELECT * FROM checkedout WHERE checkedout.ID='$CheckOutID' AND StudentID='$sid'";
$Recordset1 = mysql_query($remove, $equip) or die(mysql_error());
$row_check = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

include('reserved.php'); 
echo "<div id='overlay'></div>";
echo "<div id='alert' class='alert' style='visibility: visible;'>";

if ($row_check['StudentID'] == $sid) {
	mysql_select_db($database_equip, $equip);
	$query_Recordset2 = "DELETE FROM checkedout WHERE checkedout.ID='$CheckOutID' AND StudentID='$sid'";
	mysql_query($query_Recordset2, $equip) or die(mysql_error());
	echo "Reservation Canceled.</div>";
	echo "<meta http-equiv='refresh' content='3;URL=studentinfo.php?StudentID=$sid'>";
} else {
	echo "Reservations should be canceled from the Reservation page or under the student who reserved it.</div>";
	echo "<meta http-equiv='refresh' content='3;URL=reserved.php'>";
}
?>
