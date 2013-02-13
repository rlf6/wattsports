<?php

include('../database.php');


$id = $_POST['variable'];

$qu ="DELETE FROM `hurdler` WHERE `id`= $id";
if (mysql_query($qu))
{

echo "Successfully Deleted";

}	

else
{
echo "Delete was unsuccessful";
}
?>
