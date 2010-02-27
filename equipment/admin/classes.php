<?php 

//variables
$filter = $_REQUEST['filter'];
if (isset($filter)) {
} else {
	$filter = "no";
}
$StudentID = $_REQUEST['StudentID'];
if (empty($_REQUEST['StudentID'])) {
	$StudentID = $_REQUEST['studentList'];
}
if (isset($StudentID)) {
	$filter = "yes";
	}
//global javascript
?>

<script type="text/javascript">
function showResponse(req){
	setTimeout('refreshPage();',1000);
}
function refreshPage(){
	$('filter').value = "no";
	var location = "admin.php?page=classes"
	window.location.href = location;
}
function submitForm1(){
	$('filter').value = "yes";
	$('form1').submit();
}
function submitForm2(){
	$('StudentID').readonly = true;
	$('filter').value = "yes";
	$('form1').submit();
}
function showAddForm(){
	$('filter').value = "add";
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
function delEntry(){
	new Ajax.Request("remove-class.php", 
		{ 
		method: 'post', 
		parameters: $('form2').serialize(true),
		onComplete: showResponse 
		});
	$('alert').style.visibility = "visible";
	$('alert').innerHTML = "Class Removed";
	}
</script>		
<?php
// **DEBUG
//echo "filter : ".$filter ."<BR>";
//echo "query : ".$query_S ."<BR>";
//echo "ID : ".$StudentID ."<BR>";
?>
<form id="form1" name="form1" action="admin.php?page=classes" method="post">
	<p><strong style="line-height: 30px;">Student ID: </strong>
	  <input type="textarea" id="StudentID" name="StudentID" style="margin-left: 11px; width: 200px; height: 25px;"  value="<?php if (isset($StudentID)) { echo $StudentID; } else { echo ""; }?>" onKeyPress="return disableEnterKey(event)" />
	<input id="btn" type="button" style="margin-left: 30px; height: 25px;" onClick="submitForm1();" value="Submit" onKeyPress="submitForm1();" />

	</p><hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
	<strong style="line-height: 30px;">Student: </strong>
	
	<input id="filter" name="filter" type="hidden" value="<?php echo $filter; ?>" />
	<select id="studentList" name="studentList" style="float: right; width: 300px; height: 25px; margin-right: 35px; margin-top: 5px;" onChange="submitForm2();">
		<option <?php if (isset($StudentID)) { echo ""; } else { echo "selected"; } ?> value="">Select a student...</option>
<?php

//***** DATABASE *****
if (isset($StudentID)){
	$ins = "WHERE students.StudentID = '$StudentID'";
} else {
	$ins = "";
}
mysql_select_db($database_equip, $equip);

$query_S = "SELECT * FROM students $ins ORDER BY students.LastName ASC";
$Students = mysql_query($query_S, $equip) or die(mysql_error());
$row_Students = mysql_fetch_assoc($Students);
$totalRows_Students = mysql_num_rows($Students);

//***** LOOP SELECT BOX *****
mysql_data_seek($Students,0);
while($loop_Students = mysql_fetch_assoc($Students)) {
?>
<option 
<?php $sID = $loop_Students['StudentID'];
		if ($StudentID == $sID) {
			echo "selected";
		} else {
			echo "";
		}
?> value="<?php echo $loop_Students['StudentID']; ?>"><?php echo $loop_Students['LastName']. ", " .$loop_Students['FirstName']. " - " .$loop_Students['StudentID']; ?></option>
<?php 
} 
?>
	</select>
</form>
	<hr/ style="border: 0px; height: 3px; background-color: #ffcc00;">
<?php 

//***** RECORD FORM *****
if ($filter == "yes") {
?>
	<div id="showClass">
	<form id="form2" name="form2" action="remove-class.php" method="post">
<?php

mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT student_class.ID AS scID, student_class.StudentID, student_class.ClassID, class.Name FROM student_class INNER JOIN class ON student_class.ClassID = class.ID WHERE StudentID = '$StudentID'");
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if ($totalRows_Students >= 1) {
echo "<p><u><strong>The Class(es) this Student is in (totaling " . $totalRows_Recordset2 . "):</strong></u> <br>";

if (isset($row_Recordset2['ClassID'])) {
do {
	if (empty($ClassIDSQL)){
		$ClassIDSQL = $row_Recordset2['ClassID'];
	} else {
		$ClassIDSQL = $ClassIDSQL . " OR kit_class.ClassID = " . $row_Recordset2['ClassID'] ;
	}
	?>
	<a id="remClass" href="#" onClick="answer=confirm('Remove this class for this student?');if(answer!=0){$('rmClassID').value=<? echo $row_Recordset2['scID']; ?>;delEntry();}else{alert('Canceled')}" >
	<img id="remClass" src="<?php echo $root; ?>/images/remove_icn.png" border="0" title="Remove Class" /></a>
	<? echo $row_Recordset2['Name']; ?><br/> 
	<?php
	}
while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
}
?>
<input id="rmClassID" name="rmClassID" type="hidden" value="" />
</form>
<?
//***** ADD CLASS FORM *****

$classes = mysql_query("SELECT * FROM class") or die(mysql_error());  ?>
<form name="form" action="add-class.php" method="post">
<select name="class" size="1" id="class">
<? while($option = mysql_fetch_array( $classes )) {

// Print out the contents of each row into an option 
echo "<option value='$option[Name]'>$option[Name]</option>";
} ?>
</select>
<input name="StudentID" type="hidden" value="<?php echo $StudentID; ?>">
<input type="submit" name="Submit" value="Add">
<br><span class="alert"><?php echo $alert; ?></span>
</form> 

<?php
} else {
	if ($totalRows_Students < 1) {
echo "<FONT COLOR='red'><br>This Student is NOT registered to checkout.</FONT><br>";
	}
}
?>
<br />
<br />
<a href="#" style="float: right; margin-right: 10px;" onClick="refreshPage()">
	<img src="<?php echo $root; ?>/images/cancel-button.png" border="0" title="Cancel" /></a>
</div>
<?php
//****end if for #showClass
}
?>
<?php
mysql_free_result($Students);
?>
