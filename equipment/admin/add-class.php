<?php 
require_once('config.php'); 
include('includes/heading.html');

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
<pre>
Class: <? echo $class ?><br />
StudentID: <? echo $StudentID ?><br />
ClassID: <? echo $ClassID ?><br />
ClassID_query: <? echo $option ?><br />
</pre>
Added to Class. Thank you.

Page will refresh automatically.

<meta http-equiv="refresh" content="3,studentinfo.php?StudentID=<? echo $StudentID ?>" />
<? 
include 'includes/footer.html';
?>


