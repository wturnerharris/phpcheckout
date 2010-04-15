<?php
function unslashes($s)
{
  if (get_magic_quotes_gpc())
  {
    return stripslashes($s);
  }
  else
  {
    return $s;
  }
}
function get_form_var($variable, $type = 'string')
{
  // We use some functions from here
  // require_once "functions.inc";

  if ($type == 'array')
  {
    $value = array();
  }
  else
  {
    $value = NULL;
  }

  if (!empty($_POST) && isset($_POST[$variable]))
  {
    if ($type == 'array')
    {
      $value = (array)$_POST[$variable];
    }
    else
    {
      $value = $_POST[$variable];
    }
  }
  else if (!empty($HTTP_POST_VARS) && isset($HTTP_POST_VARS[$variable]))
  {
    if ($type == 'array')
    {
      $value = (array)$HTTP_POST_VARS[$variable];
    }
    else
    {
      $value = $HTTP_POST_VARS[$variable];
    }
  }
  if (!empty($_GET) && isset($_GET[$variable]))
  {
    if ($type == 'array')
    {
      $value = (array)$_GET[$variable];
    }
    else
    {
      $value = $_GET[$variable];
    }
  }
  else if (!empty($HTTP_GET_VARS) && isset($HTTP_GET_VARS[$variable]))
  {
    if ($type == 'array')
    {
      $value = (array)$HTTP_GET_VARS[$variable];
    }
    else
    {
      $value = $HTTP_GET_VARS[$variable];
    }
  }
  if ($value != NULL)
  {
    if ($type == 'int')
    {
      $value = intval(unslashes($value));
    }
    else if ($type == 'string')
    {
      $value = unslashes($value);
    }
    else if ($type == 'array')
    {
      foreach ($value as $arrkey => $arrvalue)
      {
        $value[$arrkey] = unslashes($arrvalue);
      }
    }
  }
  return $value;
}


// -- PHP_SELF --
if (!empty($_SERVER) && isset($_SERVER['PHP_SELF']))
{
  $PHP_SELF = $_SERVER['PHP_SELF'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['PHP_SELF']))
{
  $PHP_SELF = $HTTP_SERVER_VARS['PHP_SELF'];
}

// -- PHP_AUTH_USER --
if (!empty($_SERVER) && isset($_SERVER['PHP_AUTH_USER']))
{
  $PHP_AUTH_USER = $_SERVER['PHP_AUTH_USER'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['PHP_AUTH_USER']))
{
  $PHP_AUTH_USER = $HTTP_SERVER_VARS['PHP_AUTH_USER'];
}

// -- PHP_AUTH_PW --
if (!empty($_SERVER) && isset($_SERVER['PHP_AUTH_PW']))
{
  $PHP_AUTH_PW = $_SERVER['PHP_AUTH_PW'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['PHP_AUTH_PW']))
{
  $PHP_AUTH_PW = $HTTP_SERVER_VARS['PHP_AUTH_PW'];
}

// -- REMOTE_USER --
if (!empty($_SERVER) && isset($_SERVER['REMOTE_USER']))
{
  $REMOTE_USER = $_SERVER['REMOTE_USER'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['REMOTE_USER']))
{
  $REMOTE_USER = $HTTP_SERVER_VARS['REMOTE_USER'];
}

// -- REMOTE_ADDR --
if (!empty($_SERVER) && isset($_SERVER['REMOTE_ADDR']))
{
  $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['REMOTE_ADDR']))
{
  $REMOTE_ADDR = $HTTP_SERVER_VARS['REMOTE_ADDR'];
}

// -- QUERY_STRING --
if (!empty($_SERVER) && isset($_SERVER['QUERY_STRING']))
{
  $QUERY_STRING = $_SERVER['QUERY_STRING'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['QUERY_STRING']))
{
  $QUERY_STRING = $HTTP_SERVER_VARS['QUERY_STRING'];
}

// -- HTTP_ACCEPT_LANGUAGE --
if (!empty($_SERVER) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
  $HTTP_ACCEPT_LANGUAGE = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE']))
{
  $HTTP_ACCEPT_LANGUAGE = $HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE'];
}

// -- HTTP_REFERER --
if (!empty($_SERVER) && isset($_SERVER['HTTP_REFERER']))
{
  $HTTP_REFERER = $_SERVER['HTTP_REFERER'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_REFERER']))
{
  $HTTP_REFERER = $HTTP_SERVER_VARS['HTTP_REFERER'];
}

// -- HTTP_HOST --
if (!empty($_SERVER) && isset($_SERVER['HTTP_HOST']))
{
  $HTTP_HOST = $_SERVER['HTTP_HOST'];
}
else if (!empty($HTTP_SERVER_VARS) && isset($HTTP_SERVER_VARS['HTTP_HOST']))
{
  $HTTP_HOST = $HTTP_SERVER_VARS['HTTP_HOST'];
}

?>
