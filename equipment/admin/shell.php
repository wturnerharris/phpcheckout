<?php
$pw = "graph1cs";
$output = shell_exec("ldapadd -D \"uid=ldapadmin,cn=users,dc=artserverx,dc=arts,dc=ccny,dc=cuny,dc=edu\" -x -w $pw -f /Library/WebServer/Documents/equipment/admin/userTemplate");
echo "<pre>$output</pre>";

?>