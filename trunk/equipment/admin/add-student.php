<?php 
require_once('../config.php'); 

$StudentID = $_POST['txtStudentID1'];
$FirstName = $_POST['txtFirstName1'];
$LastName = $_POST['txtLastName1'];
$Email = $_POST['txtEmail1'];
$Phone = $_POST['txtPhone1'];
$Contract = $_POST['txtContract1'];
$UID = $_POST['txtUser1'];

$insert = "INSERT INTO students (StudentID, FirstName, LastName, Email, Phone, ContractSigned, UID) VALUES ('$StudentID', '$FirstName', '$LastName', '$Email', '$Phone', '$Contract', '$UID')";
mysql_select_db($database_equip, $equip);
mysql_query($insert, $equip) or die(mysql_error());

?>
