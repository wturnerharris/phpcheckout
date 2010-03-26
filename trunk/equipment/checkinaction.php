<?php
require_once('config.php'); 
include('includes/heading.html');

$CheckInUser = $_REQUEST['User'];
$CheckedOutID = $_REQUEST['CheckedOutID'];
$Notes = $_REQUEST['Notes'];
$ModelNumber = $_REQUEST['ModelNumber'];
$KitName = $_REQUEST['KitName'];
$KitID = $_REQUEST['KitID'];
$StudentID = $_REQUEST['StudentID'];
$FirstName = $_REQUEST['FirstName'];
$LastName = $_REQUEST['LastName'];
$ReturnDate = $_REQUEST['ReturnDate'];
$strikeGain = $_REQUEST['strikeGain'];
if (!$fines) {
	$frequency = $gracePeriod;
} else {
	$frequency = $fineFreq;
}
$late = $_REQUEST['Late'];

if (!isset($late)) {
	$late = false;
} else {
	$late = true;
}

//$CheckInUser = $HTTP_COOKIE_VARS["EquipmentCheckout"];

if($_REQUEST['Problem']=="on"){
$Problem = 1;

$message = "There has been a problem with the checkout of $KitName - $ModelNumber\r\n\r\n$Notes\r\n\r\n";

$message = $message . "".$site_root.$root."/kithistory.php?KitID=$KitID";

if (isset($admin_email1)) {
mail("$admin_email1", "SYSTEM MESSAGE - Checkout Problem with $KitName", $message,
     "From: \"$CheckInUser\" <$admin_email1>\r\n" .
     "Reply-To: \"$CheckInUser\" <$admin_email1>\r\n" .
     "X-Mailer: PHP/" . phpversion());
}
if (isset($admin_email2)) {
mail("$admin_email2", "SYSTEM MESSAGE - Checkout Problem with $KitName", $message,
     "From: \"$CheckInUser\" <$admin_email2>\r\n" .
     "Reply-To: \"$CheckInUser\" <$admin_email2>\r\n" .
     "X-Mailer: PHP/" . phpversion());
}     
if (isset($admin_email3)) {
mail("$admin_email3", "SYSTEM MESSAGE - Checkout Problem with $KitName", $message,
     "From: \"$CheckInUser\" <$admin_email3>\r\n" .
     "Reply-To: \"$CheckInUser\" <$admin_email3>\r\n" .
     "X-Mailer: PHP/" . phpversion());
}
echo "Email sent to checkout administrator(s)<p>";
     
} else {
$Problem = 0;
}

//NOW DO STIKE CHECKING AND EITHER WARN, TEMPORARILY BAN, OR PERMANENTLY BAN
if (!$fines) {
	if ($late) {
		mysql_select_db($database_equip, $equip);
		$strikesTotal = "SELECT SUM(Strike) FROM checkedout WHERE (unix_timestamp(DateIn) - $frequency) > unix_timestamp(ExpectedDateIn) AND Strike >= 1 AND StudentID = \"$StudentID\"";
		$strikesQuery = mysql_query($strikesTotal, $equip) or die(mysql_error());
		$strikesResult = mysql_result($strikesQuery, 0);
		if (!$strikesResult) {
		//1st late
		//$strikeCount = 1;
		$penaltyNotice = "This is a warning. The next late return will result in a two-week ban.";
		} elseif ($strikesResult == 1) {
		//2nd late
		//$strikeCount = 1;
		$penaltyNotice = "This student now has a TWO-WEEK BAN.";
		$banDuration = 14;
		$BannedDate = date("Y-m-d H:i:s",mktime(17, 0, 0, date("m"), date("d")+$banDuration, date("Y")));
		} elseif ($strikesResult == 2) {
		//3rd late
		//$strikeCount = 1;
		$penaltyNotice = "This student is banned for the duration of the semester.";
		}
	}
}
mysql_select_db($database_equip, $equip);
if (isset($BannedDate)) {
	 $insertBan = "BannedDate = '$BannedDate',";
} else {
	$insertBan = "";
}
$sql = "UPDATE checkedout SET DateIn = NOW(), Problem = $Problem, Notes = '$Notes',$insertBan Strike = '$strikeGain', CheckInUser = '$CheckInUser' WHERE ID = $CheckedOutID;";
//echo $sql;
$Recordset1 = mysql_query($sql, $equip) or die(mysql_error());

?>
<meta http-equiv="refresh" content="10;URL=studentinfo.php?StudentID=<? echo $StudentID; ?>">

<center><h1>Item Returned</h1></center>
<strong><h2>Summary</h2></strong>
<? if ($late) { ?>
<p class="alert">THIS ITEM WAS LATE</p>
<? if (!$fines) { ?>
<p class="alert">This student now has <? echo $strikeGain + $strikesResult; ?> strike(s). <br>NOTICE: <? echo $penaltyNotice; ?></p>
<? }} else {
echo "<p>".$penaltyNotice."</p>";
}
?>
<p>Equipment: <? echo $KitName; ?><br/>
Checked out by: <? echo $FirstName; ?> <? echo $LastName; ?><br/>
Was returned: <? echo date("D, F j, g:i a"); ?>
</p>
<p><em>This page will refresh automatically in 10 seconds. Please print now for a receipt.</em></p><br/>
Return to <a href="studentinfo.php?StudentID=<? echo $StudentID; ?>">Student Info Page</a><br />

<? include('includes/footer.html');  ?>