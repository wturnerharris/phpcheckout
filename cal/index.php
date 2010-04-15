<?php
require_once('../equipment/config.php');
require_once('classes/tc_calendar.php');

header ("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
header ("Pragma: no-cache");

$theDate = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Reservations</title>
<link href="calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="calendar.js"></script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<div id="cal" style="margin-left: 15px;">
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
  	  ?>
    </form>
	</div>
	<div id="class_selector" style="position: absolute; top: 50px; right: 300px;">
	<h1>Selected Date: </h1><h2><strong><? echo $theDate; ?></strong></h2><br/>
  	<?php
    $class = $_REQUEST['class'];
    
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
    		mysql_free_result($option);
    	?>
    	</select>
  	</form>
	</div>
<?php
// get item names based on selected class
mysql_select_db($database_equip, $equip);
$selectedClass = "SELECT kit.Name as KitName, kit.ID as KitID, class.Name as ClassName FROM kit LEFT JOIN kit_class ON kit_class.KitID = kit.ID LEFT JOIN class ON class.ID = kit_class.ClassID WHERE class.Name = '$class'";
$kitNames = mysql_query($selectedClass, $equip) or die("Could not perform select query - " . mysql_error());

// get items reserved today and items that are checked out and due in future
$find = "SELECT kit.Name as kitName, kit.ID as KitID, checkedout.ID as CheckedID, checkedout.ReserveDate, checkedout.DateOut, checkedout.DateIn, checkedout.ExpectedDateIn FROM kit LEFT JOIN checkedout ON checkedout.KitID = kit.ID WHERE ReserveDate >= '$theDateSQL1' OR DateOut < '$theDateSQL2' AND DateIn = '' ORDER BY kitName";
$kitReserved = mysql_query($find, $equip) or die("Could not perform select query - " . mysql_error());
$row_kitReserved = mysql_fetch_assoc($kitReserved);
$reservedKitID = $row_kitReserved['KitID'];
$totalRows_kitReserved = mysql_num_rows($kitReserved);

//make an array of currently checked out or reserved items
$item = array();
mysql_data_seek($kitReserved,0);
while ($loopReserved = mysql_fetch_assoc($kitReserved)) {
  array_push($item, $loopReserved);
}

//debug array
print_r($item);

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
<p>Div Header</p>
<p>Div Calendar Selector | Week of: Date | Div Reservation Class</p>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="160">Items</td>
    <?php
    for ($i=0; $i<7; $i++){ 
      echo "<td width='70'>".$day[$i]."<br>".$date[$i]."</td>";
    }
  echo "</tr>\n";

  //get items from
  mysql_data_seek($kitNames,0);
  while($kitName = mysql_fetch_array( $kitNames )) {
  	echo "<tr>\n";
  	echo "<td>".$kitName['KitName']."-".$kitName['KitID']."</td>\n";
  	$currKitID = $kitName['KitID'];

  	for ($i=0; $i<7; $i++){
		//day0 (selected day)
  	echo "<td>\n";
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

      if ($day[$i] == $dayClosed1 || $day[$i] == $dayClosed2) {
          echo "CLOSED";
      } elseif ($itemRdate == $date[$i] || $itemRdate == date("Y-m-d",strtotime($date[$i]."- 1 days")) || $itemRdate == date("Y-m-d",strtotime($date[$i]."- 2 days"))) {
        echo "<font color='red'>*reserved*</font>";
			} elseif ($itemCdate == $date[$i].' 17:00:00' || $itemCdate == date("Y-m-d",strtotime($date[$i]."+ 1 days")).' 17:00:00' || $itemCdate == date("Y-m-d",strtotime($date[$i]."+ 2 days")).' 17:00:00') {
        echo "<font color='red'>*checked out*</font>";
   		} else {
      echo "<a href='#'>*available*</a>";
			}
		}
		echo "</td>\n";
  	}
		?>
    </tr>
    <?php } ?>
</table>
<p>Div Footer</p>
<?
//print_r($row_kitReserved);
?>
</body>
</html>
