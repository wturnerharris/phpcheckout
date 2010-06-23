<?php

	//get post variables
	$uid = $_POST['uid'];
	$delete = $_POST['delete'];

	$ldap_host = "artserverx.arts.ccny.cuny.edu";
	$ds = ldap_connect($ldap_host);
	$dn = "uid=ldapadmin,cn=users,dc=artserverx,dc=arts,dc=ccny,dc=cuny,dc=edu";
	$baseDn = "cn=users,dc=artserverx,dc=arts,dc=ccny,dc=cuny,dc=edu";
	$pw = "graph1cs";
	if ($ds) {
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		// bind with appropriate dn to give update access
		$b = ldap_bind($ds, $dn, $pw);

		//artificial search
		$r = ldap_search($ds, $baseDn, "(uid=$uid)");
		$result = ldap_get_entries($ds, $r);

		if ($result["count"] == 1 && !isset($delete)) {
			 $display=true;
			 for ($i=0; $i<=$result["count"];$i++) {
         for ($j=0;$j<=$result[$i]["count"];$j++){
           echo $result[$i][$j].": ".$result[$i][$result[$i][$j]][0]."<br/>";
        }
      }
    	ldap_close($ds);
		}
    // no entries so add it
    if ($result["count"] < 1 && isset($uid) && !isset($delete))
		{
    	$r1 = ldap_search($ds, $baseDn, "uid=*");
      $result1 = ldap_get_entries($ds, $r1);
      $uidNums = array();
      for($i=0;$i<$result1["count"];$i++)
      {
        $last = $result1[$i]["uidnumber"][0];
        array_push($uidNums, $last);
        sort($uidNums);
      }
			$maxUid = array_pop($uidNums);
      $maxUid = $maxUid+1;
      $makeGuid = strtoupper(md5($uid));
      $GUID = substr($makeGuid, 0, 8)."-".substr($makeGuid, 8, 4)."-".substr($makeGuid, 12, 4)."-".substr($makeGuid, 16, 4)."-".substr($makeGuid, 20, 12);
			$quotaBytes = "2147483648";
			$path = "/Network/Servers/artserverx.arts.ccny.cuny.edu/Volumes/edm/edm2010";
			$webPath = "/Library/WebServer/Documents/equipment/admin/userTemplate";
			$userPw = base64_encode(pack('H*',md5('1234')));
			$f = fopen($webPath, "w");
			$add = 
		    "dn: uid=$uid,$baseDn\n".
        "apple-user-homeurl: <home_dir><url>afp://$ldap_host/edm2010</url><path>/$uid</path></home_dir>\n".
        "givenName: FirstName\n".
        "apple-generateduid: $GUID\n".
        "sn: LastName\n".
        "telephoneNumber: 5129635013\n".
        "userPassword:: $userPw\n".
        "loginShell: /bin/bash\n".
        "uidNumber: $maxUid\n".
        "gidNumber: 20\n".
        "mail: Email\n".
        "uid: $uid\n".
        "objectClass: inetOrgPerson\n".
        "objectClass: posixAccount\n".
        "objectClass: shadowAccount\n".
        "objectClass: apple-user\n".
        "objectClass: extensibleObject\n".
        "objectClass: organizationalPerson\n".
        "objectClass: top\n".
        "objectClass: person\n".
        "cn: $uid\n".
        "homeDirectory: $path/$uid\n".
        "apple-user-homequota: $quotaBytes\n";
			fwrite($f, $add);
			fclose($f);
	    // add data to directory

	    //using shell method due to errors with ldap_add()
			$output = shell_exec("ldapadd -D $dn -x -w $pw -f $webPath");
			if ($output) {
        $output = shell_exec("dscl -u ldapadmin -P $pw /LDAPv3/127.0.0.1 -passwd /Users/$uid 1234 2>&1 &");
        echo "Everything seems to be ok. Adding entry via shell..."; 
				$script = true;
   		}
	    /* ***IF LDAP_BIND WORKS***
			//$a = @ldap_add($ds, "uid=$uid,$baseDn", $info);
	    if ($a){
        ldap_close($ds);
  			echo "Successfully added new user: $uid";
	    } else {
        ldap_close($ds);
	    	echo "Add unsuccessful.";
			}*/
    }
		if (isset($delete) && isset($uid))
		{
	    ldap_delete($ds,"uid=$uid,$baseDn");
	    echo "Now deleting user $uid.";
	  }
	} else {
    echo "Unable to connect to LDAP server";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mass Import Form</title>
<link href="../includes/equip.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../includes/prototype.js"></script>
<?php if ($script) { ?>
<script type="text/javascript">
function refreshPage(){
	$('form1').submit();
}
setTimeout('refreshPage();',1000);
</script>
<?php } ?>
</head>

<body>
<div id="admin-main">
		<div id="admin-page">
      <div id="showAdd">
        <form id="form1" name="form1" action="ldap_functions.php" method="post">
        UID: <input type="text" name="uid" value="<?php echo $uid; ?>"/>
        <input type="submit" value="Submit" />
        <?php if ($display == true) {
          echo "Delete: <input name=\"delete\" type=\"checkbox\" />";
        }
        ?>
        </form>
      </div>
      <p>&nbsp;</p>
		</div>
</div>
</body>
</html>