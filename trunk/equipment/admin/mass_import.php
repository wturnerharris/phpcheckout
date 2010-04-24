<?php
require_once('../config.php');
mysql_select_db($database_equip, $equip);

if (isset($_POST['profName']) && isset($_POST['classTeach']) && isset($_POST['class']) && isset($_POST['size'])){
	$add = true;
	$profName = stripslashes($_POST['profName']);
	$classTeach = stripslashes($_POST['classTeach']);
	$class = $_POST['class'];
	$size = $_POST['size'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mass Import Form</title>
<link href="../includes/equip.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../includes/prototype.js"></script>
<script type="text/javascript">

function initialize() {
	try {
		document.getElementById("form-div").addEventListener ("focus", targHandler, true);
		document.getElementById("form-div").addEventListener ("blur", blurHandler, true);
		document.getElementById("btn").addEventListener ("click", submitProf, true);
	}
	catch(e) {
		alert("Exception caught: " + e)
	}
}
function targHandler(event) {
	var text = event.target.value;
	event.target.readOnly = false;
	if (text = text) {
		event.target.value = "";
	}
} 
function blurHandler(event) { 
	var text = event.target;
	if (!text.value) {
		text.value = text.defaultValue;
	}
} 
function submitProf(event) {
	var targ = event.target;
	if (IsEmpty(targ.value) || targ.value == targ.defaultValue) 
	{ 
		alert('Do not leave '+targ.defaultValue+' field blank.');
		targ.focus();
		return false;
	}
	document.forms[0].submit();
}  
function isNumeric(sText)
{
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;

   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   }
function IsEmpty(obj) {
	for(var prop in obj) {
		if(obj.hasOwnProperty(prop))
			return false;
	}
	return true;
}
function delEntry(){
	new Ajax.Request("remove-student.php", 
		{ 
		method: 'post', 
		parameters: $('form2').serialize(true),
		onComplete: showResponse 
		});
	$('alert').style.visibility = "visible";
	$('alert').innerHTML = "Student Record Removed";
	$('form2').submit();
}
</script>
</head>
<body onload="initialize();">
<div id="admin-main">
		<div id="admin-page">
<?php if (!$add) { ?>
<form id="form1" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<p>
		<div id="form-div">
		<strong style="line-height: 30px;">Group: </strong>
		<?php
		//***** ADD CLASS FORM *****
		
		$classes = mysql_query("SELECT * FROM class ORDER BY class.Name") or die(mysql_error());  ?>
		<select name="class" size="1" id="class" style="margin-left: 10px; margin-right: 20px;">
		<? while($option = mysql_fetch_array( $classes )) {
		
		// Print out the contents of each row into an option 
		echo "<option value='$option[Name]'>$option[Name]</option>";
		} ?>
		</select>
		<strong style="line-height: 30px;">Students to Add: </strong>
		<select name="size" size="1" id="size">
		<? for ($i=1; $i<=20; $i++) {
			// Print out the contents of each row into an option
			echo "<option value='$i'>$i</option>";
		} ?>
		</select>
	</p>
	<p>
	<table style="margin-left: -50px;">
		<tr>
			<td>Photo 1</td>
			<td>Photo 2</td>
			<td>Photo 3</td>
			<td>Photo 4</td>
		</tr>
		<tr>
			<td>Tripods</td>
			<td>Tripods</td>
			<td>Tripods</td>
			<td>Tripods</td>
		</tr>
		<tr>
			<td></td>
			<td>Light Meters</td>
			<td>Light Meters</td>
			<td>Light Meters</td>
		</tr>
		<tr>
			<td></td>
			<td>Mamiya 645</td>
			<td>Mamiya 645</td>
			<td>Mamiya 645</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Digital SLRs</td>
			<td>Digital SLRs</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Travel Lights</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Hot Lights</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>View Cameras</td>
		</tr>
	</table>
		Photo 1 = Tripods<br>
		Photo 2 = Tripods, Light Meters, Mamiya 645<br>
		Photo 3 = Tripods, Light Meters, Mamiya 645, Digital SLRs<br>
		Photo 4 = Tripods, Light Meters, Mamiya 645, Digital SLRs, Travel Lights, Hot Lights, View Cameras<br>
	</p>
	<p>	
		<input type="text" id="profName" name="profName" style="margin-right: 5px;" value="Professor's Full Name" readonly="true" /> 
		<input type="text" id="classTeach" name="classTeach" style="margin-right: 5px;" value="Class Instructing" readonly="true" />
		</div>
		<input id="btn" name="btn" type="button" style="margin-right: 35px;" value="Submit" />
	</p>
<hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
</form>

<? } else { ?>

<div id="showAdd">
	<div id="form1-info">
		<?php echo "<b>Professor: </b>".$profName."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Teaching: </b>".$classTeach."<br/>Registering <i>".$size."</i> student(s) to be added to the <i>".$class."</i> class."; ?>
	</div>
  	<form id="form2" name="form2" action="prepare_import.php" method="post">
	  <div id="form-div">
	<? for ($i=1; $i<=$size; $i++) { ?>
      <div id="part<?php echo $i; ?>" class="part"><?php echo $i; ?></div>
      <input type="text" id="StudentID<?php echo $i; ?>" name="StudentID<?php echo $i; ?>" value="Student ID Number" />
	  <input type="text" id="Email<?php echo $i; ?>" name="Email<?php echo $i; ?>" value="Email Address" />
	  <input type="text" id="FirstName<?php echo $i; ?>" name="FirstName<?php echo $i; ?>" value="First Name" />
	  <input type="text" id="LastName<?php echo $i; ?>" name="LastName<?php echo $i; ?>" value="Last Name" />
	  <input type="text" id="Phone<?php echo $i; ?>" name="Phone<?php echo $i; ?>" value="Phone Number" />
	  <input type="text" id="UserID<?php echo $i; ?>" name="UserID<?php echo $i; ?>" disabled="true" />
	  <hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
	<? } ?>
	  <input type="hidden" id="class" name="class" value="<?php echo $class; ?>" />
	  <input type="hidden" id="size" name="size" value="<?php echo $size; ?>" />
	  <input type="hidden" id="profName" name="profName" value="<?php echo $profName; ?>" />
	  <input type="hidden" id="classTeach" name="classTeach" value="<?php echo $classTeach; ?>" />
	  <br />
	  </div>
	  <input id="btn" name="btn" type="button" style="margin-right: 35px;" value="Submit" />
	</form>
</div>
<? } ?>
<p>&nbsp;</p>
</div>
</div>
</body>
</html>