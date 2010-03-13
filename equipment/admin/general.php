<?php 

//variables

?>
<script type="text/javascript">

</script>		

<pre>
//options
$checkHours = false; //to enable kit-specific due date change to true
$dueToday = true; //only shows items due today on index page, false shows all
$weekends = false; // if open weekends, flag this
$dayClosed1 = "Sun"; // three-digit textual day, usually Sat
$dayClosed2 = "Mon"; // three-digit textual day, usually Sun

// due back BEFORE time on checkout
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
$fines = false; //3-strikes system default

//$strikes = false;
$maxStrike = 3;
$gracePeriod = 1800; // grace period in seconds; for strikes. using fines ignores the $amountDue unless the full frequency time has passed.

// fine controls
$fineAmount = 1.00; // amount of fine
$fineFreq = 86400; // amount of time per fine increment, in seconds
$maxFine = 3.00; // max amount of fine per kit

$root = "/equipment"; // using absolute paths. from the root to the program folder, with preceding slash and without trailing slash
$site_root = "http://134.74.235.40"; //domain name where your installation of checkout resides, no trailing slash

//admin email for error reporting
$admin_email1 = "wturnerharris@gmail.com";
$admin_email2 = "chase_a3@mac.com";
$admin_email3 = "";

//City College Note Specific
$alert = "Do NOT add any students to any of the Photo Classes without permission from Chase Browder.";	<input id="filter" name="filter" type="hidden" value="<?php echo $filter; ?>" />