<?php

include('../database.php');


$id = $_POST['variable'];
$array =explode(":",$_POST['variable']);

$name = $array['1'];
$id =  $array['0'];
$value= $array['2'];

//mysql_query("UPDATE `wattball_team` SET `$name`='$value' WHERE `assoc_id`='$id'");

echo "UPDATE `wattball_team` SET `$name`='$value' WHERE `assoc_id`='$id'";

?>
