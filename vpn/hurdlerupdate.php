<?php

include('../database.php');


$newid = $_POST['variable'];
$array = explode(":",$_POST['variable']);
$assoc = $_POST['assoc'];
$name = $array['2'];
$id =  $array['0'];
$group = $array['1'];
$value = $array['3'];
if(  $group =='hurdler' )
{
	if($name == 'id'){
		$exists = mysql_query("SELECT * FROM `hurdler` WHERE `id` = $value");
		$exist = mysql_num_rows($exists);
		if($exist > 0 && $value != $id)
		{ 
		echo "ID already Exists"; 
		die;
	}
	}

	
	if(mysql_query("UPDATE hurdler SET `$name`='$value' WHERE `id`='$id'"))
	{
		echo"Updated";
	}
	elseif(!empty($newid))
	{
		mysql_query("INSERT INTO `hurdler` (`id`) VALUES('$id')");
		echo "New Person Added";
	}
	else
	{
		echo "Update Failed";
	}
	
}
if( $group =='watt' )
{
	if( $name == 'member_id')
	{
		$exists = mysql_query("SELECT * FROM `wattball_team_members` WHERE `member_id` = $value");
		$exist = mysql_num_rows($exists);
		if($exist > 0  && $value != $id)
		{ 
			echo "ID already Exists"; 
			die;
		}
	}

	if(mysql_query("UPDATE wattball_team_members SET `$name`='$value' WHERE `member_id`='$id'"))
	{
		echo"Updated";
	}
	elseif(!empty($id))
	{
		mysql_query("INSERT INTO `wattball_team_members` (`member_id`,`team_assoc_id`) VALUES('$id','$assoc')");
		echo "New Player Added";
		
	}
	else
	{
		echo "Update Failed";
	}

}

if( $group =='team' )
{
	if( $name == 'assoc_id')
	{
		$exists = mysql_query("SELECT * FROM `wattball_team` WHERE `assoc_id` = $value");
		$exist = mysql_num_rows($exists);
		if($exist > 0)
		{ 
			echo "ID already Exists"; 
			die;
		}
		
		$query =   "UPDATE `wattball_team`
					SET `wattball_team`.`assoc_id`='$value'
					WHERE `wattball_team`.`assoc_id`='$id'";

		mysql_query($query);
		echo"Updated assoc_id";
	
	}
	elseif(!empty($newid) && empty($value))
	{
		mysql_query("INSERT INTO `wattball_team` (`assoc_id`) VALUES('$id')");
		echo "New Team Added";
	}
	elseif(mysql_query("UPDATE wattball_team SET `$name`='$value' WHERE `assoc_id`='$id'"))
	{
		echo "Updated";
	}

}

?>
