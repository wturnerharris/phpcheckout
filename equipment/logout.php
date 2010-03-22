<?
//start the session
session_name("EquipmentCheckout");
session_start();
session_destroy();
header('location:login.php');
?>
