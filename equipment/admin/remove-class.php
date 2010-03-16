<?php
require_once('../config.php'); 

$rsClassID = $_POST['rsClassID'];
$rkClassID = $_POST['rkClassID'];
if ($rsClassID != "") {
    $remove = "DELETE FROM student_class WHERE ID='$rsClassID'";
    mysql_select_db($database_equip, $equip);
    mysql_query($remove, $equip) or die(mysql_error());
} else {
    $remove = "DELETE FROM kit_class WHERE ID='$rkClassID'";
    mysql_select_db($database_equip, $equip);
    mysql_query($remove, $equip) or die(mysql_error()); 
}
?>
