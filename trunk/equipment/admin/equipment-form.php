<?php
require_once('../config.php');

if ($_FILES['upImage']['name']) {
	$file = "upImage";
}
if ($_FILES['upThumb']['name']) {
	$file = "upThumb";
}
$addEquip = $_REQUEST['addEquip'];
$modEquip = $_REQUEST['modEquip'];
$addAccessory = $_REQUEST['addAccessory'];
$EquipmentID = $_REQUEST['EquipmentID'];
$KitName = $_REQUEST['txtName'];
$Image = $_REQUEST['txtImage'];
$Genre = $_REQUEST['txtGenre'];
$CheckHours = $_REQUEST['txtHours'];
$Serial = $_REQUEST['txtSerial'];
$ModelNumber = $_REQUEST['txtModel'];
$ImageThumb = $_REQUEST['txtThumb'];
$Repair = $_REQUEST['chkRepair'];
$Contract = $_REQUEST['chkContract'];
$Notes = $_REQUEST['txtNotes'];

if($addEquip == "true"){
	$add = true;
}
if($modEquip== "true"){
	$modify = true;
}
if($addAccessory == "true"){
	$accessory = true;
}
if (!$add && !$modify && !$accessory){
	$image = true;
}
//$image = true;
if($image){
	$var = $_FILES[$file]["type"];
if ((($var == "image/gif") || ($var == "image/jpeg") || ($var == "image/pjpeg") || ($var == "image/jpg")) && ($_FILES[$file]["size"] < 80000)) {
	$destination_path = "../images/";
	$result = 0;
	$target_path = $destination_path . basename( $_FILES[$file]['name']);
	//move_uploaded_file($_FILES["upImage"]["tmp_name"], "../images/" . $_FILES["upImage"]["name"]);
	if(@move_uploaded_file($_FILES[$file]['tmp_name'], $target_path)) {
		$result = 1;
		$name = $_FILES[$file]['name'];
	}
	sleep(1);
	} else {
		$result = 0;
	}
}
if($add){
}
if($accessory){
}
if($modify){
}
if($remove){
}
?>
<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>);window.top.window.modTxt("<?php echo $name; ?>");</script>