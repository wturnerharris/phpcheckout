<?php
require_once('../config.php'); 
$addNewClass = $_POST['addNewClass'];
$Class = $_POST['txtClass'];
if ($addNewClass == "true") {
    //add new class
    $sql = "INSERT INTO class (Name) VALUES ('$Class')";
    mysql_select_db($database_equip, $equip);
    mysql_query($sql, $equip) or die(mysql_error());
} else {
    //variables
    $StudentID = $_POST['StudentID'];
    $class = $_POST['class'];
    //get class id
    mysql_select_db($database_equip, $equip);
    $ClassID_query = "SELECT ID FROM class WHERE Name='$class'";
    $classes = mysql_query($ClassID_query, $equip) or die(mysql_error());
    $option = mysql_fetch_array( $classes);
    $ClassID = $option['ID'];
    //add class per student id
    $sql = "INSERT INTO student_class(StudentID, ClassID) VALUES ('$StudentID','$ClassID')";
    mysql_select_db($database_equip, $equip);
    mysql_query($sql, $equip) or die(mysql_error());

?>

<meta http-equiv="refresh" content="1,../studentinfo.php?StudentID=<?php echo $StudentID; ?>" />
<div id="alert" style="visibility:visible">
Class Added: <? echo $class ?><br />
<br />
StudentID: <? echo $StudentID ?><br />
</div>

<?
include ('../studentinfo.php'); }
?>