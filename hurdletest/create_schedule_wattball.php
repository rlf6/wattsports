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
	$p = 0; //variable for looping when pairing in round robin
}
else //for an odd number of teams
{
	$m = $num_teams + 1;
	$rounds = $num_teams;
	$x = 0; //0 becomes a dummy value and we will not count any games it is paired in
	$slots = ($num_teams/2)*$rounds;
	$p = 1; //justification -- we want to ignore the first pairing if we have dummy team 0
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
$x=0;
for($i=0; $i < $m/2; $i++)
{
	$part2[$i]=$players[$x];
	$x++;
}
$x=($round-1)*($m/2)

for($p; $p < ($m/2)
{
	games[$x][0]=part1[$p];
	games[$x][1]=part2[$p];
	$x++;
}
$round++
//loop round 2 to number of rounds
for($round; $round <= $rounds; $round++)
{
	//round robin algorithm
	$temp1 = $part1[1];
	for($j = 2; $j < (m/2); $j++)
	{
		$temp2 = $part1[$j];
		$part1[$j] = $temp1;
		$temp1 = $temp2;
	}
	for($j; $j>=0; $j--)
	{
		$temp2 = $part2[$j];
		$part2[$j] = $temp1;
		$temp1 = $temp2;
	}
	$part1[1]=$temp1;
	$x = ($round-1)*($m/2)	
	if (($num_teams % 2) == 0)
	{ $p = 0;}
	else
	{ $p = 1;}
	for($p; $p < ($m/2)
	{
		games[$x][0]=part1[$p];
		games[$x][1]=part2[$p];
		$x++;
	}
	$round++;
}

//=============calculate available slots====================
//calculate days
public function getNumberOfDays($startDate, $endDate, $exclude)
{
    // d/m/Y
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $oneday = new DateInterval("P1D");
	$x= 0;
	
    $days = array();

    /* Iterate from $start up to $end+1 day, one day in each iteration.
    We add one day to the $end date, because the DatePeriod only iterates up to,
    not including, the end date. */
    foreach(new DatePeriod($start, $oneday, $end->add($oneday)) as $day) {
        $day_num = $day->format("N"); /* 'N' number days 1 (mon) to 7 (sun) */
        if($exclude)
		{
			if($day_num < 6) { /* weekday */
				$days[$x] = $day->format("Y-m-d");
				$x++;
			} 
		}
		else
		{
				$days[$x] = $day->format("Y-m-d");
				$x++;
		}
    }

    return $days;       
}

if (!($_POST['weekends']))
{
	$exclude=true;
}
else
{	$exclude=false;	}
$daysArray = getNumberOfDays($date_start_php, $date_end_php, $exclude);






?>
