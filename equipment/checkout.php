<?php 

/* Things yet to do: check for greatest check out time and default to that
	multiple kit listing with multiple classes
	renewal system - reservation system
*/

require_once('config.php'); 
include('includes/heading.html');

$KitID = $_REQUEST['KitID'];
$StudentID = $_REQUEST['StudentID'];

mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT * FROM kit WHERE ID = $KitID");
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT * FROM kit_accessorytype INNER JOIN accessorytype ON accessorytype.ID = kit_accessorytype.AccessorytypeID WHERE KitID = $KitID;");
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_equip, $equip);
$query_Recordset3 = sprintf("SELECT * FROM students WHERE StudentID = $StudentID");
$Recordset3 = mysql_query($query_Recordset3, $equip) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_equip, $equip);
$query_Recordset4 = sprintf("SELECT * FROM kit_class INNER JOIN student_class ON student_class.ClassID = kit_class.ClassID WHERE student_class.StudentID = $StudentID AND kit_class.kitID = $KitID");
$Recordset4 = mysql_query($query_Recordset4, $equip) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4); 

if ($row_Recordset1['ContractRequired'] == 1) { 
echo("<b>Student must sign an individual contract for this kit.</b>");
}
?>
<P>
<form name="frmCheckOut" action="checkoutaction.php" method="post">

<input type="hidden" name="FirstName" value="<?php echo $row_Recordset3['FirstName']; ?>">
<input type="hidden" name="LastName" value="<?php echo $row_Recordset3['LastName']; ?>">
<input type="hidden" name="KitName" value="<?php echo $row_Recordset1['Name']; ?>">
<input type="hidden" name="ContractRequired" value="<?php echo $_REQUEST['ContractRequired']; ?>">


<P>
<strong><?php echo $row_Recordset3['FirstName']; ?> <?php echo $row_Recordset3['LastName']; ?></strong> is
 checking out a <strong><?php echo $row_Recordset1['Name']; ?></strong><br>
 Checked Out:<strong> 
 
 <?php 
 $ServerCheckHours = 0;
 do {
 	if($row_Recordset4['CheckHours'] > $ServerCheckHours){
 		$ServerCheckHours = $row_Recordset4['CheckHours'];
	}
	if($row_Recordset4['OverNightAllowed'] > $overNight){
		$overNight = $row_Recordset4['OverNightAllowed'];
	}
} while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); 
 ?>
 
<?php 

echo date("D, F j, g:i a") 
?>
 </strong><br>
Due Back:

<?php 

	$Year = date('Y');
	
	$Month = date('n');
	
	if ($Month<10) {
	$Month = "0".$Month;
	}
	
	$Hours = date('G');
	
	if ($Hours < 10) {
	$Hours = "0".$Hours;
	}

	$Minutes = date('i');
	
	
	//DUE BACK NEXT DAY / 24 HOURS
	$Day = date('j');


	//LOGIC FOR END OF MONTH
	
	switch($Month){
	
	case 1:
		$LastDay = 31;
		break;
	case 2:
		$LastDay = 28;
		break;
	case 3:
		$LastDay = 31;
		break;
	case 4:
		$LastDay = 30;
		break;
	case 5:
		$LastDay = 31;
		break;
	case 6:
		$LastDay = 31;
		break;
	case 7:
		$LastDay = 31;
		break;
	case 8:
		$LastDay = 30;
		break;
	case 9:
		$LastDay = 31;
		break;		
	case 10:
		$LastDay = 30;
		break;
	case 11:
		$LastDay = 30;
		break;		
	case 12:
		$LastDay = 31;
		break;	
	}
	
	if (($ServerCheckHours + date('G')) < 24) {
		$Hours = ($Hours + $ServerCheckHours);
	}
	else if ($ServerCheckHours == 24 && $overNight) {
		$Day = ($Day+1);
	} else {
		$Hours = 23; // this sets it to 11pm instead of going to next day, further down this is reset to correspond to closeTimes.
	}
	
	if ($ServerCheckHours > 24 && overNight) {
		$Day = $Day + round($ServerCheckHours/24);
		$Hours = $Hours + round(($ServerCheckHours%24)*24);
	}


	//IS LAST DAY OF MONTH?
	if($Day>$LastDay){
		$Month = ($Month+1);
		$Day = 1;
	}
		
	$returndateSQL = $Year."-".$Month."-".$Day." ".$Hours.":".$Minutes.":00";
	
	//IF NOT OPEN weekends
	if(!$weekends) {
		if (date("D", strtotime($returndateSQL)) == "Sat") {
			$Day = ($Day + 1);
			echo "<P> saturday found moving to next day";
		}
		
		//IS LAST DAY OF MONTH?
		if($Day>$LastDay){
			$Month = ($Month+1);
			$Day = 1;
		}
		
		$returndateSQL = $Year."-".$Month."-".$Day." ".$Hours.":".$Minutes.":00";
		
		//IF NOT OPEN SUNDAY
		if (date("D", strtotime($returndateSQL)) == "Sun") {
			$Day = ($Day + 1);
			echo "<P> sunday found moving to next day";
		}
		
		//IS LAST DAY OF MONTH?
		if($Day>$LastDay){
			$Month = ($Month+1);
			$Day = 1;
		}
	}
	
	$returndateSQL = $Year."-".$Month."-".$Day." ".$Hours.":".$Minutes.":00";
	
	// figure out hours here
	switch (date("D",strtotime($returndateSQL))) {
	
		case "Sun" : 
					$openTime = $sunOpen;
					$closeTime = $sunClose;
					break;
		case "Mon" :
					$openTime = $monOpen;
					$closeTime = $monClose;
					break;
		case "Tue" :
					$openTime = $tueOpen;
					$closeTime = $tueClose;
					break;
		case "Wed" :
					$openTime = $wedOpen;
					$closeTime = $wedClose;
					break;
		case "Thu" :
					$openTime = $thuOpen;
					$closeTime = $thuClose;
					break;
		case "Fri" :
					$openTime = $friOpen;
					$closeTime = $friClose;
					break;
		case "Sat" :
					$openTime = $satOpen;
					$closeTime = $satClose;
					break;
	}
	
	if ($Hours <= $openTime) {
		$Hours = $openTime;
		if ($Minutes < 30) {
			$Minutes = 30;
		}
	}
	
	if ($Hours >= $closeTime-1) {
		$Hours = $closeTime-1;
		if ($Minutes > 30) {
			$Minutes = 30;
		}
	}
	
	//date formate for sql 0000-00-00 00:00:00
	$returndateSQL = $Year."-".$Month."-".$Day." ".$Hours.":".$Minutes.":00";

?>

<strong><? echo date("D, F j, g:i a", strtotime($returndateSQL));?></strong>

<input type="hidden" name="ReturnDate" value="<? echo $returndateSQL;?>">

<br>
<? 
if ($row_Recordset1['FineAmount']!="") { 
 echo "Fine: $" . number_format($fineAmount,2); 
 echo  " per ";
 echo $fineFreq/60;
 echo " Minutes.";
 } 
?>

 <br>
 <table width="40%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> Item: <?php echo $row_Recordset1['Name']; ?></td>
  </tr>
  <tr>
    <td><div align="center">
    <? 
    $Image = $row_Recordset1['Image'];
    if($Image!=""){ 
    echo("<IMG SRC=\"images/$Image\">");
    echo("<p>IMG SRC=\"images/$Image\"</p>");
    }?>
    <br>
    </div></td>
  </tr>
  <tr>
    <td>Serial Number: <?php echo $row_Recordset1['SerialNumber']; ?><br></td>
  </tr>
   <tr>
    <td>Model Number: <?php echo $row_Recordset1['ModelNumber']; ?><br></td>
  </tr>
</table>






 <br>
 <HR>
<u><strong>Be sure these accessories are included:</strong></u> <br>
<i>LAB AIDS: Check off all accessories in bags. If accessory is not in the bag
do not check off.</i>

<input type="hidden" name="KitID" value="<? echo $KitID ?>">
<input type="hidden" name="StudentID" value="<? echo $StudentID ?>">
<input type="hidden" name="ReturnDate" value="<? echo $returndateSQL ?>">
<P>
<?
if ($AccessoryName!=""){
	echo"<p>No Accessories are available for this item.</p>";
} else {
$i = 0;
do { 
$AccessoryName = $row_Recordset2['Name'];
echo"<input name=\"Accessory$i\" type=\"checkbox\" value=\"$AccessoryName\">";
echo $AccessoryName ."<br>";
$i++;
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); 
}
?>
<P>
Notes:<br>
<textarea cols=60 rows=5 name="Notes"></textarea><br>
<input type="submit" name="Submit" value="Check Out">

</form>

<? 
include('includes/footer.html'); 
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
?>
