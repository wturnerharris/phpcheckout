<?php
//move to config
$checkHours = false;
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
//	$('filter').value = "no";
	var location = "admin.php?page=equipment"
	window.location.href = location;
}
function showUpImage(link){
	var imgType = link;
	if ($(link).style.display == "none"){
		$(link).style.display = "block";
	} else if ($('link').style.display == "block") {
		$(link).style.display = "none";
	}
}
function startUpload(){
	$('f1_upload_process').style.visibility = 'visible';
	return true;
}
function stopUpload(success){
	var result = '';
	if (success == 1){
		$('result').innerHTML = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
		} else {
			$('result').innerHTML = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
			}
			$('f1_upload_process').style.visibility = 'hidden';
			return true;
			}
function modTxt(name){
	var box = "txt"+finishedType;
	$(box).value = name;
}
function uploadImage(type){
	finishedType = type;
	startUpload();
	$('modEquip').value = "img";
	$('form2').target = "upload_target";
	$('form2').submit();
}
function IsEmpty(obj) {
	for(var prop in obj) {
		if(obj.hasOwnProperty(prop))
			return false;
	}
	return true;
}
function showResponse(req){
	setTimeout('refreshPage();',1000);
}
function Modify(){
	$('modEquip').value = "mod";
   var name = $F('txtName');
   var image = $F('txtImage');
   var genre = $F('txtGenre');
   var thumb = $F('txtThumb');
   if (IsEmpty(name) || IsEmpty(image) || IsEmpty(genre) || IsEmpty(thumb))
   {
	  $$('label.im').invoke('setStyle', { color: 'red' });
	  return false;
   }
	new Ajax.Request("equipment-form.php",
		{
		method: 'post',
		parameters: $('form2').serialize(true),
		onComplete: showResponse 
		});
	$('alert').style.visibility = "visible";
	$('alert').innerHTML = "Equipment Kit Modified";
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
<?php
if (empty($EquipmentID)) { if (!$hideButtons) { ?>
<div style="margin-left: 75px; margin-top: 75px;">
<a href="#" title="Add Equipment" onClick="showAddEquipment();"><img src="<?php echo $root; ?>/images/btn-add-equipment.png" border="0" /></a>
<a href="#" title="Add Accessories" onClick="showAddAccessory();"><img src="<?php echo $root; ?>/images/btn-add-accessories.png" border="0" /></a>
</div>
<? }} else { 

//***** DATABASE *****
mysql_select_db($database_equip, $equip);
$equipModQuery = "SELECT * FROM kit WHERE kit.ID = \"$EquipmentID\"";
$equipMod = mysql_query($equipModQuery, $equip) or die(mysql_error());
$row_equipMod = mysql_fetch_assoc($equipMod);
$totalRows_equipMod = mysql_num_rows($equipMod);

?>
<div id="showModEquip">
<h2>Modify Equipment</h2>
<form id="form2" name="form2" enctype="multipart/form-data" action="equipment-form.php" method="POST">
	<input type="hidden" name="EquipmentID" value="<? echo $EquipmentID; ?>" />
	<label class="lb im">Name: </label><input name="txtName" id="txtName" class="tb" type="text" value="<?php echo $row_equipMod['Name']; ?>" /><br>
	<label class="lb im">Image: </label><input name="txtImage" id="txtImage" class="tb" type="text" readonly="readonly" value="<?php echo $row_equipMod['Image']; ?>" /> <a href="#up1" name="up1" onclick="showUpImage('upImage');">Upload Image</a><br>
    <span id="upImage" style="display: none; "><input name="upImage" class="tb" type="file" onChange="uploadImage('Image');" /> <a href="#up1" onclick="showUpImage('upImage');">Cancel</a><br></span>
	<label class="lb im">Genre: </label><input name="txtGenre" id="txtGenre" class="tb" type="text" value="<?php echo $row_equipMod['Genre']; ?>" /><br>
<? if ($checkHours) { ?>
	<label class="lb">Hours: </label><input name="txtHours" id="txtHours" class="tb" type="text" value="<?php echo $row_equipMod['CheckHours']; ?>" /><br>
<? } ?>
	<label class="lb">Serial No: </label><input name="txtSerial" id="txtSerial" class="tb" type="text" value="<?php echo $row_equipMod['SerialNumber']; ?>" /><br>
	<label class="lb">Model No: </label><input name="txtModel" id="txtModel" class="tb" type="text" value="<?php echo $row_equipMod['ModelNumber']; ?>" /><br>
	<label class="lb im">Thumb: </label><input name="txtThumb" id="txtThumb" class="tb" type="text" readonly="readonly" value="<?php echo $row_equipMod['ImageThumb']; ?>" /> <a href="#up2" name="up2" onclick="showUpImage('upThumb');">Upload Thumbnail</a><br>
    <span id="upThumb" style="display: none; "><input name="upThumb" class="tb" type="file" onChange="uploadImage('Thumb');" /> <a href="#up2" onclick="showUpThumb('upThumb');">Cancel</a><br></span>
	<strong>Needs Repair: </strong><input name="chkRepair" id="chkRepair" class="chk" type="checkbox" value="1" <?php if ($row_equipMod['Repair'] == 1) { echo "checked='yes'"; } ?> />
	<strong>Special Contract: </strong><input name="chkContract" id="chkContract" class="chk" type="checkbox" value="1" <?php if ($row_equipMod['ContractRequired'] == 1) { echo "checked='yes'"; } ?> /><br>
	<label class="lb">Notes: </label><br/><textarea cols="50" rows="5" name="txtNotes" id="txtNotes"><?php echo $row_equipMod['Notes']; ?></textarea>
	<input type="hidden" id="modEquip" name="modEquip" value="mod" />
<p id="f1_upload_process">Loading...<br/><img src="../images/loader.gif" /></p>
<p id="result"></p>	<br />
	<a href="#" style="float: right; margin-right: 35px;" onClick="Modify()">
		<img src="<?php echo $root; ?>/images/modify-button.png" border="0" title="Modify" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
		<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="answer=confirm('Do you wish to remove this kit?');if(answer!=0){delEntry();}">
		<img src="<?php echo $root; ?>/images/remove-button.png" border="0" title="Remove" /></a>
</form>
<div id="alert"></div>
<div id="image_details"></div>
<iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
</div>
<?
}
if ($addEquipment) { ?>
<div id="showAddEquip">
<h2>Add Equipment</h2>
<form id="form2" name="form2" method="post" enctype="multipart/form-data" action="equipment-form.php" onsubmit="startUpload();">
	<label class="lb im">Name: </label><input name="txtName" id="txtName" class="tb" type="text" value="" /><br>
	<label class="lb im">Image: </label><input name="txtImage" id="txtImage" class="tb" type="text" readonly="readonly" /> <a href="#up1" name="up1" onclick="showUpImage('upImage');">Upload Image</a><br>
    <span id="upImage" style="display: none; "><input name="upImage" class="tb" type="file" size="30" onChange="uploadImage('Image');" /> <a href="#up1" onclick="showUpImage('upImage');">Cancel</a><br></span>
	<label class="lb im">Genre: </label><input name="txtGenre" id="txtGenre" class="tb" type="text" value="" /><br>
<? if ($checkHours) { ?>
	<label class="lb">Hours: </label><input name="txtHours" id="txtHours" class="tb" type="text" value="" /><br>
<? } ?>
	<label class="lb">Serial No: </label><input name="txtSerial" id="txtSerial" class="tb" type="text" value="" /><br>
	<label class="lb">Model No: </label><input name="txtModel" id="txtModel" class="tb" type="text" value="" /><br>
	<label class="lb im">Thumb: </label><input name="txtThumb" id="txtThumb" class="tb" type="text" readonly="readonly" /> <a href="#up2" name="up2" onclick="showUpImage('upThumb');">Upload Thumbnail</a><br>
    <span id="upThumb" style="display: none; "><input name="upThumb" class="tb" type="file" size="30" onChange="uploadImage('Thumb');" /> <a href="#up2" onclick="showUpImage('upThumb');">Cancel</a><br></span>
	<strong>Needs Repair: </strong><input name="chkRepair" id="chkRepair" class="chk" type="checkbox" value="checkbox" />
	<strong>Special Contract: </strong><input name="chkContract" id="chkContract" class="chk" type="checkbox" value="checkbox" /><br>
	<label class="lb">Notes: </label><br/><textarea cols="50" rows="5" name="txtNotes" id="txtNotes"></textarea>
	<input type="hidden" id="modEquip" name="modEquip" value="add" />
<p id="f1_upload_process">Loading...<br/><img src="../images/loader.gif" /></p>
<p id="result"></p>	<br />
	<a href="#" style="float: right; margin-right: 35px;" onClick="Add();">
		<img src="<?php echo $root; ?>/images/add-button.png" border="0" title="Add" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
		<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
</form>
<div id="alert"></div>
<div id="image_details"></div>
<iframe id="upload_target" name="upload_target" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>
</div>
<?php
}
if ($addAccessory) { ?>
<div id="showAddAccessory">
<h2>Add Accessory</h2>
<form id="form2" name="form2" action="equipment-form.php" method="POST">
	<label class="lb">Name: </label><input class="tb" type="text" name="txtName" value="" /><br>
	<input type="hidden" id="modEquip" name="modEquip" value="acc" />
	<br />
	<a href="#" style="float: right; margin-right: 35px;" onClick="addAccessory()">
		<img src="<?php echo $root; ?>/images/add-button.png" border="0" title="Add" /></a>
	<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
		<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
</form>
<div id="alert"></div>
</div>
<?php
}

mysql_free_result($Equipment);
?>