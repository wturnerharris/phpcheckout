<?php
$config_file = "config.php";
$comment = "#";

$fp = fopen($config_file, "r");

while (!feof($fp)) {
  $line = trim(fgets($fp));
  if (!preg_match("/^$comment/",$line)) {
    $pieces = explode("=", $line);
    $option = trim($pieces[0]);
    $value = trim($pieces[1]);
    $config_values[$option] = $value;
  }
}
fclose($fp);
echo "<pre>";
print_r($config_values);
echo "<BR>".$config_values['$hostname_equip'];
?>