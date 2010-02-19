<?PHP 

$ServerKitID = $row_Recordset3['KitID'];
mysql_select_db($database_kit, $equip);
$query_Recordset5 = "SELECT * FROM checkedout WHERE KitID = $ServerKitID AND DateIn = ''";
$Recordset5 = mysql_query($query_Recordset5, $equip) or die(mysql_error());
$row_Recordset5 = mysql_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysql_num_rows($Recordset5);
?>
