<?php

//variables
$EquipmentID = $_REQUEST['equipmentList'];
$hideButtons = false;

if ($_REQUEST['addEquipment'] == "true") {
	$addEquipment = true;
    $hideButtons = true;
}
if ($_REQUEST['addAccessory'] == "true") {
	$addAccessory = true;
    $hideButtons = true;
}
$filter = $_REQUEST['filter'];
if (!isset($filter)) {
	$filter = "no";
}
$filterBy = $_REQUEST['filterList'];
if ($filterBy  == "no") { 
	$filter = "no";
		}
//global javascript
?>

<script type="text/javascript">
function Filter(){
	$('filter').value = "yes";
//	alert('Submit Called');
	submitForm1();
}
function submitForm1() {
	$('form1').submit();
}
function showAddEquipment() {
	$('addEquipment').value = "true";
	submitForm1();
}
function showAddAccessory() {
	$('addAccessory').value = "true";
	submitForm1();
}
function refreshPage(){
	$('filter').value = "no";
	var location = "admin.php?page=equipment"
	window.location.href = location;
}
</script>

<form id="form1" name="form1" action="admin.php?page=equipment" method="post">
	<p><strong style="line-height: 30px;">Genre: </strong>
	<select id="filterList" name="filterList" style="margin-left: 38px; width: 200px; height: 25px;" onChange="Filter();">
		<option <?php if (!isset($filterBy)) { echo "selected"; } ?> value="no">Select a type...</option>
		<option <?php if ($filterBy == "Equipment") { echo "selected"; } ?> value="Equipment">Equipment</option>
		<option <?php if ($filterBy == "Graphic Tablet") { echo "selected"; } ?> value="Graphic Tablet">Graphic Tablet</option>
		<option <?php if ($filterBy == "Scanner") { echo "selected"; } ?> value="Scanner">Scanner</option>
		<option <?php if ($filterBy == "Still Camera") { echo "selected"; } ?> value="Still Camera">Still Camera</option>
		<option <?php if ($filterBy == "Tripod") { echo "selected"; } ?> value="Tripod">Tripod</option>
		<option <?php if ($filterBy == "Video Camera") { echo "selected"; } ?> value="Video Camera">Video Camera</option>
	</select>
	<input id="btn" type="button" style="margin-left: 30px; height: 25px; width: 65px;" onClick="Filter();" value="Filter" onKeyPress="Filter();" />
	</p><hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
	<strong style="line-height: 30px;">Equipment: </strong>
	
	<input type="hidden" name="addEquipment" id="addEquipment" value="">
	<input type="hidden" name="addAccessory" id="addAccessory" value="">
	<input id="filter" name="filter" type="hidden" value="<?php echo $filter; ?>" />
	<select name="equipmentList" id="equipmentList" style="float: right; width: 300px; height: 25px; margin-right: 35px; margin-top: 5px;" onChange="submitForm1();">
		<option selected value="">Select the equipment...</option>

<?php

//***** DATABASE *****
mysql_select_db($database_equip, $equip);

if ($filter == "no") {
	$query_E = "SELECT * FROM kit ORDER BY kit.Name ASC";
} else {
	if ($filter == "yes") {
		$query_E = "SELECT * FROM kit WHERE kit.Genre = \"$filterBy\" ORDER BY kit.Name ASC";
	}
}

$Equipment = mysql_query($query_E, $equip) or die(mysql_error());
$row_Equipment = mysql_fetch_assoc($Equipment);
$totalRows_Equipment = mysql_num_rows($Equipment);

//***** LOOP SELECT BOX *****
mysql_data_seek($Equipment,0);
while($loop_Equipment = mysql_fetch_assoc($Equipment)) {

?>
		<option value="<?php echo $loop_Equipment['ID']; ?>"><?php echo $loop_Equipment['Name']. ", " .$loop_Equipment['Genre']; ?></option>
<?php 
} 
?>
  </select>
</form>
	<hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">

<?php 

//***** RECORD FORM *****
//	echo $echo1;

?>
<br>
<?php
if (empty($EquipmentID)) { if (!$hideButtons) { ?>
<div style="margin-left: auto; margin-right: auto;">
<a href="#" title="Add Equipment" onClick="showAddEquipment();"><img src="<?php echo $root; ?>/images/btn-add-equipment.png" border="0" /></a>
<a href="#" title="Add Accessories" onClick="showAddAccessory();"><img src="<?php echo $root; ?>/images/btn-add-accessories.png" border="0" /></a>
</div>
<? }} else { ?>
<div id="showModify">
<form id="frmModEquip" name="frmModEquip" enctype="multipart/form-data" action="actions-equipment.php" method="POST">
	<input type="hidden" name="EquipmentID" value="<? echo $EquipmentID; ?>" />
	<label>Name: </label><input type="text" name="textfield" /><br>
	<label>Image: </label><input type="file" /><br>
	<label>Genre: </label><input type="text" name="textfield4" /><br>
	<label>Check Hours: </label><input type="text" name="textfield5" /><br>
	<label>Serial #: </label><input type="text" name="textfield6" /><br>
	<label>Model #: </label><input type="text" name="textfield7" /><br>
	<label>Thumbnail: </label><input type="file" /><br>
	<label>Needs Repair: </label><input type="checkbox" name="checkbox2" value="checkbox" /><label>Special Contract Required: </label><input type="checkbox" name="checkbox" value="checkbox" /><br>
	<label>Notes: </label><textarea name="textarea"></textarea>
	<input type="hidden" name="MAX_FILE_SIZE" value="500" />
	<br />
	<a href="#" style="float: right; margin-right: 35px;" onClick="Modify()">
		<img src="<?php echo $root; ?>/images/modify-button.png" border="0" title="Modify" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
		<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="answer=confirm('Do you wish to remove this record?');if(answer!=0){delEntry();}else{alert('Canceled')}">
		<img src="<?php echo $root; ?>/images/remove-button.png" border="0" title="Remove" /></a>
</form>
</div>
<?
}
if ($addEquipment) { ?>
<div id="showAddEquip">
<form id="frmAddEquip" name="frmAddEquip" enctype="multipart/form-data" action="actions-equipment.php" method="POST">
	<label>Name: </label><input type="text" name="textfield" />
	<label>Image: </label><input type="file" />
	<label>Genre: </label><input type="text" name="textfield4" />
	<label>Check Hours: </label><input type="text" name="textfield5" />
	<label>Serial #: </label><input type="text" name="textfield6" />
	<label>Model #: </label><input type="text" name="textfield7" />
	<label>Thumbnail: </label><input type="file" />
	<label>Needs Repair: </label><input type="checkbox" name="checkbox2" value="checkbox" /><label>Special Contract Required: </label><input type="checkbox" name="checkbox" value="checkbox" />
	<label>Notes: </label><textarea name="textarea"></textarea>
	<input type="hidden" name="MAX_FILE_SIZE" value="500" />
	<br />
	<a href="#" style="float: right; margin-right: 35px;" onClick="Add()">
		<img src="<?php echo $root; ?>/images/add-button.png" border="0" title="Add" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
		<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
</form>
</div>
<?php
}
if ($addAccessory) { ?>
<div id="showAddAccessory">
<form id="frmAddAccessory" name="frmAddAccessory" enctype="multipart/form-data" action="actions-equipment.php" method="POST">
	<label>Name: </label><input type="text" name="textfield" />
	<label>Image: </label><input type="file" />
	<label>Genre: </label><input type="text" name="textfield4" />
	<label>Check Hours: </label><input type="text" name="textfield5" />
	<label>Serial #: </label><input type="text" name="textfield6" />
	<label>Model #: </label><input type="text" name="textfield7" />
	<label>Thumbnail: </label><input type="file" />
	<label>Needs Repair: </label><input type="checkbox" name="checkbox2" value="checkbox" /><label>Special Contract Required: </label><input type="checkbox" name="checkbox" value="checkbox" />
	<label>Notes: </label><textarea name="textarea"></textarea>
	<input type="hidden" name="MAX_FILE_SIZE" value="500" />
	<br />
	<a href="#" style="float: right; margin-right: 35px;" onClick="Add()">
		<img src="<?php echo $root; ?>/images/add-button.png" border="0" title="Add" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
		<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
</form>
</div>
<?php
}

mysql_free_result($Equipment);
?>