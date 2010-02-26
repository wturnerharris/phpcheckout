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
<script type="text/javascript">
function modDay0() 
{
var date = $("OriginalDate").value;
var begin = date.substr(0,8);
var day = date.substr(8,2);
var end = date.substr(10,9);
$("ReturnDate").value = $("OriginalDate").value;
var newDay = $('plusNone').value;
var Date1 = $('changeDate').firstChild.nodeValue;
var Date2 = Date1.substr(0,Date1.length-2) +  day;
var newDate = newDay + Date2.substr(3,Date1.length);
$('changeDate').firstChild.nodeValue = newDate;

}
function modDay1() 
{
var date = $("OriginalDate").value;
var begin = date.substr(0,8);
var day = date.substr(8,2);
var addDay = parseFloat(day)+ 1;
var end = date.substr(10,9);
$("ReturnDate").value = begin+addDay+end;
var newDay = $('plusOne').value;
var Date1 = $('changeDate').firstChild.nodeValue;
var Date2 = Date1.substr(0,Date1.length-2) +  addDay;
var newDate = newDay + Date2.substr(3,Date1.length);
$('changeDate').firstChild.nodeValue = newDate;
}
function modDay2() 
{
var date = $("OriginalDate").value;
var begin = date.substr(0,8);
var day = date.substr(8,2);
var addDay = parseFloat(day)+ 2;
var end = date.substr(10,9);
$("ReturnDate").value = begin+addDay+end;
var newDay = $('plusTwo').value;
var Date1 = $('changeDate').firstChild.nodeValue;
var Date2 = Date1.substr(0,Date1.length-2) +  addDay;
var newDate = newDay + Date2.substr(3,Date1.length);
$('changeDate').firstChild.nodeValue = newDate;
}
function divClose() {
	$('alert').style.visibility = "hidden";
}
</script>
<P>
<form name="frmCheckOut" action="checkoutaction.php" method="post">

<input type="hidden" name="FirstName" value="<?php echo $row_Recordset3['FirstName']; ?>">
<input type="hidden" name="LastName" value="<?php echo $row_Recordset3['LastName']; ?>">
<input type="hidden" name="KitName" value="<?php echo $row_Recordset1['Name']; ?>">
<input type="hidden" name="ContractRequired" value="<?php echo $_REQUEST['ContractRequired']; ?>">


<P>
<div id="tag-br">
<div id="tag-top"><?php echo $row_Recordset3['FirstName']; ?> <?php echo $row_Recordset3['LastName']; ?></div>
<div id="tag-info"> is checking out the <?php echo $row_Recordset1['Name']; ?>.</div></div>
<div id="tag-br">
<div id="tag">Checking Out:</div>
<div id="tag-info">
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
<?php echo date("D, F d, g:i a"); ?></div></div>
<div id="tag-br">
<div id="tag">Due Back:</div>
<div id="tag-info">
<?php 

	$Year = date('Y');
	
	$Month = date('n');
	
	if ($Month<10) {
	$Month = "0".$Month;
	}
	
	$Hours = "17";

	$Minutes = "00";
	
	
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
		
	$returndateSQL = $Year."-".$Month."-".$Day." ".$dueHours;
	
	//IF NOT OPEN weekends
	if(!$weekends) {
		if (date("D", strtotime($returndateSQL)) == $dayClosed1) {
			$Day = ($Day + 2);
			echo "<div id='alert' style='visibility: visible;'>Not open on ";
			echo $dayClosed1;
			echo ".<br />Return on next day open...</div>";
			echo "<script type='text/javascript'>";
			echo "setTimeout('divClose();',3000);";
			echo "</script>"; 
		}
		
		//IS LAST DAY OF MONTH?
		if($Day>$LastDay){
			$Month = ($Month+1);
			$Day = 1;
		}
		
		$returndateSQL = $Year."-".$Month."-".$Day." ".$dueHours;
		
		//RULES FOR SPECIFC DAY CLOSED
		if (date("D", strtotime($returndateSQL)) == $dayClosed2) {
			$Day = ($Day + 1);
			echo "<div id='alert' style='visibility: visible;'>Closed ";
			echo $dayClosed2;
			echo ".<br />Return on next day open...</div>";
			echo "<script type='text/javascript'>";
			echo "setTimeout('divClose();',3000);";
			echo "</script>"; 
		}
		
		//IS LAST DAY OF MONTH?
		if($Day>$LastDay){
			$Month = ($Month+1);
			$Day = 1;
		}
	}
	
	$returndateSQL = $Year."-".$Month."-".$Day." ".$dueHours;
	
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
	$returndateSQL = $Year."-".$Month."-".$Day." ".$dueHours;

?>
<span id="changeDate"><? echo date("D, F d", strtotime($returndateSQL));?></span>, BEFORE <? echo date("g:i a", strtotime($returndateSQL));?></div></div>
<div id="options">
Options:
<label><input name="chkBox" type="radio" id="chkBox0" onClick="modDay0();" value="0" checked="checked" />Reset</label>
<label><input id="chkBox1" name="chkBox" type="radio" value="1" onClick="modDay1();" />+1 Day</label>
<label><input id="chkBox2" name="chkBox" type="radio" value="2" onClick="modDay2();" />+2 Days</label>
</div>
<? 
function addDate($date,$day)//add days
{
$sum = strtotime(date("Y-m-d", strtotime("$date")) . " +$day days");
$dateTo=date('Y-m-d',$sum);
return $dateTo;
}
$plusOne = addDate($returndateSQL,1);
$plusTwo = addDate($returndateSQL,2);

?>
<input type="hidden" id="plusNone" name="plusNone" value="<? echo date("D", strtotime($returndateSQL)); ?>">
<input type="hidden" id="plusOne" name="plusOne" value="<? echo date("D", strtotime($plusOne)); ?>">
<input type="hidden" id="plusTwo" name="plusTwo" value="<? echo date("D", strtotime($plusTwo)); ?>">
<input type="hidden" id="OriginalDate" name="OriginalDate" value="<? echo $returndateSQL;?>">
<input type="hidden" id="ReturnDate" name="ReturnDate" value="<? echo $returndateSQL;?>">
</span>
<? 
if ($row_Recordset1['FineAmount']!="") { 
 echo "Fine: $" . number_format($fineAmount,2); 
 echo  " per ";
 echo $fineFreq/60;
 echo " Minutes.";
 } 
?>
<div id="tag-br"></div>
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
if ($AccessoryName=""){
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
<input disabled="true" type="submit" name="Submit" value="Check Out">

</form>

<? 
include('includes/footer.html'); 
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
?>
