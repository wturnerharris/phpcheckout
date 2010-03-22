<?php

//variables
$filter = $_REQUEST['filter'];
if (!isset($filter)) {
	$filter = "no";
}
$StudentID = $_REQUEST['StudentID'];
$EquipmentID = $_REQUEST['EquipmentID'];
if (isset($EquipmentID)){
    $equipment = true;
    $hideButtons = true;
	$filter = "yes";
	$name = "Equipment";
}

if (empty($_REQUEST['StudentID'])) {
	$StudentID = $_REQUEST['studentList'];
}
if (isset($StudentID) && $StudentID != "") {
	$filter = "yes";
	$name = "Student";
	}
if ($filter == "addNewClass"){
    $hideButtons = true;
    $addNewClass = true;
}

//global javascript
?>

<script type="text/javascript">
function showResponse(req){
	setTimeout('refreshPage();',1000);
}
function refreshPage(){
	$('filter').value = "no";
	var location = "admin.php?page=classes"
	window.location.href = location;
}
function submitForm1(){
<? if (!$equipment) { ?>
    $('StudentID').value = "";
<? } ?>
	$('form1').submit();
}
function showAddForm(){
	$('filter').value = "add";
	$('form1').submit();
}
function showAddClass(){
	$('filter').value = "addNewClass";
	$('form1').submit();
}
function disableEnterKey(e){
     var key;
     if(window.event)
          key = window.event.keyCode;     //IE
     else
          key = e.which;     //firefox
     if(key == 13)
          return false;
     else
          return true;
}
function delEntry(){
	new Ajax.Request("remove-class.php", 
		{ 
		method: 'post', 
		parameters: $('form2').serialize(true),
		onComplete: showResponse 
		});
	$('alert').style.visibility = "visible";
	$('alert').innerHTML = "Class Removed";
	}
function Add(){
	new Ajax.Request("add-class.php",
		{ 
		method: 'post', 
		parameters: $('form2').serialize(true),
		onComplete: showResponse 
		});
	$('alert').style.visibility = "visible";
	$('alert').innerHTML = "Class Added";
	}
</script>
<?php
// **DEBUG
//echo "filter : ".$filter ."<BR>";
//echo "query : ".$query_S ."<BR>";
//echo "ID : ".$StudentID ."<BR>";
?>
<form id="form1" name="form1" action="admin.php?page=classes" method="post">
<? if ($equipment) { ?>
	<strong style="line-height: 30px;">Equipment: </strong>
	<input id="filter" name="filter" type="hidden" value="<?php echo $filter; ?>" />
	<select id="EquipmentID" name="EquipmentID" style="float: right; width: 300px; height: 25px; margin-right: 35px; margin-top: 5px;" onChange="submitForm1();">
		<option <?php if (isset($EquipmentID)) { echo ""; } else { echo "selected"; } ?> value="">Select the equipment...</option>
<?php

//***** DATABASE *****
mysql_select_db($database_equip, $equip);

$query_E = "SELECT * FROM kit ORDER BY kit.Name ASC";
$Equip = mysql_query($query_E, $equip) or die(mysql_error());
$row_Equip = mysql_fetch_assoc($Equip);
$totalRows = mysql_num_rows($Equip);

//***** LOOP SELECT BOX *****
mysql_data_seek($Equip,0);
while($loop_Equip = mysql_fetch_assoc($Equip)) {
?>
<option 
<?php $eID = $loop_Equip['ID'];
		if ($EquipmentID == $eID) {
			echo "selected";
		} else {
			echo "";
		}
?> value="<?php echo $loop_Equip['ID']; ?>"><?php echo $loop_Equip['Name']; ?></option>
<?php 
} 
?>
	</select>
</form>
	<hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">

<? } else { ?>

	<p><strong style="line-height: 30px;">Student ID: </strong>
	  <input type="textarea" id="StudentID" name="StudentID" style="margin-left: 11px; width: 200px; height: 25px;"  value="<?php if (isset($StudentID)) { echo $StudentID; } else { echo ""; }?>" onKeyPress="return disableEnterKey(event)" />
	<input id="btn" type="button" style="margin-left: 30px; height: 25px;" onClick="submitForm1();" value="Submit" onKeyPress="submitForm1();" />

	</p><hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
	<strong style="line-height: 30px;">Student: </strong>
	
	<input id="filter" name="filter" type="hidden" value="<?php echo $filter; ?>" />
	<select id="studentList" name="studentList" style="float: right; width: 300px; height: 25px; margin-right: 35px; margin-top: 5px;" onChange="submitForm1();">
		<option <?php if (isset($StudentID)) { echo ""; } else { echo "selected"; } ?> value="">Select a student...</option>
<?php

//***** DATABASE *****
mysql_select_db($database_equip, $equip);
$query_S = "SELECT * FROM students ORDER BY students.LastName ASC";
$Students = mysql_query($query_S, $equip) or die(mysql_error());
$row_Students = mysql_fetch_assoc($Students);
$totalRows = mysql_num_rows($Students);

//***** LOOP SELECT BOX *****
mysql_data_seek($Students,0);
while($loop_Students = mysql_fetch_assoc($Students)) {
?>
<option 
<?php $sID = $loop_Students['StudentID'];
		if ($StudentID == $sID) {
			echo "selected";
		} else {
			echo "";
		}
?> value="<?php echo $loop_Students['StudentID']; ?>"><?php echo $loop_Students['LastName']. ", " .$loop_Students['FirstName']. " - " .$loop_Students['StudentID']; ?></option>
<?php 
 } 
?>
	</select>
</form>
	<hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
<?php
}
if (empty($StudentID)) { if (!$hideButtons) { ?>
<div style="display: block; margin-top: 75px; margin-left: auto; margin-right: auto; width: 135px;">
<a href="#" title="Add Classes" onClick="showAddClass();"><img src="<?php echo $root; ?>/images/btn-add-class.png" border="0" /></a>
</div>
<? }}

//***** RECORD FORM *****
if ($filter == "yes") {
?>
	<div id="showClass">
	<form id="form2" name="form2" action="remove-class.php" method="post">
<?php
mysql_select_db($database_equip, $equip);
if ($equipment) {
    mysql_free_result($Equip);
    $query_rc2 = "SELECT kit_class.ID AS kcID, kit_class.KitID, kit_class.ClassID, class.Name FROM kit_class INNER JOIN class ON kit_class.ClassID = class.ID WHERE KitID = '$EquipmentID'";
	} else {
	mysql_free_result($Students);
	$query_rc2 = "SELECT student_class.ID AS scID, student_class.StudentID, student_class.ClassID, class.Name FROM student_class INNER JOIN class ON student_class.ClassID = class.ID WHERE StudentID = '$StudentID'"; 
	}
$query_Recordset2 = sprintf($query_rc2);
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if ($totalRows >= 1) {
echo "<p><u><strong>The Class(es) currently enrolled (totaling " . $totalRows_Recordset2 . "):</strong></u> <br>";

if (isset($row_Recordset2['ClassID'])) {
do {
	if (empty($ClassIDSQL)){
		$ClassIDSQL = $row_Recordset2['ClassID'];
	} else {
		$ClassIDSQL = $ClassIDSQL . " OR kit_class.ClassID = " . $row_Recordset2['ClassID'] ;
	}
	if (!$equipment) {
	?>
	<a id="remClass" href="#" onClick="answer=confirm('Remove this class for this student?');if(answer!=0){$('rsClassID').value=<? echo $row_Recordset2['scID']; ?>;delEntry();}else{alert('Canceled')}" >
<? } else { ?>
	<a id="remClass" href="#" onClick="answer=confirm('Remove this class?');if(answer!=0){$('rkClassID').value=<? echo $row_Recordset2['kcID']; ?>;delEntry();}else{alert('Canceled')}" >
<? } ?>
	<img id="remClass" src="<?php echo $root; ?>/images/remove_icn.png" border="0" title="Remove Class" /></a>
	<? echo $row_Recordset2['Name']; ?><br/> 
	<?php
	}
while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
}
?>
<input id="rsClassID" name="rsClassID" type="hidden" value="" />
<input id="rkClassID" name="rkClassID" type="hidden" value="" />
</form>
<?
//***** ADD CLASS FORM *****

$classes = mysql_query("SELECT * FROM class ORDER BY class.Name") or die(mysql_error());  ?>
<form name="form" action="add-class.php" method="post">
<select name="class" size="1" id="class">
<? while($option = mysql_fetch_array( $classes )) {

// Print out the contents of each row into an option 
echo "<option value='$option[Name]'>$option[Name]</option>";
} ?>
</select>
<? if (!$equipment) { ?>
<input name="StudentID" type="hidden" value="<?php echo $StudentID; ?>">
<input type="submit" name="Submit" value="Add">
<br><span class="alert"><?php echo $alert['classes']; ?></span>
<? } else { ?>
<input name="EquipmentID" type="hidden" value="<?php echo $EquipmentID; ?>">
<input type="submit" name="Submit" value="Add">
<? } ?>
</form>

<?php
} else {
	if ($totalRows < 1) {
echo "<span class='alert'><br>This $name is NOT registered for checkout.</span><br>";
	}
}
?>
<br />
<br />
<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
	<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
</div>
<?php
//****end if for #showClass
}

if ($addNewClass) { ?>
<div id="showAddClass">
<h2>Add Classes</h2>
<form id="form2" name="form2" method="post" action="add-class.php">
	  <p>
	<label class="lb im">Class: </label><input name="txtClass" id="txtClass" class="tb" type="text" value="" /><br>
	<input type="hidden" id="addNewClass" name="addNewClass" value="true" /></p>
	<br />
	<a href="#" style="float: right; margin-right: 35px;" onClick="Add();">
		<img src="<?php echo $root; ?>/images/add-button.png" border="0" title="Add" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage();">
		<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
</form>
</div>
<?php
}
?>
