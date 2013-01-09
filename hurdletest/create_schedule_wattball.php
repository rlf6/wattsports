<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1); 
	
include("../database.php");


// ========== Work out the start date for the desired event =========
$event_id = $_POST['event_id'];
$query = "SELECT * FROM event WHERE event_id='$event_id'";
$result_array = mysql_fetch_array( mysql_query( $query ) );

$event_name = $result_array['name']; 
$date_start_php = strtotime( $result_array['start_date'] );
$date_start_mysql = date( 'Y-m-d H:i:s', $date_start_php );
$date_end_php = strtotime( $result_array['end_date'] );
$date_end_mysql = date( 'Y-m-d H:i:s', $date_end_php );

// ============= Prep ================
$query = "SELECT * FROM wattball_team";
$result = mysql_query($query);
$num_teams = mysql_num_rows( $result );

if (($num_teams % 2)==0) //for an even number of teams
{
	$m = $num_teams;
	$rounds = $m - 1;
	//$games = 2d array ---skipping for now as php flexible enough to add to array without defining length
	$x = 1;	
	$slots = (($num_teams-1)/2)*$rounds;
}
else //for an odd number of teams
{
	$m = $num_teams + 1;
	$rounds = $num_teams;
	$x = 0; //0 becomes a dummy value and we will not count any games it is paired in
	$slots = ($num_teams/2)*$rounds;
}
$y=0;
for($x; $x<=$num_teams; $x++)
{
	$players[$y]=$x;
	$y++;
}

// =============Pairing Algorithm ===============
$round = 1;
$x=0;
for($i=0; $i < $m/2; $i++)
{
	$part1[$i]=$players[$x];
	$x++;
}
for($i=0; $i < $m/2; $i++)
{
	$part1[$i]=$players[$x];
	$x++;
}
$x=($round-1)*($m/2)


?>
