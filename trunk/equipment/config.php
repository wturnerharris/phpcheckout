<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_equip = "localhost";
$database_equip = "equipment";
$username_equip = "root";
$password_equip = "new-password";
$equip = mysql_pconnect($hostname_equip, $username_equip, $password_equip) or die(mysql_error());

$weekends = false; // if open weekends, flag this


// set your open and close times here. System will only work with Hour arguments, input hour in 24 our time in format HH
$monOpen = 00;
$monClose = 00;
$tueOpen = 14;
$tueClose = 17;
$wedOpen = 14;
$wedClose = 17;
$thuOpen = 14;
$thuClose = 17;
$friOpen = 14;
$friClose = 17;
$satOpen = 14;
$satClose = 17;
$sunOpen = 00;
$sunClose = 00;


// fine controls
$fineAmount = 5.00; // amount of fine
$fineFreq = 900; // amount of time per fine increment, in seconds
$maxFine = 100.00; // max amount of fine per kit

$root = "http://www.witdesigns.com/equipment";
?>
