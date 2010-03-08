<?php
require_once('config.php');
include('includes/heading.html');
if (!$fines) {
	$fine = "Strikes";
	$FineOrStrike = "(unix_timestamp(DateIn)) > unix_timestamp(ExpectedDateIn)";
	} else {
		$fine = "Fines";
		$FineOrStrike = "(unix_timestamp(DateIn) - $fineFreq) > unix_timestamp(ExpectedDateIn)";
		}
if (empty($_REQUEST['StudentID'])) {
$SQL = " AND FinePaid is NULL";
echo "<center><h1>Current $fine List</h1></center>";
} else {
$SQL = " AND checkedout.StudentID = " . $_REQUEST['StudentID'];
echo "<center><h1>Current $fine List</h1></center>";
echo "<strong>HISTORY OF ".strtoupper($fine)." FOR STUDENT ID #:</strong> " . $_REQUEST['StudentID'];
echo "<hr />";
}
mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT FirstName, LastName, checkedout.ID, checkedout.StudentID, checkedout.DateOut, checkedout.ExpectedDateIn, checkedout.DateIn, checkedout.kitID, checkedout.FinePaid, checkedout.Strike, kit.Name FROM checkedout LEFT JOIN students ON students.StudentID = checkedout.StudentID LEFT JOIN kit ON checkedout.kitID = kit.ID WHERE $FineOrStrike $SQL";


$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if (isset($row_Recordset1['StudentID'])) {
do {

?>
<p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Student Name: </strong><?php echo $row_Recordset1['FirstName']; ?> <?php echo $row_Recordset1['LastName']; ?><strong><br>
  Student ID #: </strong><a href="studentinfo.php?StudentID=<?php echo $row_Recordset1['StudentID']; ?>"><?php echo $row_Recordset1['StudentID']; ?></a>
  <br>
    <strong>Returned Late:</strong> Equipment ID #<?php echo $row_Recordset1['kitID']; ?> - <?php echo $row_Recordset1['Name']; ?><strong><br>
  Date Checked Out:</strong> <?php
  //echo $row_Recordset1['DateOut'];
  echo date("D F j, Y, g:i a", strtotime($row_Recordset1['DateOut']));
  ?>
  <br>
  <strong>Expected Return Date:</strong> <?php echo date("D, F j, g:i a", strtotime($row_Recordset1['ExpectedDateIn'])); ?><br>
  <strong>Actual Return Date:</strong> <?php echo date("D, F j, g:i a", strtotime($row_Recordset1['DateIn'])); ?> <br>
  <? if ($fines) { ?>
  <strong>Fine Rate Per <?php echo $fineFreq/60?> Minutes:</strong> <?php echo "$".number_format($fineAmount,2); ?> <br>
  <? } ?>
  <?php if (!$fines) { echo "<strong>Strikes: </strong>".$row_Recordset1['Strike']; } else { echo "<strong>Amount Due: </strong>$"; ?>
  		<?php $timeDue = date(strtotime($row_Recordset1['ExpectedDateIn']));
				$timeIn = date(strtotime($row_Recordset1['DateIn']));
				$diff = abs($timeIn - $timeDue);
				if ($diff > $fineFreq) {
				$inc = round($diff/$fineFreq);
				$fineDue = $inc * $fineAmount;
				$fineDue = round($fineDue,2);
				if ($fineDue > $maxFine) {
					$fineDue = $maxFine;
					}
				} else { // the item was less than $fineFreq late, therefore no fine is issued
					$fineDue = 0.00;
					if (empty($row_Recordset1['FinePaid'])) { // this item hasn't been cleared, clear it and force a refresh to update screen
					$CheckedOutID = $row_Recordset1['ID'];
					$noFine = "UPDATE checkedout SET FinePaid = '0.00' WHERE ID = $CheckedOutID";
					//echo $sql;
					mysql_select_db($database_equip, $equip);
					mysql_query($noFine, $equip) or die(mysql_error());
					echo "<meta http-equiv='refresh' content='0'>";
					}
					// make this clear the fine from the list (set FinePaid)
				}
				echo number_format($fineDue,2); }
				if (empty($row_Recordset1['FinePaid']) || $row_Recordset1['Strike'] >=1) { 
		
$username = $_COOKIE["EquipmentCheckout"];
mysql_select_db($database_equip, $equip);

$access = "SELECT * FROM users WHERE Username = '$username'";

$entry = mysql_query($access, $equip) or die(mysql_error());
$row_entry = mysql_fetch_assoc($entry);
$totalRows_entry = mysql_num_rows($entry);

if ($row_entry['Type'] == "Admin") { ?>

<form name="form1" method="post" action="finesaction.php">
<strong>Clear <? echo $fine; ?>:</strong>  
<? if ($fines){ ?>
<input name="FinePaid" class="TextField" type="text" id="FinePaid" value="<?php echo number_format($fineDue,2); ?>">
<input name="CheckedOutID" type="hidden" value="<?php echo $row_Recordset1['ID']; ?>">
<input name="StudentID" type="hidden" value="<? echo $_REQUEST['StudentID']; ?>">
<input type="submit" name="Submit" value="Pay">
<? } else { ?>
<select name="FinePaid" class="TextField" id="FinePaid">
  <option value="0">0</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
</select>
<input name="CheckedOutID" type="hidden" value="<?php echo $row_Recordset1['ID']; ?>">
<input name="StudentID" type="hidden" value="<? echo $_REQUEST['StudentID']; ?>">
<input type="submit" name="Submit" value="Set">
<? } ?>
</form>
<?php 
} else { ?>
<br><br><span class="alert">Only an administrator may clear <? echo $fine; ?>.</span>
<?php }} ?>
<P>
<p> 
<HR>

<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
} else {
echo "<P>No $fine Found. Enter a Student ID below.</P>";
}
?>
<form action="fines.php" method="post">
<strong>Find Student Fines by ID:</strong><br>  
<input name="StudentID" id="StudentID" class="TextField" type="text" value="<? echo $_REQUEST['StudentID']; ?>">
<input name="" type="submit" Value="Search">
</form>
<?
mysql_free_result($Recordset1);
include('includes/footer.html');
?>
