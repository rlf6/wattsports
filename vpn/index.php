<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

include("../details.php");

mysql_connect($host, $username, $password);
mysql_select_db($database);

echo " Hello ". $username;

?>