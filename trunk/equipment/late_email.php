<?php require_once('config.php'); 

$StudentID = $_REQUEST['StudentID'];
$CheckOutID = $_REQUEST['CheckOutID'];

mysql_select_db($database_equip, $equip);
$student_info = "SELECT * FROM students LEFT JOIN checkedout ON checkedout.StudentID = students.StudentID LEFT JOIN kit ON kit.ID = checkedout.KitID WHERE students.StudentID = '$StudentID' AND checkedout.ID = '$CheckOutID'";
$student = mysql_query($student_info, $equip) or die(mysql_error());
$row_student = mysql_fetch_assoc($student);


//EMAIL FOR TESTING
$ToEmail = $row_student["Email"];
$WasDue = date("l, F j, Y", strtotime($row_student["ExpectedDateIn"]));
$DateOut = date("l, F j, Y", strtotime($row_student["DateOut"]));
$KitName = $row_student["Name"];
$StudentName = $row_student["FirstName"];

//MESSAGE

$message = "\r\n" .

"Dear $StudentName,\r\n" .
"\r\n" .
"On $DateOut, you rented the $KitName from the Digital Output Center of the City College Art Department.\r\n" .
" \r\n" .
"You were supposed to return this item on $WasDue. To date we have not received your checked out item. If you believe this is an error or you returned the equipment on time as scheduled, please see a lab technician or manager to verify that your returned equipment was logged.\r\n" .
" \r\n" .
"Please remember that it is important to return items when they are due. If you require additional time with an item, please reserve it ahead of time and/or be sure to renew the equipment on the day it is due.\r\n" .
" \r\n" .
"Reservations are found at http://134.74.235.40/doc-reservations/.\r\n" .
" \r\n" .
"If you have questions about any of our policies, let us know.\r\n" .
" \r\n" .
"Best,\r\n".
" \r\n" .
"Art Department DOC Lab Technician\r\n".
"City College - New York, NY 10031\r";
	


//START EMAIL ACTION
mail("$ToEmail", "Your Item Is Late", $message,
     "From: NoReply <www@ccny.cuny.edu>\r\n" .
     "Bcc: LabTech <labtech.ccny.art@gmail.com>\r\n" .
     "Return-Path: www@ccny.cuny.edu\r\n".
     "Return-Receipt-To: www@ccny.cuny.edu\r\n".
     "X-Mailer: PHP/" . phpversion());
//END EMAIL ACTION

mysql_free_result($student);

include('index.php'); 
echo "<meta http-equiv='refresh' content='3;URL=index.php'>";
echo "<div id='overlay'></div>";
echo "<div id='alert' class='alert' style='visibility: visible;'>Email Has Been Sent!<br/><br/>";
echo "Returning to Main.</div>";

?>