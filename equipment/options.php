<?php
$config_file = "config.php";
$comment = "#";

$fp = fopen($config_file, "r");

while (!feof($fp)) {
  $line = trim(fgets($fp));
  if ($line != preg_grep("^$comment",$line)) {
    $pieces = explode("=", $line);
    $option = trim($pieces[0]);
    $value = trim($pieces[1]);
    $config_values[$option] = $value;
  }
}
fclose($fp);

printf($config_values);
?>