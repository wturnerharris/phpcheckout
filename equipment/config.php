<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_equip = "localhost";
$database_equip = "equipment";
$username_equip = "witdesig_equip";
$password_equip = "new-password";
$equip = mysql_pconnect($hostname_equip, $username_equip, $password_equip) or die(mysql_error());

//options
$checkHours = false; //to enable kit-specific due date change to true
$defaultHours = 48; //default hours allowed per kit
$overnights = 2; //number of nights allowed out
$dueToday = true; //only shows items due today on index page, false shows all
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

//USE FINES OR STRIKES
$fines = false;
//if $fines is false, strikes are enabled
$maxStrike = 3;
$gracePeriod = 1800; // grace period in seconds; for strikes as fines ignores the fine unless the full frequency time has passed.
$fineAmount = 1.00; // amount of fine or strike
$fineFreq = 86400; // amount of time per fine increment, in seconds, default is one day.
$maxFine = 3.00; // max amount of fine or strike per kit

//Directory info
$root = "/equipment"; // using absolute paths. from the root to the program folder, with preceding slash and without trailing slash
$site_root = "http://www.yourdomain.com"; //domain name where your installation of checkout resides, no trailing slash

//admin email(s) for error reporting
$admin_email1 = "youradmin@email.com";
$admin_email2 = "";
$admin_email3 = "";

//alerts for adding classes. this is only if you wish to remind lab monitors of anything when they are adding classes to student records.
$alert = "";
?>