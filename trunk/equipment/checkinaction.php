<?php 
require_once('config.php'); 
include('includes/heading.html');

$CheckedOutID = $_REQUEST['CheckedOutID'];
$Notes = $_REQUEST['Notes'];
$ModelNumber = $_REQUEST['ModelNumber'];
$KitName = $_REQUEST['KitName'];
$KitID = $_REQUEST['KitID'];
$StudentID = $_REQUEST['StudentID'];
$FirstName = $_REQUEST['FirstName'];
$LastName = $_REQUEST['LastName'];
$ReturnDate = $_REQUEST['ReturnDate'];

$CheckInUser = $HTTP_COOKIE_VARS["EquipmentCheckout"];

if($_REQUEST['Problem']=="on"){
$Problem = 1;

$message = "There has been a problem with the checkout of $KitName - $ModelNumber\r\n\r\n$Notes\r\n\r\n";

$message = $message . "$document_root/equipment/kithistory.php?KitID=$KitID";

mail("$admin_email1", "SYSTEM MESSAGE - Checkout Problem with $KitName", $message,
     "From: \"$CheckInUser\" <$admin_email1>\r\n" .
     "Reply-To: \"$CheckInUser\" <$admin_email1>\r\n" .
     "X-Mailer: PHP/" . phpversion());
     
mail("$admin_email2", "SYSTEM MESSAGE - Checkout Problem with $KitName", $message,
     "From: \"$CheckInUser\" <$admin_email2>\r\n" .
     "Reply-To: \"$CheckInUser\" <$admin_email2>\r\n" .
     "X-Mailer: PHP/" . phpversion());
     
mail("$admin_email3", "SYSTEM MESSAGE - Checkout Problem with $KitName", $message,
     "From: \"$CheckInUser\" <$admin_email3>\r\n" .
     "Reply-To: \"$CheckInUser\" <$admin_email3>\r\n" .
     "X-Mailer: PHP/" . phpversion());
     
echo "Email sent to checkout administrator(s)<p>";
     
} else {
$Problem = 0;
}

$sql = "UPDATE checkedout SET DateIn = NOW(), Problem = $Problem, Notes = '$Notes', CheckInUser = '$CheckInUser' WHERE ID = $CheckedOutID;";
//echo $sql;
mysql_select_db($database_equip, $equip);
$Recordset1 = mysql_query($sql, $equip) or die(mysql_error());
?>
<meta http-equiv="refresh" content="10;URL=studentinfo.php?StudentID=<? echo $StudentID; ?>">

<center><h1>Item Returned</h1></center>
<strong><h2>Summary</h2></strong>
<p>Equipment: <? echo $KitName; ?><br/>
Checked out by: <? echo $FirstName; ?> <? echo $LastName; ?><br/>
Was returned: <? echo date("D, F j, g:i a"); ?>
</p>
<p><em>This page will refresh automatically in 10 seconds. Please print now for a receipt.</em></p><br/>
Return to <a href="studentinfo.php?StudentID=<? echo $StudentID; ?>">Student Info Page</a><br />

<? include('includes/footer.html');  ?>