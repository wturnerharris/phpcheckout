<?php 

require_once('config.php'); 

$KitName = $_REQUEST['KitName'];
$ReturnDate = $_POST['ReturnDate'];
$FirstName = $_REQUEST['FirstName'];
$LastName = $_REQUEST['LastName'];
$CheckoutDate = time();
$StudentID = $_REQUEST['StudentID'];
$KitID = $_REQUEST['KitID'];
$Accessories = $_REQUEST['Accessories'];
$Notes = $_REQUEST['Notes'];

if ($_REQUEST['ContractRequired']==1) {

	require_once('contract.txt'); 
?>
	
	<P>
	<b>
	Kit: <i><? echo $KitName ?></i> 
	<P>
	<?
	$i = 0;
	$j = 0;
	
	do { 
	$AccessoryID = "Accessory$i";
	
	if ($_REQUEST[$AccessoryID] != "") {
	if ($j > 0) {
	$Accessories = $Accessories . ", " . $_REQUEST[$AccessoryID]; 
	} else {
	$Accessories = $_REQUEST[$AccessoryID]; 
	$j++;
	}
	}
	
	$i++;
	} while ($i < 50); 
	
	
	?>
	Accessories: <i><? echo $Accessories ?></i>
	
	<P>
	Notes: <i><? echo $_REQUEST['Notes']; ?></i>
	<P>
	Checked Out: <i><? echo date("D, F j, g:i a"); ?></i>
	<P>
	Due Back: <i><? echo date("D, F j, g:i a", strtotime($_REQUEST['ReturnDate'])); ?></i><br>
	<P>
	<P>
	Student's Signature: 
	
	</div>
	</td>
	</tr>
	</table>
	</center>
	
	
	<form name="frmCheckOut" action="checkoutaction.php" method="post">
	
	<input type="hidden" name="FirstName" value="<? echo $FirstName; ?>">
	<input type="hidden" name="LastName" value="<? echo $LastName; ?>">
	<input type="hidden" name="KitName" value="<? echo $KitName; ?>">
	<input type="hidden" name="KitID" value="<? echo $KitID; ?>">
	<input type="hidden" name="StudentID" value="<? echo $StudentID; ?>">
	<input type="hidden" name="ReturnDate" value="<? echo $ReturnDate; ?>">
	<input type="hidden" name="Accessories" value="<? echo $Accessories; ?>">
	<input type="hidden" name="Notes" value="<? echo $Notes; ?>">
	<P>
	<center>
	<input type="submit" name="Submit" value="Contract Signed and Filed">
	</center>

<?
} else {
include('includes/heading.html');

function multi_post_item($repeatedString) {
$ArrayOfItems = array();
$raw_input_items = split("&", $_SERVER['QUERY_STRING']);
foreach($raw_input_items as $input_item) {
$itemPair = split("=", $input_item);
if($itemPair[0]==$repeatedString){
$ArrayOfItems[]=$itemPair[1];
}
}
return $ArrayOfItems;
}

//$AccArrray = multi_post_item($HTTP_GET_VARS['Accessory_TypeID']);
//echo $AccArrray[0];
//echo $Accessory_TypeID[0];
//echo $Accessory_TypeID[1];
//echo "<P>";
//echo var_dump($HTTP_GET_VARS['Accessory_TypeID']);




do { 
$AccessoryID = "Accessory$i";

if ($_REQUEST[$AccessoryID] != "") {
if ($j > 0) {
$Accessories = $Accessories . ", " . $_REQUEST[$AccessoryID]; 
} else {
$Accessories = $_REQUEST[$AccessoryID]; 
$j++;
}
}

$i++;
} while ($i < 50); 


$CheckoutUser = $HTTP_COOKIE_VARS["EquipmentCheckout"];
$sql = "INSERT INTO checkedout (ID , KitID , StudentID , DateOut , ExpectedDateIn , DateIn , FinePaid , Reserved, Accessories, Notes, CheckoutUser) VALUES ('', '$KitID', '$StudentID', NOW(), '$ReturnDate', '', NULL , NULL, '$Accessories', '$Notes', '$CheckoutUser');";
//echo $sql;
mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());
//$Recordset1 = mysql_query($sql, $equip) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
//$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<meta http-equiv="refresh" content="10;URL=studentinfo.php?StudentID=<? echo $StudentID; ?>">

<center><h1>Item Checked Out</h1></center>
<strong><h2>Summary</h2></strong>
<br>
<div id="tag-br">
	<div id="tag-top"><?php echo $FirstName; ?> <?php echo $LastName; ?></div>
	<div id="tag-info"> has checked out the <?php echo $KitName; ?>.</div>
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
	<div id="tag-info"><span id="changeDate"><i class="alert"><? echo date("D, F j", strtotime($_REQUEST['ReturnDate'])); ?></i></span>, BEFORE <? echo date("g:i a", strtotime($_REQUEST['ReturnDate']));?></div>
</div>

<p><em>Please print now for a receipt. Otherwise this page will refresh automatically in 10 seconds. </em></p><br/>
Return to <a href="studentinfo.php?StudentID=<? echo $StudentID; ?>">Student Info Page</a><br />

<? include('includes/footer.html'); 
}
?>