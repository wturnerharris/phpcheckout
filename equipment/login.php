<?php 

require_once('config.php'); 

$Username = $_REQUEST['Username'];
$Password = $_REQUEST['Password'];

// encrypt password
$encrypted_mypassword=md5($Password);

//CHECK USERNAME AND PASSWORD
if (isset($Username)) {

	if (empty($Password)) {
?>
	<script type="text/javascript">
alert('You must enter a valid password. Please try again.');
</script>
<?php
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=error.php\">";
	} else {

		mysql_select_db($database_equip, $equip);
		$query_Recordset1 = sprintf("SELECT * FROM users WHERE Username = '$Username'");
		$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
		$row_Recordset1 = mysql_fetch_assoc($Recordset1);
		$totalRows_Recordset1 = mysql_num_rows($Recordset1);
	
	
		if ($row_Recordset1['Password'] == $encrypted_mypassword) { 
			//session_name('EquipmentCheckout');
			//start the session and register a variable
			session_name("EquipmentCheckout");
			session_start();
			session_register($Username);
			// this sets variables in the session
			$_SESSION['user'] = $Username;
			$_SESSION['auth'] = 'true';
			$_SESSION['time'] = time();
			//setcookie("EquipmentCheckout", $Username, time()+60*60*24); 
			mysql_free_result($Recordset1);
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
		} else {
			//echo $row_Recordset1['Password'] . " = " . $_REQUEST['Password'] . "?<p>";
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=error.php\">";
			mysql_free_result($Recordset1);
	
		} 
	}
} else {

//SHOW LOGIN FORM
?>
<? include('includes/heading2.html'); ?>
<div style="margin-left: auto; margin-right: auto; text-align: left; width: 300px;">
<p><strong>Enter your user name and password to login.</strong></p>

<form name="form" action="<?php echo $PHP_SELF; ?>" method="post">
<p>
  Username:
    <input name="Username" type="text" id="Username">
  </p>
<p>
  Password :
    <input name="Password" type="password" id="Password"> 
</p>
<p>
  <input type="submit" name="Submit" value="Login">
</p>
</form>
</div>
<? include('includes/footer.html'); ?>

<? } ?>

