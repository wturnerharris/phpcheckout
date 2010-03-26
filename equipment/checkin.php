<?php
require_once('config.php'); 
include('includes/heading.html');

$KitID = $_REQUEST['KitID'];
$StudentID = $_REQUEST['StudentID'];
$CheckedOutID = $_REQUEST['CheckedOutID'];

mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT checkedout.Notes AS CheckedOutNotes, checkedout.ExpectedDateIn, checkedout.Accessories, kit.Name, kit.SerialNumber, kit.ModelNumber FROM checkedout JOIN kit ON kit.ID = checkedout.KitID WHERE checkedout.ID = $CheckedOutID");
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT students.FirstName as FirstName, students.LastName as LastName FROM students WHERE students.StudentID = $StudentID");
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
$FirstName = $row_Recordset2['FirstName'];
$LastName = $row_Recordset2['LastName'];

if (!$fines) {
	$frequency = $gracePeriod;
} else {
	$frequency = $fineFreq;
}
if (intval(strtotime($row_Recordset1['ExpectedDateIn']) + $frequency) < intval(strtotime("now"))) {
$late = true;

if (!$fines) {
	//math for strikes
$timeDue = date(strtotime($row_Recordset1['ExpectedDateIn']));
$timeIn = date(strtotime("now"));
$diff = abs($timeIn - $timeDue);
if ($diff > $fineFreq) {
	$strikeGain = round($diff/$fineFreq);
	if ($strikeGain > $maxStrike) { $strikeGain = $maxStrike; }
		} else {
			$strikeGain = 1;
			}
		}
}
?>

Checking in a <?php echo $row_Recordset1['Name']; ?> on <? echo date("D, F j, g:i a") ?> 

<br>
This item was due on <? echo date("D, F j, g:i a", strtotime($row_Recordset1['ExpectedDateIn']));
if($late){
echo "<P><strong><font color=\"#FF0000\">THIS ITEM IS LATE</font></strong>";
}
?>
<br>
<br>

<? if ($row_Recordset1['Image'] != "") { ?>
<IMG SRC="<?php echo $row_Recordset1['Image']; ?>"><br>
<? } ?>

Serial Number: <?php echo $row_Recordset1['SerialNumber']; ?><br>
Model Number: <?php echo $row_Recordset1['ModelNumber']; ?><br>

<HR>
<FONT COLOR="red">Check to make sure all the items listed below are in the kit.  If something
is missing, do not check the kit in!  Ask the student to find the missing
item.  If they cannot find it, note what is missing in the box below and
check the "Report a Problem" option when checking in the kit.</FONT>
<p>
Accessories: <?php echo $row_Recordset1['Accessories']; ?>
<p>
<form action="checkinaction.php" method="post">
Notes:
<textarea cols=60 rows=5 name="Notes">
<? echo $row_Recordset1['CheckedOutNotes']; ?>
</textarea><br />
<p><input type="checkbox" name="Problem"> Report a Problem (this sends an email to the check-in adminstrator).<br></p>

<input type="hidden" name="User" value="<? echo $Username ?>">
<input type="hidden" name="CheckedOutID" value="<? echo $CheckedOutID ?>">
<input type="hidden" name="KitID" value="<? echo $KitID ?>">
<input type="hidden" name="StudentID" value="<? echo $StudentID ?>">
<input type="hidden" name="ReturnDate" value="<? echo $returndateSQL ?>">
<input type="hidden" name="ModelNumber" value="<? echo $row_Recordset1['ModelNumber'] ?>">
<input type="hidden" name="KitName" value="<? echo $row_Recordset1['Name'] ?>">
<input type="hidden" name="FirstName" value="<? echo $FirstName ?>">
<input type="hidden" name="LastName" value="<? echo $LastName ?>">
<? if($late){ ?>
<input type="hidden" name="Late" value="true">
<input type="hidden" name="strikeGain" value="<? echo $strikeGain; ?>">
<? } ?>
<p><input type="submit" name="Submit" value="Check In"> <input type="button" name="back" value="Cancel" onClick="javascript:history.back();"></p>
<br>
</form>

<? 
include 'includes/footer.html';
mysql_free_result($Recordset1);
?>
