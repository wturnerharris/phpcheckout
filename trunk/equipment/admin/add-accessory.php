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
    //get class id
    mysql_select_db($database_equip, $equip);
    $ClassID_query = "SELECT ID FROM class WHERE Name='$class'";
    $classes = mysql_query($ClassID_query, $equip) or die(mysql_error());
    $option = mysql_fetch_array( $classes);
    $ClassID = $option['ID'];
    if (isset($EquipmentID)) {
        //add class per equipment id
        $sql = "INSERT INTO kit_class(KitID, ClassID, CheckHours, OverNightAllowed) VALUES ('$EquipmentID','$ClassID', '$defaultHours', '$overnights')";
        mysql_select_db($database_equip, $equip);
        mysql_query($sql, $equip) or die(mysql_error());
        include ('admin.php');
        echo "<meta http-equiv='refresh' content='0,admin.php?page=classes' />";
    	} else {
        //add class per student id
        $sql = "INSERT INTO student_class(StudentID, ClassID) VALUES ('$StudentID','$ClassID')";
        mysql_select_db($database_equip, $equip);
        mysql_query($sql, $equip) or die(mysql_error());

include ('../studentinfo.php'); }} 

echo "<meta http-equiv='refresh' content='6,../studentinfo.php?StudentID=$StudentID' />";
echo "<div id='alert' style='visibility:visible'>Class Added: $class";
echo "<br><br>StudentID: $StudentID<br/></div>";