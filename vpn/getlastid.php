<?php

include('../database.php');


$q = "SELECT MAX(`member_id`) FROM `wattball_team_members`";
$result = mysql_query($q);
$data = mysql_fetch_array($result);
$num = $data[0];
while(($num % 15) != 0)
{
$num++;
} 
echo $num+1;
?>
