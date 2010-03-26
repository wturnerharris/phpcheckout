<?php
require_once('../config.php'); 
//variables
$newClass = $_POST['txtClass'];
$EquipmentID = $_POST['EquipmentID'];
$StudentID = $_POST['StudentID'];
$class = $_POST['class'];

if (isset($newClass)) {
    //add new class
    $sql = "INSERT INTO class (Name) VALUES ('$newClass')";
    mysql_select_db($database_equip, $equip);
    mysql_query($sql, $equip) or die(mysql_error());
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

echo "<meta http-equiv='refresh' content='1,../studentinfo.php?StudentID=$StudentID' />";
echo "<div id='alert' style='visibility:visible'>Class Added: $class";
echo "<br><br>StudentID: $StudentID<br/></div>";
