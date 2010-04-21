<?php
require_once('config.php');
include('includes/heading.html'); 

mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT kit.ID AS KitID, checkedout.ID AS CheckOutID, checkedout.ReserveDate AS ReserveDate, students.Email AS Email, students.StudentID AS StudentID, students.FirstName AS FirstName, students.LastName AS LastName, kit.Name, checkedout.DateOut, checkedout.ExpectedDateIn FROM checkedout LEFT JOIN students ON students.StudentID = checkedout.StudentID LEFT JOIN kit ON kit.ID = checkedout.KitID WHERE DateIn = '' AND ReserveDate >= CURDATE() ORDER BY checkedout.ExpectedDateIn";
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if($totalRows_Recordset1>0) {  

echo "<center><strong><h1>Currently Reserved</h1></strong></center><p>";

mysql_select_db($database_kit, $equip);
$query_Recordset4 = sprintf("SELECT kit.ID AS KitID, checkedout.ID AS CheckOutID, kit.Name, checkedout.DateOut, checkedout.ExpectedDateIn FROM checkedout INNER JOIN kit ON kit.ID = checkedout.KitID WHERE checkedout.DateIn = '' AND ReserveDate >= CURDATE() AND StudentID = \"$StudentID\"");
//echo $query_Recordset4 ;
$Recordset4 = mysql_query($query_Recordset4, $equip) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

do { 
	
?>
	<strong>Equipment Reserved:</strong> <?php echo $row_Recordset1['Name']; ?><BR> 
	<strong>Student Name: </strong><?php echo $row_Recordset1['FirstName']; ?> <?php echo $row_Recordset1['LastName']; ?><br>
	<strong>Student ID: </strong><a href="studentinfo.php?StudentID=<?php echo $row_Recordset1['StudentID']; ?>"><?php echo $row_Recordset1['StudentID']; ?></a><br>
	<strong>Email: </strong><?php echo $row_Recordset1['Email']; ?><br>
	<strong>Reservation: </strong><a href="renew.php?CheckOutID=<?php echo $row_Recordset1['CheckOutID']; ?>&KitID=<?php echo $row_Recordset1['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>">Check Item Out</a> | <a href="cancel_res.php?CheckOutID=<?php echo $row_Recordset1['CheckOutID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>" title="Cancel">Cancel</a><br>
    <?php 
echo '<strong>Reservation Date: </strong>';
//echo $row_Recordset1['DateOut'];
//echo strtotime($row_Recordset1['DateOut']);
echo date("D, F j", strtotime($row_Recordset1['DateOut'])); 
echo '<br>';
echo '<strong>Expected Return Date: </strong>'; 


echo date("D, F j, g:i a", strtotime($row_Recordset1['ExpectedDateIn'])); 
if (intval(strtotime($row_Recordset1['ExpectedDateIn'])) < intval(strtotime("now"))) {
echo "<strong><font color=\"#FF0000\"> -- THIS ITEM IS LATE</font></strong>";
}
echo '<P>';
echo '<hr />';

 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
 } else {
 
echo "<center><strong><h1>No Reservations</h1></strong></center><p>";
 }

mysql_free_result($Recordset1);
include('includes/footer.html'); 
?>

