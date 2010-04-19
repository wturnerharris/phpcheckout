<?php
require_once('config.php');
include('includes/heading.html'); 

mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT * FROM checkedout LEFT JOIN students ON students.StudentID = checkedout.StudentID LEFT JOIN kit ON kit.ID = checkedout.KitID WHERE DateIn = '' AND DateOut <= UTC_TIMESTAMP() ORDER BY checkedout.ExpectedDateIn";
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>



  <?
if($row_Recordset1['ID']>0) {  

echo "<center><strong><h1>Currently Checked Out</h1></strong></center><p>";

do { ?>
<?
$StudentID = $row_Recordset1['StudentID'];
mysql_select_db($database_kit, $equip);
$query_Recordset4 = sprintf("SELECT kit.ID AS KitID, checkedout.ID AS CheckOutID, kit.Name, checkedout.DateOut, checkedout.ExpectedDateIn FROM checkedout INNER JOIN kit ON kit.ID = checkedout.KitID WHERE checkedout.DateIn = '' AND DateOut <= UTC_TIMESTAMP() AND StudentID = \"$StudentID\"");
//echo $query_Recordset4 ;
$Recordset4 = mysql_query($query_Recordset4, $equip) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);
?>
	<strong>Equipment Checked Out:</strong> <?php echo $row_Recordset1['Name']; ?><BR> 
	<strong>Student Name: </strong><?php echo $row_Recordset1['FirstName']; ?> <?php echo $row_Recordset1['LastName']; ?><br>
	<strong>Student ID: </strong><a href="studentinfo.php?StudentID=<?php echo $row_Recordset1['StudentID']; ?>"><?php echo $row_Recordset1['StudentID']; ?></a><br>
	<strong>Email: </strong><?php echo $row_Recordset1['Email']; ?><br>
	<strong>Check In: </strong><a href="checkin.php?CheckedOutID=<?php echo $row_Recordset4['CheckOutID']; ?>&KitID=<?php echo $row_Recordset4['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>">Check Item In</a> | <a href="renew.php?CheckedOutID=<?php echo $row_Recordset4['CheckOutID']; ?>&KitID=<?php echo $row_Recordset4['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>" title="Renew">Renew</a><br>
    <?php 
echo '<strong>Date Out: </strong>'; 
//echo $row_Recordset1['DateOut'];
//echo strtotime($row_Recordset1['DateOut']);
echo date("D, F j, g:i a", strtotime($row_Recordset1['DateOut'])); 
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
 
echo "<center><strong><h1>All Equipment Checked In</h1></strong></center><p>";
 }

mysql_free_result($Recordset1);
include('includes/footer.html'); 
?>

