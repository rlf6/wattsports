<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
//include ("dbfunctions.php");

	
include("/database.php");
$no = 0;
$no_mem = $_POST['no_mem'];

 $team_name = $_POST['team_name'];
 $no_mem = $_POST['no_mem'];
 $assoc = $_POST['assoc'];
 $addre = $_POST['addre'];
 $email = $_POST['email'];


$qu = "INSERT INTO `wattball_team` VALUES('$assoc','$team_name','$email','$addre')";

//runQuery($qu);

while( $no < $no_mem){
	
${'mem'.$no} = array( $_POST['name'.$no],$_POST['surname'.$no],$_POST['address'.$no],$_POST['dob'.$no],$_POST['phone'.$no],$_POST['email'.$no],$_POST['position'.$no]);
$qu2 = "INSERT INTO `wattball_team_members` VALUES('','".${'mem'.$no}['0']."','".${'mem'.$no}['1']."','".${'mem'.$no}['2']."','".${'mem'.$no}['3']."','".${'mem'.$no}['4']."','".${'mem'.$no}['5']."','".${'mem'.$no}['6']."','0','$assoc')"; 
echo "Inserted the following values '".${'mem'.$no}['0']."', '".${'mem'.$no}['1']."', '".${'mem'.$no}['2']."', '".${'mem'.$no}['3']."', '".${'mem'.$no}['4']."', '".${'mem'.$no}['5']."', '".${'mem'.$no}['6']."'<br />";
mysql_query($qu2);
$no++;
}
//print_r($mem0);

?>
