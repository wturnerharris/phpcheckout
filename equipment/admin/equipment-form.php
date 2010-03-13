<?php
require_once('../config.php');

if ($_FILES['upImage']['name']) {
	$file = "upImage";
}
if ($_FILES['upThumb']['name']) {
	$file = "upThumb";
}
//  form variables
$modEquip = $_REQUEST['modEquip'];
$EquipmentID = $_REQUEST['EquipmentID'];
$KitName = $_REQUEST['txtName'];
$Image = $_REQUEST['txtImage'];
$Genre = $_REQUEST['txtGenre'];
if ($checkHours){
	$CheckHours = $_REQUEST['txtHours'];
} else {
	$CheckHours = "NULL";
}
$SerialNumber = $_REQUEST['txtSerial'];
$ModelNumber = $_REQUEST['txtModel'];
$ImageThumb = $_REQUEST['txtThumb'];
$Repair = $_REQUEST['chkRepair'];
$Contract = $_REQUEST['chkContract'];
$Notes = $_REQUEST['txtNotes'];

if($modEquip == "add"){
	$add = true;
}
if($modEquip== "mod"){
	$modify = true;
}
if($modEquip == "rem"){
	$remove = true;
}
if($modEquip == "acc"){
	$accessory = true;
}
if ($modEquip == "img"){
	$image = true;
}
//for image upload
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
	//***** DATABASE ***** add
	$query_Equip = "INSERT INTO kit (Name, Image, Repair, Genre, CheckHours, SerialNumber, ModelNumber, ImageThumb, ContractRequired, Notes) VALUES ('$KitName', '$Image', '$Repair', '$Genre', '$CheckHours', '$SerialNumber', '$ModelNumber', '$ImageThumb', '$Contract', '$Notes')";
	mysql_select_db($database_equip, $equip);
	mysql_query($query_Equip, $equip) or die(mysql_error());
}
if($accessory){
	$query_Equip = "INSERT INTO accessorytype (Name) VALUES ('$KitName')";
	mysql_select_db($database_equip, $equip);
	mysql_query($query_Equip, $equip) or die(mysql_error());
}
if($modify){
	//***** DATABASE ***** modify
	$query_Equip = "UPDATE kit SET Name='$KitName', Image='$Image', Repair='$Repair', Genre='$Genre', CheckHours=$CheckHours, SerialNumber='$SerialNumber', ModelNumber='$ModelNumber', ImageThumb='$ImageThumb', ContractRequired='$Contract', Notes='$Notes' WHERE ID='$EquipmentID'";
	mysql_select_db($database_equip, $equip);
	mysql_query($query_Equip, $equip) or die(mysql_error());
}
if($remove){
	//***** DATABASE ***** remove
	$query_Equip = "DELETE FROM kit WHERE ID='$EquipmentID'";
	mysql_select_db($database_equip, $equip);
	mysql_query($query_Equip, $equip) or die(mysql_error());
}
?>
<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>);window.top.window.modTxt("<?php echo $name; ?>");</script>