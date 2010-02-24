<?php 
require_once('config.php');
include('includes/heading.html'); 

$class = $_REQUEST['class'];
$pagenum = $_REQUEST['pagenum'];
$insert = " WHERE class.Name = '$class'";

if (empty($class)) {
	$insert = "";
}

//This checks to see if there is a page number. If not, it will set it to page 1
if (!(isset($pagenum))) {
	$pagenum = 1;
}

$StudentID = $_REQUEST['StudentID'];
$mainQuery = "SELECT kit.ID AS KitID, kit.Name AS KitName, kit.Repair AS Repair, kit.ImageThumb AS KitImageThumb, accessorytype.ID AS AccessoryTypeID, accessorytype.Name AS AccessoryTypeName, kit_accessorytype.ID AS KitAccID, kit_class.ClassID AS kitClassID, class.ID as classID, class.Name as className FROM kit LEFT JOIN kit_accessorytype ON kit_accessorytype.KitID = kit.ID LEFT JOIN accessorytype ON kit_accessorytype.AccessorytypeID = accessorytype.ID LEFT JOIN kit_class ON kit_class.KitID = kit.ID LEFT JOIN class ON kit_class.ClassID = class.ID$insert ORDER BY KitName ASC";
$NoAccessory = "SELECT kit.ID AS KitID, kit.Name AS KitName, kit.ImageThumb AS KitImageThumb, kit_class.ClassID AS kitClassID, class.ID as classID, class.Name as className FROM kit LEFT JOIN kit_class ON kit_class.KitID = kit.ID LEFT JOIN class ON kit_class.ClassID = class.ID$insert ORDER BY KitName ASC";

mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("$mainQuery");
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

//This is the number of results displayed per page
$page_rows = 50;

//This tells us the page number of our last page
$last = ceil($totalRows_Recordset1/$page_rows);

//this makes sure the page number isn't below one, or more than our maximum pages
if ($pagenum < 1)
{
$pagenum = 1;
}
elseif ($pagenum > $last)
{
$pagenum = $last;
}

//This sets the range to display in our query
$max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows; 

//This is your query again, the same one... the only difference is we add $max into it
$data_p = mysql_query("$mainQuery $max") or die(mysql_error());

$First = $row_Recordset3['FirstName'];
$Last = $row_Recordset3['LastName'];
$ServerKitID = $row_Recordset9['KitID'];

$CheckedOutCount = 0;
//echo $mainQuery;
?>

<div align="center"><strong><h1>List of Equipment</h1></strong></div>
<table width="550" border="0" align="center" cellpadding="5" cellspacing="0">

<?php 
// LIST BY CLASS
$classes = mysql_query("SELECT * FROM class") or die(mysql_error());  ?>

<form name="form" action="allequipmentbyclass.php" method="post">
	<select name="class" size="1" id="class" style="margin-left: 10px; margin-bottom: 5px;" onChange="this.form.submit();"> 
	<option <?php if ($class == "") { echo "selected";} ?> value="" >All Classes</option>
	<? while($option = mysql_fetch_array( $classes )) {
		
		// Print out the contents of each row (class) into an option 
		if ($class == "$option[Name]") { 
			$echo = " selected"; 
		} else { 
			$echo = ""; 
		}
		echo "<option $echo value='$option[Name]'>$option[Name]</option>";
		} ?>
	</select>
	<input type="hidden" name="StudentID" value="<?php echo $StudentID; ?>">
</form> 

<?php
$AccessoryCount = 0;

do { 
if ($CurrentKitID != $info['KitID']) {
if ($FirstTime == 1) {
echo "</td></tr>";
}
$AccessoryCount = 0;
$AccessoryFirstTime = 0;


?>
<tr>
    <td bgcolor="e6e6e6">
        <strong><a href="#" class="hints" title="<?php echo 'Enrolled for ' .$info['className']; ?>">Equipment:</a></strong> <?php $currentID = $info['KitID']; $checkedID = $info['KitID']; echo $info['KitName']; ?><a style="text-decoration: none;" href="<? echo $root; ?>/kithistory.php?KitID=<?php echo $info['KitID']; ?>" > <img src="images/ip_icon_02_Info.png" title="Checkout History" width="18" height="18" border="0" align="absmiddle" /></a><br />
	<?php	
	// SHOWS IF UNAVAILABLE WITHOUT SID SELECTED
	mysql_select_db($database_kit, $equip);
	$query_Recordset5 = "SELECT * FROM checkedout WHERE KitID = $currentID AND DateIn = ''";
	$Recordset5 = mysql_query($query_Recordset5, $equip) or die(mysql_error());
	$row_Recordset5 = mysql_fetch_assoc($Recordset5);
	$totalRows_Recordset5 = mysql_num_rows($Recordset5);
	
	if (empty($_REQUEST['StudentID'])) { 
		if ($row_Recordset5['ExpectedDateIn'] != '') { ?>
		</td><td bgcolor="e6e6e6" valign="top"><em>Unavailable -</em><B><font color="red"> Checked Out</font></B>
		</td></tr><tr><td valign="top" CLASS="accessoryText">&nbsp;
		<? } else { 
			if ($info['Repair'] != 1) { ?>
			</td><td bgcolor="e6e6e6">Available for <strong><a href="studentid.php" onClick="javascript:alert('No Student ID Selected')">Checkout</a></strong></td></tr><tr><td valign="top" CLASS="accessoryText">&nbsp;
			<? } else { ?>
				</td><td bgcolor="e6e6e6" valign="top"><em>Unavailable -</em><B><font color="red"> Out For Repairs </font></B>
				</td></tr><tr><td valign="top" CLASS="accessoryText">&nbsp;
<?	}	}	} else {
	// SHOWS IF UNAVAILABLE WITH SID SELECTED
	mysql_select_db($database_kit, $equip);
	$query_Recordset5 = "SELECT * FROM checkedout WHERE KitID = $currentID AND DateIn = ''";
	$Recordset5 = mysql_query($query_Recordset5, $equip) or die(mysql_error());
	$row_Recordset5 = mysql_fetch_assoc($Recordset5);
	$totalRows_Recordset5 = mysql_num_rows($Recordset5);
		
	if ($row_Recordset5['ExpectedDateIn'] != ''){ ?> 
		</td><td bgcolor="e6e6e6" valign="top"><em>Unavailable -</em><B><font color="red"> Checked Out</font></B>
		</td></tr><tr><td valign="top" CLASS="accessoryText">&nbsp;
<? 	} else {
		if ($info['Repair'] != 1) { ?>
		</td><td bgcolor="e6e6e6">Available for <strong><a href="studentid.php" onClick="javascript:alert('No Student ID Selected')">Checkout</a></strong></td></tr><tr><td valign="top" CLASS="accessoryText">&nbsp;
		<? } else { ?>
				</td><td bgcolor="e6e6e6" valign="top"><em>Unavailable -</em><B><font color="red"> Out For Repairs </font></B>
				</td></tr><tr><td valign="top" CLASS="accessoryText">&nbsp;
<?	} 	}	?>


	<?php }
if (isset($info['KitImageThumb'])){
	echo "<IMG SRC='images/".$info['KitImageThumb']."' align='center'>";
	echo "</td><td valign='top' style='padding-left:50px;' CLASS='accessoryText'>";
} else {
	echo "</td><td valign='top' style='padding-left:50px;' CLASS='accessoryText'>No Accessories</td>";
}
if (isset($info['AccessoryTypeName'])){
echo '<em><strong>Accessories</strong></em>';
}
$CurrentKitID = $info['KitID'];
echo "&nbsp;";
}
if (isset($info['AccessoryTypeName'])){


//echo $row_Recordset1['KitAccID'];
//echo " - ";
if($AccessoryCount > 8){
if($AccessoryFirstTime < 1){
echo "</td><td valign='top' style='padding-left:50px;' CLASS='accessoryText'>";
$AccessoryFirstTime++;
}	
}
echo "<br>&#187; " . $info['AccessoryTypeName'];
$AccessoryCount++;
} 

$FirstTime++;
 } while ($info = mysql_fetch_assoc($data_p)); 
 ?>
        </div>
      </blockquote>
</table>
<?
echo "<center><p>";

// This shows the user what page they are on, and the total number of pages
echo " --Page $pagenum of $last-- </p>";

// First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
if ($pagenum == 1){
echo " <a class='pagenum'> << First</a> ";
echo " ";
echo " <a class='pagenum'> < Previous</a> ";
} else {
echo " <a class='pagenum' href='{$_SERVER['PHP_SELF']}?pagenum=1&class=$class&StudentID=".$_REQUEST['StudentID'] ."'> << First</a> ";
echo " ";
$previous = $pagenum-1;
echo " <a class='pagenum' href='{$_SERVER['PHP_SELF']}?pagenum=$previous&class=$class&StudentID=".$_REQUEST['StudentID'] ."'> < Previous</a> ";
}

//just a spacer
echo "&nbsp;&nbsp;";

//This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
if ($pagenum == $last)
{
echo " <a class='pagenum'>Next ></a> ";
echo " ";
echo " <a class='pagenum'>Last >></a> ";
} else {
$next = $pagenum+1;
echo " <a class='pagenum' href='{$_SERVER['PHP_SELF']}?pagenum=$next&class=$class&StudentID=".$_REQUEST['StudentID'] ."'>Next ></a> ";
echo " ";
echo " <a class='pagenum' href='{$_SERVER['PHP_SELF']}?pagenum=$last&class=$class&StudentID=".$_REQUEST['StudentID'] ."'>Last >></a> ";
echo "</center>";
}

mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset5);
mysql_free_result($Recordset9);
?>

<?php include('includes/footer.html');  ?>