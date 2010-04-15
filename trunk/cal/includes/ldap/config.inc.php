<?php

// $Id: config.inc.php 1240 2009-11-04 16:01:21Z cimorrison $

/**************************************************************************
 *   MRBS Configuration File
 *   Configure this file for your site.
 *   You shouldn't have to modify anything outside this file
 *   (except for the lang.* files, eg lang.en for English, if
 *   you want to change text strings such as "Meeting Room
 *   Booking System", "room" and "area").
 **************************************************************************/

// The timezone your meeting rooms run in. It is especially important
// to set this if you're using PHP 5 on Linux. In this configuration
// if you don't, meetings in a different DST than you are currently
// in are offset by the DST offset incorrectly.
//
// When upgrading an existing installation, this should be set to the
// timezone the web server runs in.
//
$timezone = "Eastern";


 /***********************************************
 * Authentication settings - read AUTHENTICATION
 ***********************************************/

$auth["session"] = "php"; // How to get and keep the user ID. One of
           // "http" "php" "cookie" "ip" "host" "nt" "omni"
           // "remote_user"
$auth["type"] = "ldap"; // How to validate the user/password. One of "none"
                          // "config" "db" "db_ext" "pop3" "imap" "ldap" "nis"
                          // "nw" "ext".
//$auth["type"] = "db";
unset($auth["admin"]);              // Include this when copying to config.inc.php
$auth["admin"][] = "wharris"; // A user name from the user list. Useful 

// Configuration parameters for 'cookie' session scheme

// The encryption secret key for the session tokens. You are strongly
// advised to change this if you use this session scheme
$auth["session_cookie"]["secret"] = "This isn't a very good secret!";
// The expiry time of a session, in seconds
$auth["session_cookie"]["session_expire_time"] = (60*5); // 5 min
// Whether to include the user's IP address in their session cookie.
// Increases security, but could cause problems with proxies/dynamic IP
// machines
$auth["session_cookie"]["include_ip"] = TRUE;


// Configuration parameters for 'php' session scheme

// The expiry time of a session, in seconds
// N.B. Long session expiry times rely on PHP not retiring the session
// on the server too early. If you only want session cookies to be used,
// set this to 0.
$auth["session_php"]["session_expire_time"] = (60*5); // 5 minutes


// Cookie path override. If this value is set it will be used by the
// 'php' and 'cookie' session schemes to override the default behaviour
// of automatically determining the cookie path to use
$cookie_path_override = '';

// 'auth_ldap' configuration settings
// Where is the LDAP server
$ldap_host = "artserverx.arts.ccny.cuny.edu";

// If you have a non-standard LDAP port, you can define it here
// $ldap_port = 389;

// If you do not want to use LDAP v3, change the following to false
$ldap_v3 = true;

// If you want to use TLS, change the following to true
$ldap_tls = false;

// LDAP base distinguish name
// See AUTHENTICATION for details of how check against multiple base dn's
$ldap_base_dn = "cn=users,dc=artserverx,dc=arts,dc=ccny,dc=cuny,dc=edu";

// Attribute within the base dn that contains the username
$ldap_user_attrib = "uid";

//testing group
$group_filter = true;
$groupdn = "cn=checkout,cn=groups,dc=artserverx,dc=arts,dc=ccny,dc=cuny,dc=edu";
$group_attr = "memberUid";

// If you need to search the directory to find the user's DN to bind
// with, set the following to the attribute that holds the user's
// "username". In Microsoft AD directories this is "sAMAccountName"
//$ldap_dn_search_attrib = "uid";

// If you need to bind as a particular user to do the search described
// above, specify the DN and password in the variables below
//$ldap_dn_search_dn = "uid=ldapadmin,cn=users,dc=artserverx,dc=arts,dc=ccny,dc=cuny,dc=edu";
//$ldap_dn_search_password = "graph1cs";

//if using ldapsearch to construct your search
//ldapsearch -x -LLL -b "dc=artserverx,dc=arts,dc=ccny,dc=cuny,dc=edu" objectClass=apple-group

// 'auth_ldap' extra configuration for ldap configuration of who can use
// the system
// If it's set, the $ldap_filter will be combined with the value of
// $ldap_user_attrib like this:
//   (&($ldap_user_attrib=username)($ldap_filter))
// After binding to check the password, this check is used to see that
// they are a valid user of mrbs.
$ldap_filter = "departmentNumber=checkout";

?>
