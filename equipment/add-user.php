<?php 
require_once('config.php'); 

$Username = $_POST['txtUsername'];
$Type = $_POST['acctType'];
$Password = $_POST['txtPassword'];

$insert = "INSERT INTO users (Username, Password, Type) VALUES ('$Username', '$Password','$Type')";
mysql_select_db($database_equip, $equip);
mysql_query($insert, $equip) or die(mysql_error());

?>
