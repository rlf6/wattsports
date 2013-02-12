<?php

include('../database.php');


$ids = $_POST['variable'];
$array = explode(":",$ids);
$id = $array[0];
$table = $array[1];
if($table == '0') $qu ="DELETE FROM `wattball_team` WHERE `assoc_id`= $id";
if($table == '1') $qu ="DELETE FROM `wattball_team_members` WHERE `member_id`= $id";
if (mysql_query($qu))
{

echo "Successfully Deleted";

}	

else
{
echo "Delete was unsuccessful";
}
?>
