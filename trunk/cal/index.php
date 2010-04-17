<?php
require_once('classes/tc_calendar.php');
require_once('../equipment/config.php');
include('includes/heading.html'); 

$class = $_REQUEST['class'];
$theDate = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
?>
	<div id="cal">
    <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <p class="largetxt"><b>Select Date: </b></p>
      <?php
      $thisYear = date("Y");
      $thisDate = date("Y-m-d");
      $thisRange = date("Y-m-d",strtotime("+13 days"));
  	  $myCalendar = new tc_calendar("date1");
  	  $myCalendar->setIcon("images/iconCalendar.gif");
  	  if (!empty($theDate)) {
        $newDate = strtotime($theDate);
        $myCalendar->setDate(date('d', $newDate), date('m', $newDate), date('Y', $newDate));
        $theDateSQL1 = date("Y-m-d",strtotime($theDate));
        $theDateSQL2 = date("Y-m-d H:i:s",strtotime($theDate));
        $theDate = date("D, F d, Y", $newDate);
			} else {
        $myCalendar->setDate(date('d'), date('m'), date('Y'));
        $theDateSQL1 = date("Y-m-d");
        $theDateSQL2 = date("Y-m-d H:i:s");
        $theDate = date("D, F d, Y");
    	}
  	  $myCalendar->setPath("./");
  	  $myCalendar->setYearInterval($thisYear, $thisYear);
  	  $myCalendar->dateAllow($thisDate, $thisRange, false);
  	  $myCalendar->startMonday(true);
			//$myCalendar->setDateFormat('d, m, Y');
  	  //$myCalendar->autoSubmit(true, "", "index.php");
  	  $myCalendar->autoSubmit(true, "form1");
  	  $myCalendar->writeScript();
  	  echo "<input type='hidden' name='class' id='class' value='$class'>";
  	  ?>
    </form>
	</div>
	<div id="class_selector">
	<h1>Selected Date: </h1><h2><strong><? echo $theDate; ?></strong></h2><br/>
  	<?php
    
    // LIST BY CLASS
    mysql_select_db($database_equip, $equip);
    $classes = mysql_query("SELECT * FROM class ORDER BY class.Name") or die(mysql_error());  
  	?>

  	<form name="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    	<select name="class" size="1" id="class" style="margin-left: 10px; margin-bottom: 5px;" onChange="this.form.submit();">
			<? while($option = mysql_fetch_array( $classes )) {
        // Print out the contents of each row (class) into an option
    		if ($class == "") { $class = $option[Name]; }
    		if ($class == "$option[Name]") { 
    			$echo = " selected"; 
    		} else { 
    			$echo = ""; 
    		}
    		echo "<option $echo value='$option[Name]'>$option[Name]</option>";
    		}
    	?>
    	</select>
		<input type="hidden" name="date1" value="<?php echo $theDateSQL1; ?>">
  	</form>
	</div>
<?php
// get item names based on selected class
mysql_select_db($database_equip, $equip);
$selectedClass = "SELECT kit.Name as KitName, kit.ID as KitID, kit.Repair as Repair, class.Name as ClassName FROM kit LEFT JOIN kit_class ON kit_class.KitID = kit.ID LEFT JOIN class ON class.ID = kit_class.ClassID WHERE class.Name = '$class' ORDER BY kit.Name";
$kitNames = mysql_query($selectedClass, $equip) or die("Could not perform select query - " . mysql_error());

//make an array of repair items
$selectedClass = "SELECT * FROM kit WHERE Repair = 1 ORDER BY Name";
$repairs = mysql_query($selectedClass, $equip) or die("Could not perform select query - " . mysql_error());
$repair = array();
mysql_data_seek($repairs,0);
while ($loopRepair = mysql_fetch_assoc($repairs)) {
  array_push($repair, $loopRepair['ID']);
}

// get items reserved today and items that are checked out and due in future
$find = "SELECT kit.Name as kitName, kit.ID as KitID, checkedout.ID as CheckedID, checkedout.ReserveDate, checkedout.DateOut, checkedout.DateIn, checkedout.ExpectedDateIn FROM kit LEFT JOIN checkedout ON checkedout.KitID = kit.ID WHERE ReserveDate >= '$theDateSQL1' OR DateOut < '$theDateSQL2' AND DateIn = '' ORDER BY kitName";
$kitReserved = mysql_query($find, $equip) or die("Could not perform select query - " . mysql_error());
$row_kitReserved = mysql_fetch_assoc($kitReserved);
$reservedKitID = $row_kitReserved['KitID'];
$totalRows_kitReserved = mysql_num_rows($kitReserved);

//make an array of currently checked out and reserved items
$item = array();
mysql_data_seek($kitReserved,0);
while ($loopReserved = mysql_fetch_assoc($kitReserved)) {
  array_push($item, $loopReserved);
}

//debug array of checked out and reserved items
//echo "<pre>";
//print_r($item);
//echo "</pre>";

//get days
$day = date("D",strtotime($theDate));
$day = array($day);
$date = date("Y-m-d",strtotime($theDate));
$date = array($date);
for ($i =1; $i <7; $i++){
  array_push($day, date("D",strtotime($theDate."+ $i days")));
  array_push($date, date("Y-m-d",strtotime($theDate."+ $i days")));
}

?>
<div id="table">
<table width="735" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="box">Items</td>
    <?php
    for ($i=0; $i<7; $i++){ 
      echo "<td class='box'>".$day[$i]." ".date("n/j",strtotime($date[$i]))."</td>";
    }
    echo "</tr>\n";

    //get items from
	mysql_data_seek($kitNames,0);
	while($kitName = mysql_fetch_array( $kitNames )) {
		echo "<tr>\n";
	  	echo "<td class='box'>".$kitName['KitName']."</td>\n";
	  	$currKitID = $kitName['KitID'];

	  	for ($i=0; $i<7; $i++){
	  		//day0 (selected day)
	  		$kits = array();
			mysql_data_seek($kitReserved,0);
		  	while ($loopRes = mysql_fetch_assoc($kitReserved)) {
		      array_push($kits, $loopRes['KitID']);
		    }
			if (in_array($currKitID,$kits)) {
				$r = array_keys($kits,$currKitID);
				//$r = array_keys($item,$currKitID);
				$r = $r[0];
				//print_r($r);
				$itemRdate = $item[$r]['ReserveDate'];
				$itemCdate = $item[$r]['ExpectedDateIn'];
				$itemOdate = $item[$r]['DateOut'];
				$d1 = strtotime($itemOdate);
				$d2 = strtotime($itemCdate);
				$dayDiff = floor(($d2-$d1)/86400);
				$hrs = " ".$dueHours;
				
				if ($day[$i] == $dayClosed1 || $day[$i] == $dayClosed2) {
					echo "<td class='box closed'>&nbsp;";
					//echo "<strong>*CLOSED*</strong>";
					echo "</td>\n";
				} elseif ($itemRdate == $date[$i] || $itemRdate == date("Y-m-d",strtotime($date[$i]."- 1 days"))
				 || $itemRdate == date("Y-m-d",strtotime($date[$i]."- 2 days"))) {
					echo "<td class='box reserved'>&nbsp;";
					//echo "<font color='red'>*reserved*</font>";
					echo "</td>\n";
				} elseif ($itemRdate == date("Y-m-d",strtotime($date[$i]."- 4 days"))
				 || $itemRdate == date("Y-m-d",strtotime($date[$i]."- 3 days"))){
					if (date("D",strtotime($date[$i]."- 3 days")) == $dayClosed1
					 || date("D",strtotime($date[$i]."- 1 days")) == date("D",strtotime($itemCdate))
					  || date("D",strtotime($date[$i]."- 2 days")) == date("D",strtotime($itemCdate))){
						echo "<td class='box open'>";
						echo "<a class='link' href='reserve.php?KitID=$currKitID&StudentID=$sid&date=$date[$i]'></a>";
						echo "</td>\n";
					} else {
						echo "<td class='box reserved'>&nbsp;";
						//echo "<font color='red'>*reserved*</font>";
						echo "</td>\n";
					}
				} elseif (empty($itemRdate)) {
					if (strtotime($date[$i]) >= $d1 && strtotime($date[$i]) <= $d2) {
						echo "<td class='box checked'>&nbsp;";
						//echo "<font color='yellow'>*checked*</font>";
						echo "</td>\n";
					} else {
						echo "<td class='box open'>";
						echo "<a class='link' href='reserve.php?KitID=$currKitID&StudentID=$sid&date=$date[$i]'></a>";
						echo "</td>\n";
					}
				} else {
					echo "<td class='box open'>";
					echo "<a class='link' href='reserve.php?KitID=$currKitID&StudentID=$sid&date=$date[$i]'></a>";
					echo "</td>\n";
				}
			} else {
				if ($day[$i] == $dayClosed1 || $day[$i] == $dayClosed2 || in_array($currKitID,$repair)) {
					echo "<td class='box closed'>&nbsp;";
					//echo "<strong>*CLOSED*</strong>";
					echo "</td>\n";
				} else {
					echo "<td class='box open'>";
					echo "<a class='link' href='reserve.php?KitID=$currKitID&StudentID=$sid&date=$date[$i]'></a>";
					echo "</td>\n";
				}
			}
  		}
		?>
    </tr>
    <?php } ?>
</table>
</div>
<?
include('includes/footer.html');
//print_r($row_kitReserved);
?>