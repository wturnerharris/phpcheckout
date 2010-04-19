<?
//start the session
session_name("EquipmentReservation");
session_start();
session_destroy();
header('location:login.php');
?>