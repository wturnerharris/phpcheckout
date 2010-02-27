<?php 
require_once('../config.php'); 

$Username = $_POST['txtUsername'];
$Type = $_POST['acctType'];
$Password = $_POST['txtPassword'];
$encrypted_mypassword=md5($Password);

$insert = "INSERT INTO users (Username, Password, Type) VALUES ('$Username', '$encrypted_mypassword','$Type')";
mysql_select_db($database_equip, $equip);
mysql_query($insert, $equip) or die(mysql_error());

?>
