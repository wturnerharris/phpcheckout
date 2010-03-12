<?php

if ($_FILES['upImage']['error']) {
	$file = "upImage";
} elseif ($_FILES['upThumb']['error']) {
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
echo $_FILES['upImage']['name'];
echo $_FILES['upImage']['error'];
echo $_FILES["upImage"]["tmp_name"];
if (!$addEquip && !$modEquip && !$addAccessory){
	$image = true;
}
if($addEquip == "true"){
	$add = true;
}
if($modEquip== "true"){
	$modify = true;
}
if($addAccessory == "true"){
	$add = true;
}
$image = true;
if($image){

$destination_path = "$root/images/";
$result = 0;
$target_path = $destination_path . basename( $_FILES['upImage']['name']);
move_uploaded_file($_FILES["upImage"]["tmp_name"], "../images/" . $_FILES["upImage"]["name"]);
if(@move_uploaded_file($_FILES['upImage']['tmp_name'], $target_path)) {
	$result = 1;
}
sleep(1);

}
if($add){
}
if($remove){
}
if($modify){
}
?>
<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>);</script>