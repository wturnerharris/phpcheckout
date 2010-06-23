<?php
require_once('config.php');
include('includes/heading.html'); 

mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT students.FirstName AS FirstName, students.LastName AS LastName, students.Email AS Email, students.StudentID AS StudentID, kit.ID AS KitID, checkedout.ID AS CheckOutID, kit.Name, checkedout.DateOut, checkedout.ExpectedDateIn FROM checkedout LEFT JOIN students ON students.StudentID = checkedout.StudentID LEFT JOIN kit ON kit.ID = checkedout.KitID WHERE DateIn = '' AND DateOut <= UTC_TIMESTAMP() ORDER BY checkedout.ExpectedDateIn";
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


if($totalRows_Recordset1>0) {  

echo "<center><strong><h1>Currently Checked Out</h1></strong></center><p>";

do { 
	
	echo "<div id='checked-entry'>";
	
	//if late show notice and late email link
	if (intval(strtotime($row_Recordset1['ExpectedDateIn'])) < intval(strtotime("now"))) {
		echo "<p><strong><font color=\"#FF0000\">THIS ITEM IS LATE (";
		echo "<a href=\"late_email.php?StudentID=".$row_Recordset1['StudentID']."&CheckOutID=".$row_Recordset1['CheckOutID']."\">EMAIL LATE NOTICE</a>)</font></strong></p>";
	}
?>
	<strong>Equipment Checked Out:</strong> <?php echo $row_Recordset1['Name']; ?><br> 
	<strong>Student Name: </strong><?php echo $row_Recordset1['FirstName']; ?> <?php echo $row_Recordset1['LastName']; ?><br>
	<strong>Student ID: </strong><a href="studentinfo.php?StudentID=<?php echo $row_Recordset1['StudentID']; ?>"><?php echo $row_Recordset1['StudentID']; ?></a><br>
	<strong>Email: </strong><?php echo $row_Recordset1['Email']; ?><br>
	<strong>Check In: </strong><a href="checkin.php?CheckOutID=<?php echo $row_Recordset1['CheckOutID']; ?>&KitID=<?php echo $row_Recordset1['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>">Check Item In</a> | <a href="renew.php?CheckOutID=<?php echo $row_Recordset1['CheckOutID']; ?>&KitID=<?php echo $row_Recordset1['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>" title="Renew">Renew</a><br>
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
 
echo "<center><strong><h1>All Equipment Checked In</h1></strong></center><p>";
 }

mysql_free_result($Recordset1);
include('includes/footer.html'); 
?>

