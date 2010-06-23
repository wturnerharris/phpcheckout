<?php 
require_once('config.php');
include('includes/heading.html'); 
if($dueToday) {
	$now = date("Y-m-d ", strtotime('now')).$dueHours;
	$onlyToday = "AND ExpectedDateIn <= '$now'";
} else {
	$onlyToday = "";
}
mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT students.FirstName AS FirstName, students.LastName AS LastName, students.Email AS Email, students.StudentID AS StudentID, kit.ID AS KitID, checkedout.ID AS CheckOutID, kit.Name, checkedout.DateOut, checkedout.ExpectedDateIn FROM checkedout LEFT JOIN students ON students.StudentID = checkedout.StudentID LEFT JOIN kit ON kit.ID = checkedout.KitID WHERE DateIn = '' $onlyToday AND DateOut <= UTC_TIMESTAMP() ORDER BY checkedout.ExpectedDateIn AND DateOut";
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<form name="form" action="studentinfo.php" method="post">
<p><strong>Please swipe student's ID card or enter the student's ID: </strong><br>
<input name="StudentID" class="TextField" type="text" id="StudentID">
<input type="submit" name="Submit" value="Submit">
<br></p>
</form>
<hr/>


  <?php
if($totalRows_Recordset1>0) {  
if($dueToday){
	echo "<font color=\"#FF0000\"><strong><u>Equipment Due Back Today</u></strong><p></font>";
} else {
	echo "<font color=\"#FF0000\"><strong><u>Equipment Currently Checked Out</u></strong><p></font>";
}
do { 
	
	echo "<div id='checked-entry'>";
	
	//if late show notice and late email link
	if (intval(strtotime($row_Recordset1['ExpectedDateIn'])) < intval(strtotime("now"))) {
		echo "<p><strong><font color=\"#FF0000\">THIS ITEM IS LATE (";
		echo "<a href=\"late_email.php?StudentID=".$row_Recordset1['StudentID']."&CheckOutID=".$row_Recordset1['CheckOutID']."\">EMAIL LATE NOTICE</a>)</font></strong></p>";
	}
?>
	<strong>Equipment:</strong> <?php echo $row_Recordset1['Name']; ?><BR> 
	<strong>Student Name: </strong><?php echo $row_Recordset1['FirstName']; ?> <?php echo $row_Recordset1['LastName']; ?><br>
	<strong>Student ID: </strong><a href="studentinfo.php?StudentID=<?php echo $row_Recordset1['StudentID']; ?>"><?php echo $row_Recordset1['StudentID']; ?></a><br>
	<strong>Email: </strong><?php echo $row_Recordset1['Email']; ?><br>
	<strong>Check In: </strong><a href="checkin.php?CheckOutID=<?php echo $row_Recordset1['CheckOutID']; ?>&KitID=<?php echo $row_Recordset1['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>">Check In Item</a> | <a href="renew.php?CheckOutID=<?php echo $row_Recordset1['CheckOutID']; ?>&KitID=<?php echo $row_Recordset1['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>" title="Renew">Renew</a><br>
   
<?php 
	echo '<strong>Date Out: </strong>'; 
	//echo $row_Recordset1['DateOut'];
	//echo strtotime($row_Recordset1['DateOut']);
	echo date("D, F j, g:i a", strtotime($row_Recordset1['DateOut'])); 
	echo '<br>';
	echo '<strong>Expected Return Date: </strong>'; 
	
	
	echo date("D, F j, g:i a", strtotime($row_Recordset1['ExpectedDateIn'])); 
	echo '</p></div>';
	
	} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
	
	} else {
		if($dueToday) {
			echo "<center><strong>NOTHING DUE BACK TODAY</strong></center><p>";
		} else {
			echo "<center><strong>ALL EQUIPMENT CURRENTLY CHECKED IN</strong></center><p>";
		}
	}

	mysql_free_result($Recordset1);
	include('includes/footer.html'); 
?>

