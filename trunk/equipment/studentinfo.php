<?php require_once('config.php');

// *******************
// Check for ID 
// If none, send back to start
// *******************

if (empty($_REQUEST['StudentID'])) {
?>
<? include('includes/heading.html'); ?>  
<meta http-equiv="refresh" content="60;URL=studentid.php">
</head>
<body>
<p><h3 class="alert">No student ID selected. Enter a valid Student ID.</h3></p>
<form name="form" action="studentinfo.php" method="post">
<strong>Please swipe student's ID card or enter the student's ID: </strong> <br>
<input name="StudentID" class="TextField" type="text" id="StudentID">
<input type="submit" name="Submit" value="Submit">
<br>
</form>

<? } else {

// *******************
//  PART 1 - Student Info
// *******************

$StudentID = $_REQUEST['StudentID'];
if (substr($StudentID, 0, 1) == " ") {
	$StudentID = substr($StudentID, 1, 14);
	// echo "reset ID = " . $StudentID;
	} else {
		$lengthID = strlen($StudentID) - 1;
		// echo $lengthID;
		if (substr($StudentID, $lengthID, 1) == " ") {
			$StudentID = substr($StudentID, 0, 14);
		} else { 
			if (strlen($StudentID) > 14) {
				unset($StudentID);
			}
		}
	}
if (!$fines) { 
	$fine = "Strike";
	$penalty = "Strike >= 1";
	$frequency = $gracePeriod;
} else {
	$fine = "Fines";
	$penalty = "FinePaid IS NULL";
	$frequency = $fineFreq;
}
mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT * FROM students WHERE StudentID = \"$StudentID\"";
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_equip, $equip);
$query_Fines = "SELECT * FROM checkedout WHERE (unix_timestamp(DateIn) - $frequency) > unix_timestamp(ExpectedDateIn) AND $penalty AND StudentID =  \"$StudentID\"";
$Fines = mysql_query($query_Fines, $equip) or die(mysql_error());
$row_Fines = mysql_fetch_assoc($Fines);
$totalRows_Fines = mysql_num_rows($Fines);

include('includes/heading.html');  
// STUDENT INFO AT TOP
?>
<center><h1>Student Information</h1></center> 
<? if($row_Recordset1['StudentID']!=""){ ?>
Name: <?php echo $row_Recordset1['FirstName']; ?> <?php echo $row_Recordset1['LastName']; ?><br />
E-mail: <a href="mailto:<?php echo $row_Recordset1['Email']; ?>"><?php echo $row_Recordset1['Email']; ?></a><br />
Phone: <?php 
if ($row_Recordset1['Phone'] == "") { 
	echo "<a class='alert' href='admin/admin.php?page=students'>No Phone Number on File</a>";
} else {
	$phoneParse = $row_Recordset1['Phone'];
	echo "(" . substr($phoneParse,0,3).") " . substr($phoneParse,3,3) . "-". substr($phoneParse,6,4);
}
	 ?><br /> 
Student ID: <?php echo $row_Recordset1['StudentID']; ?><br />
LDAP: <a href="studentinfo.php?StudentID=<?php echo $row_Recordset1['StudentID']; ?>" target="_parent">Lookup Entry</a><br /><br/>
<?php 
if($Fines!=0){
	if(isset($row_Fines['ID'])) {
		echo "<span class='alert'>STUDENT HAS ".strtoupper($fine)."!!!</span><br>";
}	}

} else {
echo "<span class='alert'>There is no student with ID number $StudentID in the system.</span><br><br>";
echo "<strong>To ADD this Student, click <a href='admin/admin.php?page=students&StudentID=$StudentID'>here</a>.</strong>";
}


// *******************
//  PART 3 - Equip already Checked out
// *******************

$colname_Recordset4 = "1";
if (isset($_REQUEST['StudentID'])) {
  $colname_Recordset4 = (get_magic_quotes_gpc()) ? $_REQUEST['StudentID'] : addslashes($_REQUEST['StudentID']);
}
mysql_select_db($database_kit, $equip);
$query_Recordset4 = sprintf("SELECT kit.ID AS KitID, checkedout.ID AS CheckOutID, kit.Name, checkedout.DateOut, checkedout.ExpectedDateIn FROM checkedout INNER JOIN kit ON kit.ID = checkedout.KitID WHERE checkedout.DateIn = '' AND StudentID = \"$StudentID\"");
//echo $query_Recordset4 ;
$Recordset4 = mysql_query($query_Recordset4, $equip) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

?>
<p>
<HR>
<u><strong>Kits checked out by this student:</strong></u> (To check in equipment, click the link below)<br>
<?php if($row_Recordset4['CheckOutID']>1) { ?>
<br>
<table width="100%" border="0">
<thead>
	<tr>
		<th scope="col">Item</th>
		<th scope="col">Date Checked Out</th>
		<th scope="col">Date Due Back</th>
	</tr>
</thead>
<?php do { ?>
<tr>
    <td>
		<ul class="nav">
		<li><strong><?php echo $row_Recordset4['Name']; ?></strong>
			<ul>
			<li><a href="checkin.php?CheckedOutID=<?php echo $row_Recordset4['CheckOutID']; ?>&KitID=<?php echo $row_Recordset4['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>" title="Check-in">Check-in</a></li>
			<li><a href="renew.php?CheckedOutID=<?php echo $row_Recordset4['CheckOutID']; ?>&KitID=<?php echo $row_Recordset4['KitID']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>" title="Renew">Renew</a></li>
			</ul>
		</li>
		</ul>
	</td>
	<td><?php echo date("D, F j, g:i a", strtotime($row_Recordset4['DateOut'])); ?></td>
    <td><?php 
	if (time() > strtotime($row_Recordset4['ExpectedDateIn'])) {
	?><strong class='alert'><?php echo date("D, F j, g:i a", strtotime($row_Recordset4['ExpectedDateIn'])); ?>
	</strong> <?php } else { echo date("D, F j, g:i a", strtotime($row_Recordset4['ExpectedDateIn'])); }?></td>
  </tr>
<?php } while ($row_Recordset4 = mysql_fetch_assoc($Recordset4)); ?>
</table>
<HR>
<?php
}

// *******************
//  PART 2 - Kits Avilable
// *******************


$colname_Recordset2 = "1";

$gLimitToClass ="Yes"; 
if ($gLimitToClass="Yes"){
if (isset($_REQUEST['StudentID'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $_REQUEST['StudentID'] : addslashes($_REQUEST['StudentID']);
}
mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT * FROM student_class INNER JOIN class ON student_class.ClassID = class.ID WHERE StudentID = \"$StudentID\"");
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// For each class get a list of kit that isn't currently checked out
echo "<p><u><strong>The Class(es) this Student is in:</strong></u> <br>";

if (isset($row_Recordset2['ClassID'])) {
do {
	if (empty($ClassIDSQL)){
		$ClassIDSQL = $row_Recordset2['ClassID'];
	} else {
		$ClassIDSQL = $ClassIDSQL . " OR kit_class.ClassID = " . $row_Recordset2['ClassID'] ;
	}
	echo $row_Recordset2['Name'] . "<br>"; 
 } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
 
////ADD REMOVE CLASSES LINK
echo "<br><strong>To add or remove classes for this Student, click <a href=\"admin/admin.php?page=classes&StudentID=$StudentID\">here</a>.</strong>";

mysql_select_db($database_equip, $equip);
$query_Recordset3 = "SELECT kit.ID AS KitID, kit.Name, kit.ContractRequired, kit.Repair FROM kit_class INNER JOIN kit ON kit_class.KitID = kit.ID WHERE kit_class.ClassID = $ClassIDSQL GROUP BY KitID ORDER BY Name ASC";
$Recordset3 = mysql_query($query_Recordset3, $equip) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
} else {
echo "<br/><strong class='alert'>This Student is either NOT registered for checkout or needs to be added to a class.</strong><br>";

if($row_Recordset1['StudentID']!=""){

// ADD STUDENT TO A CLASS
$classes = mysql_query("SELECT * FROM class ORDER by class.Name") or die(mysql_error());  ?>

<form name="form" action="admin/add-class.php" method="post">
<select name="class" size="1" id="class">
<? while($option = mysql_fetch_array( $classes )) {

// Print out the contents of each row into an option 
echo "<option value='$option[Name]'>$option[Name]</option>";
} ?>
</select>
<input name="StudentID" type="hidden" value="<?php echo $row_Recordset1['StudentID']; ?>">
<input type="submit" name="Submit" value="Add Class">
<br><span class="alert"><?php echo $alert; ?></span>
</form> 
<?
}
$NoClasses = 1;
//Additional Contract Required?

mysql_select_db($database_kit, $equip);
$query_Recordset3 = "SELECT ID AS KitID, Name, ContractRequired FROM kit";
$Recordset3 = mysql_query($query_Recordset3, $equip) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
}
?>

<HR>
<strong><u>Kits available for checkout:</u></strong>
 (To check out equipment, click the link below)<br>
<?
// For each kit, check to see if it's checked out.
// This should be changed later - Kevin

if($NoClasses!=1){

if (!$fines) { //for strikes
	mysql_select_db($database_kit, $equip);
	$strikesTotal = "SELECT SUM($fine) FROM checkedout WHERE (unix_timestamp(DateIn) - $frequency) > unix_timestamp(ExpectedDateIn) AND $fine >= 1 AND StudentID = \"$StudentID\"";
	$strikesQuery = mysql_query($strikesTotal, $equip) or die(mysql_error());
	$strikesResult = mysql_result($strikesQuery, 0);
	// echo $strikesResult;
	if ($strikesResult >= 1) {
	    echo "<p class='alert'>Student has $strikesResult $fine(s)<br><br>";
	}
	if($strikesResult >=3){
		echo "<p class='alert'>UNAVAILABLE. Student Banned.</p>";
		$penaltyLevel = 3;
		} elseif ($strikesResult == 2) {
			// check if banned has been lifted
			mysql_select_db($database_equip, $equip);
			$query_Banned = "SELECT BannedDate FROM checkedout WHERE StudentID =  \"$StudentID\" AND BannedDate IS NOT NULL";
			$Banned = mysql_query($query_Banned, $equip) or die(mysql_error());
			$row_Banned = mysql_fetch_assoc($Banned);
			$BannedDate = $row_Banned['BannedDate'];
			// if current ban in place
			if (intval(strtotime("$BannedDate")) > intval(strtotime("now")) && $row_Banned >= 1) {
				// echo intval(strtotime($BannedDate))." should be greater than ". intval(strtotime("now"))."<br>";
				echo "<span class='alert'>This student is currently on a two week ban, which ends: ".date("m-d-Y", strtotime("$BannedDate")).".</span></p>";
				// THEN set $penaltyLevel
				$penaltyLevel = 2;
				} else {
					//or if ban has expired
					echo "<span class='alert'>Was originally banned until ".date("m-d-Y", strtotime("$BannedDate")).". Next lateness will result in being permanently banned for the duration of the semester.</span></p>";
					$penaltyLevel = 1;
					}
			} elseif ($strikesResult == 1) {
				echo "<span class='alert'>Warn Student: The next late return will result in a two-week ban.</span></p>";
				$penaltyLevel = 1;
			} elseif ($strikesResult < 1 || $strikesResult == "NULL") {
				$penaltyLevel = 0;
			}
}

if($fines) { //for fines
	if($Fines!=0){
		if(isset($row_Fines['ID'])) {
			echo "<h3><a class='alert' href='fines.php?StudentID=$StudentID'><strong>This student may not currently check out any equipment. <br>Click here to see outstanding $fine on this student.</strong></a></h3>";
			$penaltyLevel = 3;
		}
	}
}

if (empty($row_Recordset1['ContractSigned'])) {
	?>
	<strong class="alert">This student has not yet signed a contract. After the student has signed a paper contract, click the button below.</strong>
	<form action="contractaction.php" method="post">
	<input name="StudentID" type="hidden" value="<? echo $StudentID ?>">
	<input type="submit" value="Contract Signed">
	</form>
<?php } else {

if ($penaltyLevel <= 1) {
?>
<br>
<table width="100%" border="0">
<thead>
	<tr>
		<th scope="col">Item</th>
		<th scope="col">Date Checked Out</th>
		<th scope="col">Date Due Back</th>
	</tr>
</thead>
<?php
do { 

$ServerKitID = $row_Recordset3['KitID'];
mysql_select_db($database_kit, $equip);
$query_Recordset5 = "SELECT * FROM checkedout WHERE KitID = $ServerKitID AND DateIn = ''";
$Recordset5 = mysql_query($query_Recordset5, $equip) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);

do { 
	if($previousID != $row_Recordset3['KitID']){
?>

<tr>
<td><?php if ($row_Recordset5['ExpectedDateIn'] != '') { echo $row_Recordset3['Name']; ?> </td> 
	<? } else { 
	if ($row_Recordset3['Repair'] !=1) { ?>
		<a href="checkout.php?KitID=<?php echo $row_Recordset3['KitID']; ?>&ContractRequired=<?php echo $row_Recordset3['ContractRequired']; ?>&StudentID=<?php echo $row_Recordset1['StudentID']; ?>"><?php echo $row_Recordset3['Name']; ?></a></td>
	<? } else { echo $row_Recordset3['Name']; }} ?>
	<?php if ($row_Recordset3['Repair'] !=1) { ?>
	<td><?php if($row_Recordset5['DateOut'] !=''){ ?> <strong class="alert"> <?php
					echo date("D, F j, g:i a", strtotime($row_Recordset5['DateOut'])); ?> </strong> <?php
					} else { echo 'Available'; } ?></td>
    <td><?php if($row_Recordset5['ExpectedDateIn'] !=''){ ?> <strong class="alert"> <?php
					echo date("D, F j, g:i a", strtotime($row_Recordset5['ExpectedDateIn'])); ?> </strong> <?php
					} else { echo 'Available'; } ?></td>
		<?php } else { ?> <td><strong>Out for Repairs</strong></td><td><strong>Out for Repairs</strong></td> <?php ;} ?>
  </tr>
<?php 
}
$previousID = $row_Recordset3['KitID'];
} while ($row_Recordset5 = mysql_fetch_assoc($Recordset5)); ?>

<? // }
mysql_free_result($Recordset5); 

 } while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
?>
</table>
<?php
mysql_free_result($Recordset3);
}	}	}  }
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset4);
mysql_free_result($Fines);
}

include('includes/footer.html'); ?>