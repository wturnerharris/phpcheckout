<?php
require_once('config.php'); 

$renew = $_REQUEST['renew'];

$CheckOutID = $_REQUEST['CheckOutID'];
$KitName = $_REQUEST['KitName'];
$ReturnDate = $_REQUEST['ReturnDate'];
$FirstName = $_REQUEST['FirstName'];
$LastName = $_REQUEST['LastName'];
$StudentID = $_REQUEST['StudentID'];
$KitID = $_REQUEST['KitID'];
$Accessories = $_REQUEST['Accessories'];
if (!empty($Accessories)){
	$AccessoryAdded = " Accessories='$Accessories',";
} else {
	$AccessoryAdded = "";
}
$Notes = $_REQUEST['Notes'];

if (isset($renew)) {

include('includes/heading.html');

$renewal = "UPDATE checkedout SET ExpectedDateIn='$ReturnDate', Notes='$Notes',$AccessoryAdded CheckoutUser='$Username', ReserveDate=null WHERE KitID='$KitID' AND StudentID='$StudentID' AND ID='$CheckOutID'";
mysql_select_db($database_equip, $equip);
mysql_query($renewal, $equip) or die(mysql_error());

?>
<meta http-equiv="refresh" content="10;URL=studentinfo.php?StudentID=<? echo $StudentID; ?>">

<center><h1>Item Renewed</h1></center>
<strong><h2>Summary</h2></strong>
<br>
<div id="tag-br">
	<div id="tag-top"><?php echo $FirstName; ?> <?php echo $LastName; ?></div>
	<div id="tag-info"> has renewed the <?php echo $KitName; ?>.</div>
</div>
<div id="tag-br">
	<div id="options">With the following accessories: <? if ($Accessories != ""){ echo $Accessories; } else { echo "N/A"; } ?><br/></div>
</div>
<div id="tag-br">
	<div id="tag">Beginning:</div>
	<div id="tag-info"><? echo date("D, F j, g:i a"); ?></div>
</div>
<div id="tag-br">
	<div id="tag">Due Back:</div>
	<div id="tag-info"><span id="changeDate"><i class="alert"><? echo date("D, F j", strtotime($ReturnDate)); ?></i></span>, BEFORE <? echo date("g:i a", strtotime($ReturnDate));?></div>
</div>

<p><em>Please print now for a receipt. Otherwise this page will refresh automatically in 10 seconds. </em></p><br/>
Return to <a href="studentinfo.php?StudentID=<? echo $StudentID; ?>">Student Info Page</a><br />

<? include('includes/footer.html'); 

} else {

$dayDate = date("D");
$dayToday = date("l");

if ($dayDate == $dayClosed1 || $dayDate == $dayClosed2) {
	include('studentinfo.php');
	echo "<meta http-equiv='refresh' content='3;URL=studentinfo.php?StudentID=$StudentID'>";
	echo "<div id='alert' style='visibility: visible;'>Not open on ".$dayToday."s<br />";
	echo "Checkout Unavailable</div>";

} else {

include('includes/heading.html');

mysql_select_db($database_equip, $equip);
$query_Lates = sprintf("SELECT * FROM checkedout WHERE StudentID = '$StudentID' AND DateIn = '' ORDER BY ExpectedDateIn");
$Lates = mysql_query($query_Lates, $equip) or die(mysql_error());
$row_Lates = mysql_fetch_assoc($Lates);
$totalRows_Lates = mysql_num_rows($Lates);

if ($totalRows_Lates !=0 && intval(strtotime($row_Lates['ExpectedDateIn'])) < intval(strtotime("now"))) {
		echo "<meta http-equiv='refresh' content='3;URL=studentinfo.php?StudentID=$StudentID'>";
		echo "<p><span class='alert'>STUDENT HAS ITEM(S) THAT ARE LATE!</span></p>";
		echo "<p>No items can be renewed by this student until all LATE items are returned and/or fines have been lifted and paid.</p>";
		echo "<p><a href='studentinfo.php?StudentID=$StudentID'>Check-in late item(s)</a>";
		include('includes/footer.html');
		mysql_free_result($Lates);
} else {

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
function changeMonth() {
	now = new Date();
	returnDate = $("ReturnDate").value.substr(5,2);
	originalDate =  $("OriginalDate").value.substr(5,2);
	if (originalDate - returnDate !=0) {
		months = new Array(13);
		months[0]  = "January";
		months[1]  = "February";
		months[2]  = "March";
		months[3]  = "April";
		months[4]  = "May";
		months[5]  = "June";
		months[6]  = "July";
		months[7]  = "August";
		months[8]  = "September";
		months[9]  = "October";
		months[10] = "November";
		months[11] = "December";
		months[12] = "January";
	var monthnumber = now.getMonth() + 2;
	var monthname   = months[monthnumber];
	$('newMonth').firstChild.nodeValue = monthname;
	} else {
		months = new Array(13);
		months[0]  = "January";
		months[1]  = "February";
		months[2]  = "March";
		months[3]  = "April";
		months[4]  = "May";
		months[5]  = "June";
		months[6]  = "July";
		months[7]  = "August";
		months[8]  = "September";
		months[9]  = "October";
		months[10] = "November";
		months[11] = "December";
		months[12] = "January";
	var monthnumber = now.getMonth();
	var monthname   = months[monthnumber];
	$('newMonth').firstChild.nodeValue = monthname;
	}
}
function modDay0() {
var date = $("OriginalDate").value;
$("ReturnDate").value = $("OriginalDate").value;
$('newDay').firstChild.nodeValue = $('plusNone').value;
$('newDate').firstChild.nodeValue = date.substr(8,2);
changeMonth();
}
function modDay1() 
{
newDay = $('plusOne').value;
newDate = $("plusOneDate").value.substr(8,2);
$("ReturnDate").value = $("plusOneDate").value;
$('newDay').firstChild.nodeValue = newDay;
$('newDate').firstChild.nodeValue = newDate;
//$('newMonth').firstChild.nodeValue = $('plusNone').value;
changeMonth();
}
function modDay2() 
{
newDay = $('plusTwo').value;
newDate = $("plusTwoDate").value.substr(8,2);
$("ReturnDate").value = $("plusTwoDate").value;
$('newDay').firstChild.nodeValue = newDay;
$('newDate').firstChild.nodeValue = newDate;
//$('newMonth').firstChild.nodeValue = $('plusNone').value;
changeMonth();
}
function modDay3() 
{
newDay = $('plusThree').value;
newDate = $("plusThreeDate").value.substr(8,2);
$("ReturnDate").value = $("plusThreeDate").value;
$('newDay').firstChild.nodeValue = newDay;
$('newDate').firstChild.nodeValue = newDate;
//$('newMonth').firstChild.nodeValue = $('plusNone').value;
changeMonth();
}
</script>
<P>
<form name="frmRenew" action="renew.php" method="post">

<input type="hidden" name="FirstName" value="<?php echo $row_Recordset3['FirstName']; ?>">
<input type="hidden" name="LastName" value="<?php echo $row_Recordset3['LastName']; ?>">
<input type="hidden" name="KitName" value="<?php echo $row_Recordset1['Name']; ?>">
<input type="hidden" name="ContractRequired" value="<?php echo $_REQUEST['ContractRequired']; ?>">


<P>
<div id="tag-br">
<div id="tag-top"><?php echo $row_Recordset3['FirstName']; ?> <?php echo $row_Recordset3['LastName']; ?></div>
<div id="tag-info"> is renewing the <?php echo $row_Recordset1['Name']; ?>.</div></div>
<div id="tag-br">
<div id="tag">Renewing:</div>
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
	
	$Month = date('m');
	
//	if ($Month<10) {
//	$Month = "0".$Month;
//	}
	
	$Hours = substr($dueHours,0,2);

	$Minutes = substr($dueHours,3,2);
	
	
	//DUE BACK NEXT DAY / 24 HOURS
	$Day = date('d');


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
	$originalDate = $returndateSQL;
	
	//IF NOT OPEN weekends
	if(!$weekends) {
		if (date("D", strtotime($returndateSQL)) == $dayClosed1) {
			$Day = ($Day + 2);
			echo "<div id='alert' style='visibility: visible;'>Not open on ";
			echo $dayClosed1;
			echo ".<br />Return on next day open...</div>";
			echo "<script type='text/javascript'>";
			echo "setTimeout('hide();',1500);";
			echo "</script>"; 
			$closed = true;
		}
		
		//IS LAST DAY OF MONTH?
		if($Day>$LastDay){
			$Month = ($Month+1);
			$Day = 1;
		}
		
		$returndateSQL = $Year."-".$Month."-".$Day." ".$dueHours;
		
		//RULES FOR SPECIFC DAY CLOSED (PRESUMABLY SUNDAY)
		if (date("D", strtotime($returndateSQL)) == $dayClosed2) {
			$Day = ($Day + 1);
			echo "<div id='alert' >Closed ";
			echo $dayClosed2;
			echo ".<br />Return on next day open...</div>";
			echo "<script type='text/javascript'>";
			echo "setTimeout('hide();',1500);";
			echo "</script>"; 
			$closed = true;
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

	//if reserved, send back to main
	mysql_select_db($database_equip, $equip);
	$r_check = sprintf("SELECT * FROM checkedout WHERE ReserveDate > CURDATE() AND KitID = '$KitID'");
	$res = mysql_query($r_check, $equip) or die(mysql_error());
	$row_res = mysql_fetch_assoc($res);
	$totalRows_res = mysql_num_rows($res);
	$rtndate = substr($returndateSQL,0,10);
	$rtndate2 = date('Y-m-d',strtotime($rtndate.'-1 day'));
	$today = date('Y-m-d',strtotime('now'));
	$tomorrow = date('Y-m-d',strtotime('now +1 day'));
	//echo $rtndate;
	if ($totalRows_res > 0) {
		$reserved_array = array();
		mysql_data_seek($res,0);
		while ($loopReserved = mysql_fetch_assoc($res)) {
	  		array_push($reserved_array, $loopReserved['ReserveDate']);
		}
		//print_r($reserved_array);
		if (in_array($rtndate2, $reserved_array) || $closed == true){
			echo "<meta http-equiv='refresh' content='3;URL=studentinfo.php?StudentID=$StudentID'>";
			echo "<div id='overlay'></div>";
			echo "<div id='alert' class='alert' style='visibility: visible;'>It looks like someone reserved this.<br/>Please check this in.<br/><br/>";
			echo "Returning to Student Info.</div>";
		} elseif (in_array($rtndate, $reserved_array)){
			echo "<div id='alert' class='alert' style='visibility: visible;'>It looks like someone reserved this. You can renew this only for one day.<br/>This must be returned tomorrow!<br/><br/></div>";
			$returndateSQL = date('Y-m-d H:i:s',strtotime($returndateSQL.'-1 day'));
			echo "<script type='text/javascript'>";
			echo "setTimeout('hide();',3000);";
			echo "</script>"; 
		} elseif (strtotime($originalDate.'- 2 days') < strtotime($today)){
			echo "<meta http-equiv='refresh' content='3;URL=studentinfo.php?StudentID=$StudentID'>";
			echo "<div id='alert' class='alert' style='visibility: visible;'>You're trying to check out this reservation too early.<br/><br/>";
			echo "Returning to Student Info.</div>";
		}
	}
?>
<span id="newDay"><? echo date("D", strtotime($returndateSQL));?></span>, <span id="newMonth"><? echo date("F", strtotime($returndateSQL));?></span> <span id="newDate"><? echo date("d", strtotime($returndateSQL));?></span>, BEFORE <? echo date("g:i a", strtotime($returndateSQL));?></div></div>
<div id="options">
Options:
<label><input id="chkBox0" name="chkBox" type="radio" value="0" onClick="modDay0();" checked="checked" />Reset</label>
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
$plusThree = addDate($returndateSQL,3);

?>
<input type="hidden" id="plusNone" name="plusNone" value="<? echo date("D", strtotime($returndateSQL)); ?>">
<input type="hidden" id="plusOne" name="plusOne" value="<? echo date("D", strtotime($plusOne)); ?>">
<input type="hidden" id="plusOneDate" name="plusOneDate" value="<? echo date("Y-m-d", strtotime($plusOne))." ".$dueHours; ?>">
<input type="hidden" id="plusTwo" name="plusTwo" value="<? echo date("D", strtotime($plusTwo)); ?>">
<input type="hidden" id="plusTwoDate" name="plusTwoDate" value="<? echo date("Y-m-d", strtotime($plusTwo))." ".$dueHours; ?>">
<input type="hidden" id="plusThree" name="plusThree" value="<? echo date("D", strtotime($plusThree)); ?>">
<input type="hidden" id="plusThreeDate" name="plusThreeDate" value="<? echo date("Y-m-d", strtotime($plusThree))." ".$dueHours; ?>">
<input type="hidden" id="OriginalDate" name="OriginalDate" value="<? echo date("Y-m-d H:i:s", strtotime($returndateSQL)); ?>">
<input type="hidden" id="ReturnDate" name="ReturnDate" value="<? echo date("Y-m-d H:i:s", strtotime($returndateSQL)); ?>">
<input type="hidden" id="renew" name="renew" value="yes">
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
    echo("<IMG SRC=\"images/$Image\" width='75%' height='75%'>");
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
<i>LAB AIDS: Check off all accessories in bags. If an accessory is not in the bag
do not check it off.</i>

<input type="hidden" name="KitID" value="<? echo $KitID; ?>">
<input type="hidden" name="StudentID" value="<? echo $StudentID; ?>">
<input type="hidden" name="CheckOutID" value="<? echo $CheckOutID; ?>">
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
<p><input type="submit" name="Submit" value="Renew"> <input type="button" name="back" value="Cancel" onClick="javascript:history.back();"></p>

</form>

<? 
include('includes/footer.html'); 
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
}}}
?>
