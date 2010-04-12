<?php
require_once('equipment/config.php');
$class = $_REQUEST['class'];

// LIST BY CLASS
mysql_select_db($database_equip, $equip);
$classes = mysql_query("SELECT * FROM class ORDER BY class.Name") or die(mysql_error());  ?>

<form name="form" action="reservations.php" method="post">
	<select name="class" size="1" id="class" style="margin-left: 10px; margin-bottom: 5px;" onChange="this.form.submit();"> 
	<? while($option = mysql_fetch_array( $classes )) {
		
		// Print out the contents of each row (class) into an option 
		if ($class == "$option[Name]") { 
			$echo = " selected"; 
		} else { 
			$echo = ""; 
		}
		echo "<option $echo value='$option[Name]'>$option[Name]</option>";
		} 
		mysql_free_result($option);
	?>
	</select>
</form> 
<?php
// get item names based on selected class
mysql_select_db($database_equip, $equip);
$selectedClass = "SELECT kit.Name as KitName, kit.ID as KitID, class.Name as ClassName FROM kit LEFT JOIN kit_class ON kit_class.KitID = kit.ID LEFT JOIN class ON class.ID = kit_class.ClassID WHERE class.Name = '$class'";
$kitNames = mysql_query($selectedClass, $equip) or die("Could not perform select query - " . mysql_error());
$row_kitNames = mysql_fetch_assoc($kitNames);
$totalRows_kitNames = mysql_num_rows($kitNames);

// get items reserved today and items that are checked out and due in future
$find = "SELECT kit.Name as kitName, kit.ID as KitID, checkedout.ID as CheckedID, checkedout.ReserveDate, checkedout.DateOut, checkedout.ExpectedDateIn FROM kit LEFT JOIN checkedout ON checkedout.KitID = kit.ID WHERE ReserveDate != CURDATE() OR DateOut < UTC_TIMESTAMP() AND ExpectedDateIn > UTC_TIMESTAMP() AND DateIN = '' ORDER BY kitName";
$kitReserved = mysql_query($selectedClass, $equip) or die("Could not perform select query - " . mysql_error());
$row_kitReserved = mysql_fetch_assoc($kitReserved);
$totalRows_kitReserved = mysql_num_rows($kitReserved);
?>
<body>
<p>Div Header</p>
<p>Div Calendar Selector	| Div Reservation Class</p>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="160">Items</td>
    <td width="70">Mon</td>
    <td width="70">Tue</td>
    <td width="70">Wed</td>
    <td width="70">Thu</td>
    <td width="70">Fri</td>
    <td width="70">Sat</td>
    <td width="70">Sun</td>
  </tr>
  <?php
  //get items from
  while($kitName = mysql_fetch_array( $kitNames )) {
  	echo "<tr>";
  	echo "<td>".$kitName['KitName']."</td>";
  	$currKitID = $kitName['KitID'];
  	?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    <?php } ?>
</table>
<p>Div Footer</p>
</body>
</html>
