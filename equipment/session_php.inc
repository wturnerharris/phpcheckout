<?php

global $PHP_SELF;

// Get form variables
$Action = get_form_var('Action', 'string');
$NewUserName = get_form_var('NewUserName', 'string');
$NewUserPassword = get_form_var('NewUserPassword', 'string');
$TargetURL = get_form_var('TargetURL', 'string');
$returl = get_form_var('returl', 'string');

if (isset($cookie_path_override))
{
  $cookie_path = $cookie_path_override;
}
else
{
  $cookie_path = $PHP_SELF;
  // Strip off everything after the last '/' in $PHP_SELF
  $cookie_path = preg_replace('/[^/]*$/', '', $cookie_path);
}

global $auth;

if (!isset($auth["session_php"]["session_expire_time"]))
{
  // Default to the behaviour of previous versions of MRBS, use only
  // session cookies - no persistent cookie.
  $auth["session_php"]["session_expire_time"] = 0;
}

session_set_cookie_params($auth["session_php"]["session_expire_time"],
                          $cookie_path);
session_name("EquipmentCheckout");
session_start();

/*
  Target of the form with sets the URL argument "Action=SetName".
  Will eventually return to URL argument "TargetURL=whatever".
*/
if (isset($Action) && ($Action == "SetName"))
{
  /* First make sure the password is valid */
  if ($NewUserName == "")
  {

    // Unset the session variables
    if (isset($_SESSION))
    {
      $_SESSION = array();
    }
    else
    {
      $_SESSION = array();
    }
  }
  else
  {
    if (!authValidateUser($NewUserName, $NewUserPassword))
    {
    	//FAILURE!!
		include('includes/heading2.html'); 
      	echo "<span class='alert'>User Not authenticated.</span>";
      	printLoginForm($TargetURL);
		include('includes/footer.html'); 

      exit();
    }

    if (isset($_SESSION))
    {
      $_SESSION["user"] = $NewUserName;
    }
    else
    {
      global $HTTP_SESSION_VARS;
      $HTTP_SESSION_VARS["user"] = $NewUserName;
    }
  }
  // preserve the original $HTTP_REFERER by sending it as a GET parameter
  if (!empty($returl))
  {
    // check to see whether there's a query string already
    if (strpos($TargetURL, '?') === false)
    {
      $TargetURL .= "?returl=" . urlencode($returl);
    }
    else
    {
      $TargetURL .= "&returl=" . urlencode($returl);
    }
  }
//  header ("Location: $TargetURL"); /* Redirect browser to initial page */
  /* Note HTTP 1.1 mandates an absolute URL. Most modern browsers support relative URLs,
    which allows to work around problems with DNS inconsistencies in the server name.
    Anyway, if the browser cannot redirect automatically, the manual link below will work. */
  echo "<br>\n";
  //SUCCESS!!
	session_register($NewUserName);
	$_SESSION['auth'] = 'true';
	$_SESSION['time'] = time();
  // setcookie("EquipmentCheckout", $user, time()+60*60*24); 
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
  	echo "<p>Please click <a href=\"index.php\">here</a> if you're not redirected automatically to the page you requested.</p>\n";
  // Print footer and exit
  // print_footer(TRUE);
}

/*
  Display the login form. Used by two routines below.
  Will eventually return to $TargetURL.
*/
function printLoginForm($TargetURL)
{
  global $PHP_SELF, $HTTP_REFERER;
  global $returl;
?>
<div style="margin-left: auto; margin-right: auto; text-align: left; width: 300px;">
<p><strong>Enter your user name and password to login.</strong></p>
<form class="form_general" id="logon" method="post" action="<?php echo htmlspecialchars(basename($PHP_SELF)) ?>">
  <fieldset>
  <legend><span class="alert">Your personal EDM account logon info.</span></legend>
    <div>
      <label for="NewUserName">Username:</label>
      <input type="text" id="NewUserName" name="NewUserName">
    </div>
    <div>
      <label for="NewUserPassword">Password:</label>
      <input type="password" id="NewUserPassword" name="NewUserPassword">
    </div>
    <?php
    // We need to preserve the original calling page, so that it's there when we eventually get
    // to the TargetURL (especially if that's edit_entry.php).  If this is the first time through then $HTTP_REFERER holds
    // the original caller.    If this is the second time through we will have stored it in $returl.
    if (!isset($returl))
    {
      $returl = isset($HTTP_REFERER) ? $HTTP_REFERER : "";
    }
    echo "<input type=\"hidden\" name=\"returl\" value=\"" . htmlspecialchars($returl) . "\">\n";
    ?>
    <input type="hidden" name="TargetURL" value="<?php echo htmlspecialchars($TargetURL) ?>">
    <input type="hidden" name="Action" value="SetName">
    <div id="logon_submit">
      <input class="submit" type="submit" value=" <?php echo get_vocab('login') ?> ">
    </div>
  </fieldset>
</form>
</div>
<?php
  // Print footer and exit
  // print_footer(TRUE);
}

/*
  Target of the form with sets the URL argument "Action=QueryName".
  Will eventually return to URL argument "TargetURL=whatever".
*/
if (isset($Action) && ($Action == "QueryName"))
{
  print_header(0, 0, 0, 0, "");
  printLoginForm($TargetURL);
  exit();
}

/* authGet()
 * 
 * Request the user name/password
 * 
 * Returns: Nothing
 */
function authGet()
{
  global $PHP_SELF, $QUERY_STRING;

  print_header(0, 0, 0, 0, "");

  echo "<p>".get_vocab("norights")."</p>\n";

  $TargetURL = basename($PHP_SELF);
  if (isset($QUERY_STRING))
  {
    $TargetURL = $TargetURL . "?" . $QUERY_STRING;
  }
  printLoginForm($TargetURL);

  exit();
}

function getUserName()
{
  if (isset($_SESSION) && isset($_SESSION["UserName"]) && ($_SESSION["UserName"] != ""))
  {
    return $_SESSION["UserName"];
  }
  else
  {
    global $HTTP_SESSION_VARS;
    if (isset($HTTP_SESSION_VARS["UserName"]) && ($HTTP_SESSION_VARS["UserName"] != ""))
    {
      return $HTTP_SESSION_VARS["UserName"];
    }
  }
}

?>
