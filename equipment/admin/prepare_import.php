<?php
require_once('../config.php');

$profName = stripslashes($_POST['profName']);
$classTeach = stripslashes($_POST['classTeach']);
$class = $_POST['class'];
$size = $_POST['size'];
$send = $_POST['send'];

if (strlen($send) > 1) {
	for ($i = 1; $i <= $size; $i++) {
		mysql_select_db($database_equip, $equip);
		$query_Recordset1 = "INSERT INTO import (StudentID, FirstName, LastName, Email, Phone, UID, Class, Professor, ClassTeaching) VALUES (\"". 
		$_POST["data"][$i]["StudentID"].
		"\", \"".
		$_POST['data'][$i]['FirstName'].
		"\", \"".
		$_POST['data'][$i]['LastName'].
		"\", \"".
		$_POST['data'][$i]['Email'].
		"\", \"".
		$_POST['data'][$i]['Phone'].
		"\", \"".
		$_POST['data'][$i]['UserID'].
		"\", \"$class\", \"$profName\", \"$classTeach\")";
		//$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
		//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
		mysql_query($query_Recordset1, $equip) or die(mysql_error());
	}
	echo "Submitted. Student import pending authorization...";
	echo "<meta http-equiv='refresh' content='30;URL=http://134.74.235.10/'>";
} else {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mass Import Form</title>
<link href="../includes/equip.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../includes/prototype.js"></script>
</head>

<body>
<div id="admin-main">
		<div id="admin-page">
<div id="showAdd">
	<div id="form1-info">
		<p>
		<?php echo "<b>Professor: </b>".$profName."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Teaching: </b>".$classTeach."<br/>Registering <i>".$size."</i> student(s) to be added to the <i>".$class."</i> class."; ?>
		</p>
		<span class="alert">Please Verify the below information before submitting.</span>
	</div>
  	<form id="form2" name="form2" action="prepare_import.php" method="post">
	  <div id="form-div">
	<? for ($i=1; $i<=$size; $i++) { ?>
      <div id="part<?php echo $i; ?>" class="part"><?php echo $i; ?></div>
      <input type="text" id="StudentID<?php echo $i; ?>" name="data[<?php echo $i; ?>][StudentID]" value="<?php echo $_POST['data'][$i]['StudentID']; ?>" readonly="true" />
	  <input type="text" id="Email<?php echo $i; ?>" name="data[<?php echo $i; ?>][Email]" value="<?php echo $_POST['data'][$i]['Email']; ?>" readonly="true" />
	  <input type="text" id="FirstName<?php echo $i; ?>" name="data[<?php echo $i; ?>][FirstName]" value="<?php echo $_POST['data'][$i]['FirstName']; ?>" readonly="true" />
	  <input type="text" id="LastName<?php echo $i; ?>" name="data[<?php echo $i; ?>][LastName]" value="<?php echo $_POST['data'][$i]['LastName']; ?>" readonly="true" />
	  <input type="text" id="Phone<?php echo $i; ?>" name="data[<?php echo $i; ?>][Phone]" value="<?php echo $_POST['data'][$i]['Phone']; ?>" readonly="true" />
	  <input type="text" id="UserID<?php echo $i; ?>" name="data[<?php echo $i; ?>][UserID]" value="<?php echo $_POST['data'][$i]['UserID']; ?>" readonly="true" />
	  <hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
	<? } ?>
	  <input type="hidden" id="class" name="class" value="<?php echo $class; ?>" />
	  <input type="hidden" id="size" name="size" value="<?php echo $size; ?>" />
	  <input type="hidden" id="profName" name="profName" value="<?php echo $profName; ?>" />
	  <input type="hidden" id="classTeach" name="classTeach" value="<?php echo $classTeach; ?>" />
	  <input type="hidden" id="send" name="send" value="send" />
	  <br />
	  </div>
	  <input id="btn" name="btn" type="submit" style="margin-right: 35px;" value="Submit" />
	</form>
</div>
<p>&nbsp;</p>
</div>
</div>
</body>
</html>
<?php 
} 
?>