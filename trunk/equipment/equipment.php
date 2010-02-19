<?php 

//variables
$filter = $_REQUEST['filter'];
if (isset($filter)) {
} else {
	$filter = "no";
}

$filterBy = $_REQUEST['filterList'];
if ($filterBy  == "no") { 
	$filter = "no"; 
		}
//global javascript
?>

<script type="text/javascript">
function Filter(){
	$('filter').value = "yes";
//	alert('Submit Called');
	$('form1').submit();
}

</script>		

<form id="form1" name="form1" action="admin.php?page=equipment" method="post">
	<p><strong style="line-height: 30px;">Genre by: </strong>
	<select id="filterList" name="filterList" style="margin-left: 20px; width: 200px; height: 25px;" onChange="Filter();">
		<option <?php if (!isset($filterBy)) { echo "selected"; } ?> value="no">Select a type...</option>
		<option <?php if ($filterBy == "Equipment") { echo "selected"; } ?> value="Equipment">Equipment</option>
		<option <?php if ($filterBy == "Graphic Tablet") { echo "selected"; } ?> value="Graphic Tablet">Graphic Tablet</option>
		<option <?php if ($filterBy == "Scanner") { echo "selected"; } ?> value="Scanner">Scanner</option>
		<option <?php if ($filterBy == "Still Camera") { echo "selected"; } ?> value="Still Camera">Still Camera</option>
		<option <?php if ($filterBy == "Tripod") { echo "selected"; } ?> value="Tripod">Tripod</option>
		<option <?php if ($filterBy == "Video Camera") { echo "selected"; } ?> value="Video Camera">Video Camera</option>
	</select>
	<input id="btn" type="button" style="float: right; margin-right: 35px; height: 26px; margin-top: 3px; width: 75px;" onClick="Filter();" value="Filter" onKeyPress="Filter();" />

	</p><hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
	<strong style="line-height: 30px;">Equipment: </strong>
	
	<input id="filter" name="filter" type="hidden" value="<?php echo $filter; ?>" />
	<select name="equipmentList" id="equipmentList" style="float: right; width: 300px; height: 25px; margin-right: 35px; margin-top: 5px;" onChange="submitForm();">
		<option selected value="">Select the equipment...</option>

<?php

//***** DATABASE *****
mysql_select_db($database_equip, $equip);

if ($filter == "no") {
	$query_E = "SELECT * FROM kit ORDER BY kit.Name ASC";
} else {
	if ($filter == "yes") {
		$query_E = "SELECT * FROM kit WHERE kit.Genre = \"$filterBy\" ORDER BY kit.Name ASC";
	}
}

$Equipment = mysql_query($query_E, $equip) or die(mysql_error());
$row_Equipment = mysql_fetch_assoc($Equipment);
$totalRows_Equipment = mysql_num_rows($Equipment);

//***** LOOP SELECT BOX *****
while($loop_Equipment = mysql_fetch_assoc($Equipment)) {

?>
		<option value="<?php echo $loop_Equipment['ID']; ?>"><?php echo $loop_Equipment['Name']. ", " .$loop_Equipment['Genre']; ?></option>
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
if ($filter == "yesyes") {
?>
<div id="showModify">
<form id="form2" name="form2" action="#" method="post">
<strong>Name: </strong>
<input type="textarea" id="txtStudentID" name="txtStudentID" value="<?php echo $row_Students['StudentID']; ?>" readonly="true" onClick="this.readOnly = false; this.style.background = '#ffffff'; this.style.color = '#000000'; EnableButton();" onKeyPress="return disableEnterKey(event)"/>
<br />
<strong>Image: </strong>
<input type="textarea" id="txtFirstName" name="txtFirstName" value="<?php echo $row_Students['FirstName']; ?>" readonly="true" onClick="this.readOnly = false; this.style.background = '#ffffff'; this.style.color = '#000000'; EnableButton();" onKeyPress="return disableEnterKey(event)"/>
<br />
<strong>Genre: </strong>
<input type="textarea" id="txtLastName" name="txtLastName" value="<?php echo $row_Students['LastName']; ?>" readonly="true" onClick="this.readOnly = false; this.style.background = '#ffffff'; this.style.color = '#000000'; EnableButton();" onKeyPress="return disableEnterKey(event)"/>
<br />
<strong>Serial: </strong>
<input type="textarea" id="txtEmail" name="txtEmail" value="<?php echo $row_Students['Email']; ?>" readonly="true" onClick="this.readOnly = false; this.style.background = '#ffffff'; this.style.color = '#000000'; EnableButton();" onKeyPress="return disableEnterKey(event)"/>
<br />
<strong>Model: </strong>
<input type="textarea" id="txtPhone" name="txtPhone" value="<?php echo $row_Students['Phone']; ?>" readonly="true" onClick="this.readOnly = false; this.style.background = '#ffffff'; this.style.color = '#000000'; EnableButton();" onKeyPress="return disableEnterKey(event)"/>
<br />
<br />
<a href="#" style="float: right; margin-right: 35px;" onClick="Modify()">
	<img src="images/modify-button.png" border="0" title="Modify" /></a>
<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
	<img src="images/cancel-button.png" border="0" title="Cancel" /></a>
<a href="#" style="float: right; margin-right: 10px;" onClick="answer=confirm('Do you wish to remove <?php echo $row_Students["FirstName"]; ?> <?php echo $row_Students["LastName"]; ?> from the student records?');if(answer!=0){delEntry();}else{alert('Canceled')}">
	<img src="images/remove-button.png" border="0" title="Remove" /></a>
<input id="pID" name="pID" type="hidden" value="<?php echo $row_Students['ID']; ?>" />
</form>
</div>
<?php
} else {
if ($filter == "add") {
?>
<div id="showAdd">
<form id="form3" name="form3" action="#" method="post">
<strong>Name: </strong>
<input type="textarea" id="txtStudentID1" name="txtStudentID1" value="" />
<br />
<strong>Image: </strong>
<input type="textarea" id="txtFirstName1" name="txtFirstName1" value="" />
<br />
<strong>Genre: </strong>
<input type="textarea" id="txtLastName1" name="txtLastName1" value="" />
<br />
<strong>Serial: </strong>
<input type="textarea" id="txtEmail1" name="txtEmail1" value="" />
<br />
<strong>Model: </strong>
<input type="textarea" id="txtPhone1" name="txtPhone1" value="" />
<br />
<br />
<a href="#" style="float: right; margin-right: 35px;" onClick="Add()">
	<img src="images/add-button.png" border="0" title="Add" /></a>
<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
	<img src="images/cancel-button.png" border="0" title="Cancel" /></a>
</form>
</div>
<?php
}}
?>
<div style="position: absolute; bottom: 10px; left: 20px;"><a href="#" title="Add Student" onClick="showAddForm();"><img src="images/add-student-button.png" border="0" /></a></div>
<div id="alert"></div>
<?php
mysql_free_result($Equipment);
?>