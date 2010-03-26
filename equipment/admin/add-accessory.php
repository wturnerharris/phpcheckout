<?php
require_once('../config.php'); 
//variables
$modEquip = $_REQUEST['modEquip'];
$EquipmentID = $_REQUEST['EquipmentID'];
$StudentID = $_REQUEST['StudentID'];
$accessoryName = $_REQUEST['accessory'];
$AccessorytypeID = $_REQUEST['AccessorytypeID'];

if(isset($AccessorytypeID)){
    $remove = "DELETE FROM kit_accessorytype WHERE ID='$AccessorytypeID'";
    mysql_select_db($database_equip, $equip);
    mysql_query($remove, $equip) or die(mysql_error());
}
if($modEquip == "acc"){
    //add new accessory
	$query_Equip = "INSERT INTO accessorytype (Name) VALUES ('$KitName')";
	mysql_select_db($database_equip, $equip);
	mysql_query($query_Equip, $equip) or die(mysql_error());
} else {
    //get accessory id
    mysql_select_db($database_equip, $equip);
    $AccID_query = "SELECT ID FROM accessorytype WHERE Name='$accessoryName'";
    $accessories = mysql_query($AccID_query, $equip) or die(mysql_error());
    $option = mysql_fetch_array($accessories);
    $AccID = $option['ID'];
    if (isset($EquipmentID)) {
        //add accessory per equipment id
        $sql = "INSERT INTO kit_accessorytype(KitID, AccessorytypeID) VALUES ('$EquipmentID','$AccID')";
        mysql_select_db($database_equip, $equip);
        mysql_query($sql, $equip) or die(mysql_error());
	}
}
