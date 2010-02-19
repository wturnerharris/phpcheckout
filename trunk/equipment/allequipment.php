<?php require_once('config.php');

include('includes/heading.html'); 

$StudentID = $_REQUEST['StudentID'];

mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT kit.ID AS KitID, kit.Name AS KitName, kit.ImageThumb AS KitImageThumb, accessorytype.ID AS AccessoryTypeID, accessorytype.Name AS AccessoryTypeName, kit_accessorytype.ID AS KitAccID FROM kit LEFT JOIN kit_accessorytype ON kit_accessorytype.KitID = kit.ID LEFT JOIN accessorytype ON kit_accessorytype.AccessorytypeID = accessorytype.ID ORDER BY kit.ID");
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT * FROM checkedout WHERE DateIn = ''");
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_equip, $equip);
$query_Recordset3 = "SELECT * FROM students WHERE StudentID = CONVERT( _utf8 \"$StudentID\" USING latin1 )";
$Recordset3 = mysql_query($query_Recordset3, $equip) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_kit, $equip);
$query_Recordset9 = "SELECT ID AS KitID, Name, ContractRequired FROM kit";
$Recordset9 = mysql_query($query_Recordset9, $equip) or die(mysql_error());
$row_Recordset9 = mysql_fetch_assoc($Recordset9);
$totalRows_Recordset9 = mysql_num_rows($Recordset9);


$First = $row_Recordset3['FirstName'];
$Last = $row_Recordset3['LastName'];
$ServerKitID = $row_Recordset9['KitID'];

$CheckedOutCount = 0;
?>

<div align="center"><strong><h1>List of Equipment</h1></strong><br></div>
<table width="550" border="0" align="center" cellpadding="5" cellspacing="0">


<?php 
$AccessoryCount = 0;

do { 
if ($CurrentKitID != $row_Recordset1['KitID']) {
if ($FirstTime == 1) {
echo "</td></tr>";
}
$AccessoryCount = 0;
$AccessoryFirstTime = 0;


?>
<tr>
    <td bgcolor="e6e6e6">
        <strong>Kit Name:</strong> <? $currentID = $row_Recordset1['KitID']; $checkedID = $row_Recordset2['KitID']; echo $row_Recordset1['KitName']; ?><br />
	<?php	
	// SHOWS IF UNAVAILABLE
	mysql_select_db($database_kit, $equip);
	$query_Recordset5 = "SELECT * FROM checkedout WHERE KitID = $currentID AND DateIn = ''";
	$Recordset5 = mysql_query($query_Recordset5, $equip) or die(mysql_error());
	$row_Recordset5 = mysql_fetch_assoc($Recordset5);
	$totalRows_Recordset5 = mysql_num_rows($Recordset5);
	
	if (empty($_REQUEST['StudentID'])) { 
		if ($row_Recordset5['ExpectedDateIn'] != ''){ ?> 
			<? echo("Unavailable</td><td bgcolor=\"e6e6e6\" valign=\"top\"><B><font color=\"red\">Checked Out</font></B>"); ?> </td></tr><tr><td valign="top" CLASS="accessoryText">
		<?} else { ?>
	<strong><a href="studentid.php" onClick="javascript:alert('No Student ID Selected')">Checkout</a></strong>
	</td><td bgcolor="e6e6e6"></td></tr><tr><td valign="top" CLASS="accessoryText">
	<? }} else {
	// SHOWS IF UNAVAILABLE
	mysql_select_db($database_kit, $equip);
	$query_Recordset5 = "SELECT * FROM checkedout WHERE KitID = $currentID AND DateIn = ''";
	$Recordset5 = mysql_query($query_Recordset5, $equip) or die(mysql_error());
	$row_Recordset5 = mysql_fetch_assoc($Recordset5);
	$totalRows_Recordset5 = mysql_num_rows($Recordset5);
		
	if ($row_Recordset5['ExpectedDateIn'] != ''){ ?> 
		<? echo("Unavailable</td><td bgcolor=\"e6e6e6\" valign=\"top\"><B><font color=\"red\">Checked Out</font></B>"); ?> </td></tr><tr><td valign="top" CLASS="accessoryText">
	<? } else { ?>
		<strong><a href="checkout.php?KitID=<? echo $currentID;?>&ContractRequired=0&StudentID=<? echo $StudentID; ?>">Checkout</a> for <?php echo $First; ?> <?php echo $Last; ?></strong></td><td valign="top" bgcolor="e6e6e6">Available</td></tr><tr><td valign="top" CLASS="accessoryText">
	<? } ?>

	<?php }
if (isset($row_Recordset1['KitImageThumb'])){
echo "<p><IMG SRC='images/".$row_Recordset1['KitImageThumb']."' align='center'>";
echo "</td><td valign='top' CLASS='accessoryText'>";
}
if (isset($row_Recordset1['AccessoryTypeName'])){
echo '<em><strong>Accessories</strong></em>';
}
$CurrentKitID = $row_Recordset1['KitID'];
echo "<BR>";
}
if (isset($row_Recordset1['AccessoryTypeName'])){


//echo $row_Recordset1['KitAccID'];
//echo " - ";
if($AccessoryCount > 8){
if($AccessoryFirstTime < 1){
echo "</td><td valign='top' CLASS='accessoryText'>";
$AccessoryFirstTime++;
}
}
echo "&#187; " . $row_Recordset1['AccessoryTypeName'];
echo "<BR>";
$AccessoryCount++;
}

$FirstTime++;
 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
 ?>
        </div>
      </blockquote>
</table>
<? include('includes/footer.html');  ?>