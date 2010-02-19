<?php 
$username = $_COOKIE["EquipmentCheckout"];
mysql_select_db($database_equip, $equip);

$access = "SELECT * FROM users WHERE Username = '$username'";

$entry = mysql_query($access, $equip) or die(mysql_error());
$row_entry = mysql_fetch_assoc($entry);
$totalRows_entry = mysql_num_rows($entry);

if ($row_entry['Type'] == "LabMon") {
	echo "<strong class='alert'>You do not have permission to modify these settings.</strong>";
	echo "<br><br><strong>To add students to checkout, you must click the Students tab.</strong>";
} else {

//variables
$SelectedID = $_REQUEST['studentList'];

//global javascript
?>

<script type="text/javascript">

function submitForm(){
	$('SelectedID').value = $('studentList').value;
	$('form1').submit();
//	sendRequest();
}
function showAddForm(){
	$('SelectedID').value = 0;
	$('form1').submit();
}
function disableEnterKey(e){
     var key;
     if(window.event)
          key = window.event.keyCode;     //IE
     else
          key = e.which;     //firefox
     if(key == 13)
          return false;
     else
          return true;
}
function Add() {
	new Ajax.Request("add-user.php", 
		{ 
		method: 'post', 
		parameters: $('form3').serialize(true),
		onComplete: showResponse 
		});
//	alert('Send Called');
	$('alert').style.visibility = "visible";
	$('alert').innerHTML = "Record Added";
	}
function Modify() {
//	new Ajax.Request("modify-user.php", 
//		{ 
//		method: 'post', 
//		parameters: $('form2').serialize(true),
//		onComplete: showResponse 
//		});
//	alert('Send Called');
	$('alert').style.visibility = "visible";
	$('alert').innerHTML = "<p class='alert'>Must delete, then add new users.</p>";
	}
function delEntry(){
	new Ajax.Request("remove-user.php", 
		{ 
		method: 'post', 
		parameters: $('form2').serialize(true),
		onComplete: showResponse 
		});
//	alert('Send Called');
	$('alert').style.visibility = "visible";
	$('alert').innerHTML = "User Removed";
	$('form2').submit();
	}
function showResponse(req){
	var t=setTimeout(refreshPage(),5000);
}
function refreshPage(){
	$('SelectedID').value = "";
	var location = "admin.php?page=users";
	window.location.href = location;
}
</script>		
<form id="form1" name="form1" action="admin.php?page=users" method="post">
	<p><strong style="line-height: 30px;">Username: </strong>
	<input id="SelectedID" name="SelectedID" type="hidden" value="<?php echo $SelectedID; ?>" />
	<select id="studentList" name="studentList" style="float: right; width: 300px; height: 25px; margin-right: 35px;" onChange="submitForm();">
		<option selected value="">Select a user...</option>

<?php

//***** DATABASE *****
mysql_select_db($database_equip, $equip);

if (!isset($SelectedID)) {
	$query_S = "SELECT * FROM users";
} else {
	$query_S = "SELECT * FROM users WHERE ID = '$SelectedID'";
}

$Users = mysql_query($query_S, $equip) or die(mysql_error());
$row_Users = mysql_fetch_assoc($Users);
$totalRows_Users = mysql_num_rows($Users);

//***** LOOP SELECT BOX *****
mysql_data_seek($Users,0);
while($loop_Users = mysql_fetch_assoc($Users)) {
?>
		<option value="<?php echo $loop_Users['ID']; ?>"><?php echo $loop_Users['Username']; ?></option>
<?php 
} 
?>
	</select>
</form>
	<hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">

<?php 

//***** RECORD FORM *****
//	echo $echo1;

?>
<br>
<?php
if (isset($SelectedID)) {
	if ($SelectedID > 0) {
?>
<div id="showModify">
<form id="form2" name="form2" action="#" method="post">
<strong style="line-height: 30px;">Username: </strong><input type="textarea" id="txtUsername" name="txtUsername" style="float: right; width: 225px; height: 25px; margin-right: 35px; margin-top: 5px; line-height:30px;" value="<?php echo $row_Users['Username']; ?>" disabled="true" />
<br />
<strong style="line-height: 30px;">Account Type: </strong>
<select id="acctType" name="acctType" disabled="true" style="float: right; width: 225px; height: 25px; margin-right: 35px; margin-top: 5px; line-height:30px;">
	<option <?php if ($row_Users['Type'] == "Admin") { echo "selected"; } ?> value="Admin">Administrator</option>
	<option <?php if ($row_Users['Type'] == "LabMon") { echo "selected"; } ?> value="LabMon">Lab Monitor</option>
</select>
<br />
<strong style="line-height: 30px;">Password: </strong><input type="textarea" id="txtPassword" name="txtPassword" style="float: right; width: 225px; height: 25px; margin-right: 35px; margin-top: 5px; line-height:30px;" value="<?php echo $row_Users['Password']; ?>" disabled="true" />
<br />
<br />
<a href="#" style="float: right; margin-right: 35px;" onClick="Modify()">
	<img src="<?php echo $root; ?>/images/modify-button.png" border="0" title="Modify" /></a>
<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
	<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
<a href="#" style="float: right; margin-right: 10px;" onClick="answer=confirm('Do you wish to remove <?php echo $row_Users["Username"]; ?> from the users?');if(answer!=0){delEntry();}else{alert('Canceled')}">
	<img src="<?php echo $root; ?>/images/remove-button.png" border="0" title="Remove" /></a>
<input id="pID" name="pID" type="hidden" value="<?php echo $row_Users['ID']; ?>" />
</form>
</div>
<?php
	} else {
		if ($SelectedID == 0) {
?>
<div id="showAdd">
<form id="form3" name="form3" action="#" method="post">
<strong style="line-height: 30px;">Username: </strong><input type="textarea" id="txtUsername" name="txtUsername" value="" style="float: right; width: 225px; height: 25px; margin-right: 35px; margin-top: 5px; line-height:30px;"/>
<br />
<strong style="line-height: 30px;">Account Type: </strong>
<select id="acctType" name="acctType" style="float: right; width: 225px; height: 25px; margin-right: 35px; margin-top: 5px; line-height:30px;">
	<option value="Admin">Administrator</option>
	<option selected value="LabMon">Lab Monitor</option>
</select>
<br />
<strong style="line-height: 30px;">Password: </strong><input type="password" id="txtPassword" name="txtPassword" value="" style="float: right; width: 225px; height: 25px; margin-right: 35px; margin-top: 5px; line-height:30px;"/>
<br />
<br />
<a href="#" style="float: right; margin-right: 35px;" onClick="Add()">
	<img src="<?php echo $root; ?>/images/add-button.png" border="0" title="Add" /></a>
<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
	<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
</form>
</div>
<?php
		}
	}
}
?>
<div style="position: absolute; bottom: 10px; left: 20px;"><a href="#" title="Add Student" onClick="$('SelectedID').value = '0'; $('form1').submit();"><img src="<?php echo $root; ?>/images/add-student-button.png" border="0" /></a></div>
<?php
mysql_free_result($entry);
mysql_free_result($Users);
}
?>
