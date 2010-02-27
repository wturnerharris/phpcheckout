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
$dayClosed1 = "Sun"; // three-digit textual day, usually Sat
$dayClosed2 = "Mon"; // three-digit textual day, usually Sun

// due back BEFORE time
$dueHours = "17:00:00"; // 24 hour time, with minutes and seconds 00:00:00

// set your open and close times here. System will only work with Hour arguments, input hour in 24 hour time in format HH
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
$fineAmount = 1.00; // amount of fine
$fineFreq = 86400; // amount of time per fine increment, in seconds
$maxFine = 3.00; // max amount of fine per kit

$root = "/equipment"; // using absolute paths. from the root to the program folder, with preceding slash and without trailing slash
$site_root = "http://www.yourdomain.com"; //domain name where your installation of checkout resides, no trailing slash

//admin email(s) for error reporting
$admin_email1 = "youradmin@email.com";
$admin_email2 = "";
$admin_email3 = "";

//alerts for adding classes. this is only if you wish to remind lab monitors of anything when they are adding classes to student records.
$alert = "";
?>