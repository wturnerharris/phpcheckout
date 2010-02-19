<?php 
require_once('../config.php'); 

$StudentID = $_POST['StudentID'];
$class = $_POST['class'];
$ClassID_query = "SELECT ID FROM class WHERE Name='$class'";
mysql_select_db($database_equip, $equip);
$classes = mysql_query($ClassID_query, $equip) or die(mysql_error());
$option = mysql_fetch_array( $classes);
$ClassID = $option['ID'];


$sql = "INSERT INTO student_class(StudentID, ClassID) VALUES ('$StudentID','$ClassID')";
//echo $sql;
mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());

?>

<meta http-equiv="refresh" content="2,../studentinfo.php?StudentID=<?php echo $StudentID; ?>" />
<div id="alert" style="visibility:visible">
Class Added: <? echo $class ?><br />
<br />
StudentID: <? echo $StudentID ?><br />
</div>

<?
include ('../studentinfo.php');
?>